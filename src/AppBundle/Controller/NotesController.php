<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class NotesController extends Controller
{
    /**
     * @Route("/", name = "home_page")
     */
    public function indexAction()
    {
        return $this->render("Notes/index.html.twig");
    }

    /**
     * @Route("/data", name="save_data")
     */
    public function SaveData()
    {
        print_r($_POST);exit;
//        return new Response("pallabi");
    }
}