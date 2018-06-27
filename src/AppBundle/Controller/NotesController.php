<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;


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
     */
    public function renderRegistrationForm()
    {
        $form = $this->createFormBuilder()
           ->add('email', TextType::class)
           ->add('username', TextType::class)
           ->add('password', TextType::class)
           ->add('confirm_password', TextType::class)
           ->add('save', SubmitType::class, ['label' => 'Register', 'attr' => ['class'=>'btn btn-primary mb-2']])
           ->getForm();

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}