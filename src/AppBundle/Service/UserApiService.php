<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\VoteRepository;
use AppBundle\Entity\Vote;



/**
 * Class UserApiService
 * @package AppBundle\Service
 */
class UserApiService
{

    protected $entity_manager;
    public function __construct(EntityManagerInterface $entity)
    {
        $this->entity_manager = $entity;
    }

    /**
     * @return array
     */
    public function getAllUsers()
    {
        $repo = $this->entity_manager->getRepository('AppBundle:Vote');
        return $repo->getAllData();
    }

    /**
     * @param $request
     */
    public function createUser($request)
    {
        $repo = $this->entity_manager->getRepository('AppBundle:Vote');
        return $repo->createNewUser($request);
    }
}