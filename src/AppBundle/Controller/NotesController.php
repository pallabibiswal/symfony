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


class NotesController extends Controller
{
    /**
     * @Route("/", name = "home_page")
     */
    public function indexAction()
    {
        return new Response("eferv")
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
    public function uploadFile()
    {
        $vote = new Vote();
        $userob = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($_POST['ref_id']);

        $vote->setFile($_POST['file']);
        $vote->setUser($userob);
        $entity_manager = $this->getDoctrine()->getManager();
        $entity_manager->persist($vote);
        $entity_manager->flush();

        return $this->render("index.html.twig");
    }
}