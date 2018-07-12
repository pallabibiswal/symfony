<?php

namespace ApiBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ResponseListener
{
    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelResponse()
    {
        $log = $this->container->get('logger');
        $log->info('In Response');
    }
}