<?php

namespace AppBundle\Controller;

use AppBundle\Service\UserApiService;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/user")
     * @param  $request
     * @return View
     */
    public function allUsers(Request $request)
    {
        $service = $this->container->get(UserApiService::class);
        $info = $service->getAllUsers();

        if (empty($info)) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($info);
    }
}