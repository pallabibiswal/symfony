<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class DefaultController extends FOSRestController
{
    /**
     * @Rest\Get("/check")
     *
     * @param $request
     * @return string
     */
    public function indexAction(Request $request)
    {
        return new Response("Hello");
    }
}
