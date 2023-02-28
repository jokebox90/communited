<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class DebugXmlHttpRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(private KernelInterface $kernel)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$this->kernel->isDebug()) {
            return;
        }

        $request = $event->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->set('Symfony-Debug-Toolbar-Replace', 1);
    }
}
