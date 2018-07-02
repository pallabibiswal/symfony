<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Vote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->render("index.html.twig");
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
        $user_ob = $this->getUser();
        $vote = new Vote();
        $form = $this->createFormBuilder($vote)
            ->add('file', FileType::class, array('label' => 'Photo (png, jpeg)'))
            ->add('save', SubmitType::class, array('label' => 'Upload'))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $vote->getFile();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $fileName);
            $vote->setFile($fileName);
            $vote->setUser($user_ob);
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($vote);
            $entity_manager->flush();
            return $this->render("index.html.twig");
        } else {
            return $this->render('upload_pic.html.twig', array(
                'form' => $form->createView(),
                'user' => $user_ob
            ));
        }
    }

    /**
     * @return string
     */
    public function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}