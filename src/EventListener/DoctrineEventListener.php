<?php

namespace App\EventListener;


use App\Entity\Movie;
use App\Service\EmailDispatch;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DoctrineEventListener
{

    private $emailDispatch;

    public function __construct(EmailDispatch $emailDispatch)
    {
        $this->emailDispatch = $emailDispatch;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if ($entity instanceof Movie) {
            $this->emailDispatch->sendEventToEmailService($entity);
        }
    }
}
