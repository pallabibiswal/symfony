<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Vote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class NotesController
 * @package AppBundle\Controller
 */
class NotesController extends Controller
{
    /**
     * @Route("/", name = "home_page")
     */
    public function indexAction()
    {
        $data = $this->getDoctrine()->getManager()->getRepository('AppBundle:Vote')
            ->getAllData();

        return $this->render("index.html.twig", [
            'data' => $data
        ]);
    }

    /**
     * @Route("/register", name="register_page")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setEnabled(1);

            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($user);
            $entity_manager->flush();

            return $this->render('profile.html.twig',[
                'name' => $user->getUsername(),
                'id' => $user->getId()
            ]);
        }

        return $this->render(
            'register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/profile/pic", name="save_image")
     */
    public function uploadFile(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Vote');
        $vote_data = $repository->findOneBy(
            array('user' => $this->getUser()->getId())
        );
        return $this->render('upload_pic.html.twig', array(
            'user' => $vote_data
        ));
    }

    /**
     * @Route("/profile/pic/save", name="upload_image")
     */
    public function saveFileInDb(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Vote');
        $vote_data = $repository->findOneBy(
            array('user' => $this->getUser()->getId())
        );
        $vote =  new Vote();
        $form = $this->createFormBuilder($vote)
            ->add('file', FileType::class, array('label' => 'Photo (png, jpeg)'))
            ->add('save', SubmitType::class, array('label' => 'Upload'))
            ->getForm();
        $form->handleRequest($request);
        if (empty($vote_data) && $form->isSubmitted() && $form->isValid()) {
            $file = $vote->getFile();
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $fileName);
            $vote->setFile($fileName);
            $vote->setUser($this->getUser());
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($vote);
            $entity_manager->flush();
            $url = $this->generateUrl("home_page");
            return $this->redirect($url);
        } elseif(!empty($vote_data) && $form->isSubmitted() && $form->isValid()) {
            $file = $vote->getFile();
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
            if (file_exists($this->getParameter('photos_directory') . '/'. $vote_data->getFile())) {
                unlink($this->getParameter('photos_directory') . '/'. $vote_data->getFile());
            }
            $file->move($this->getParameter('photos_directory'), $fileName);
            $vote_data->setFile($fileName);
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($vote_data);
            $entity_manager->flush();
            $url = $this->generateUrl("home_page");
            return $this->redirect($url);
        } else {
            return $this->render('change_image.html.twig', [
                   'form' => $form->createView()
                ]
            );
        }
    }

    /**
     * @return string
     */
    public function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/save/like", options={"expose"=true}, name = "save_likes")
     * @param Request $request
     * @return Response
     */
    public function saveLikes(Request $request)
    {
        $id = $request->get('id');
        if (empty($id)) {
            return false;
        }

        $entity = $this->getDoctrine()->getRepository('AppBundle:Vote');
        $vote = $entity->find($id);
        $vote->setLikes($vote->getLikes() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($vote);
        $em->flush();

        return new JsonResponse($vote->getLikes());
    }
}