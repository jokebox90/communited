<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener()]
class JsonLoginSuccesListener
{
    public function __invoke(LoginSuccessEvent $event): void
    {
        $passport = $event->getPassport();
        $passport->addBadge(new RememberMeBadge());

        // Add _remember_me from JSON body to attributes
        $request = $event->getRequest();
        $data = json_decode($request->getContent());
        if (isset($data->_remember_me) && $data->_remember_me === true) {
            $request->attributes->set('_remember_me', true);
        }
    }
}
