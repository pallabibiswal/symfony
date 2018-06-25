<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class NotesController extends Controller
{
    /**
     * @Route("/", name = "home_page")
     */
    public function indexAction(SerializerInterface $serializer)
    {
//        return $this->render("Notes/index.html.twig",[
//            "name" => "Pallabi"
//        ]);

        $data = $serializer->serialize(array("name" => "pallabi"), 'json');
        return new Response($data);
    }
}