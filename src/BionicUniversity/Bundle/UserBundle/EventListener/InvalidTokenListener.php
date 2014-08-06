<?php

namespace BionicUniversity\Bundle\UserBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class InvalidTokenListener
{
    public function __construct(CsrfTokenManagerAdapte)
    {

    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

// ...
    }
}
