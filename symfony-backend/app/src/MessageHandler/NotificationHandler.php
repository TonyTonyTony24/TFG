<?php

namespace App\MessageHandler;

use App\Message\Notification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Entity\Contacto;
use Doctrine\ORM\EntityManagerInterface;

#[AsMessageHandler]
class NotificationHandler
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }



    public function __invoke(Notification $message)
    {
        $entity=new Contacto();
        $entity->setName($message->content->name);
        $entity->setEmail($message->content->email);
        $entity->setTelefono($message->content->telefono);
        $entity->setMensaje($message->content->mensaje);
        $entity->setFecha(new \DateTime());
        $this->em->persist($entity);
        $this->em->flush();
    }

}