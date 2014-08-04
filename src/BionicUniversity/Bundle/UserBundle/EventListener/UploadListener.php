<?php
namespace BionicUniversity\Bundle\UserBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

class UploadListener
{
    private $securityContext;
    private $entityManager;
    private $doctrine;

    public function __construct($doctrine, EntityManagerInterface $em, SecurityContextInterface $securityContext)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $em;
        $this->securityContext = $securityContext;
    }

    public function onUpload(PostPersistEvent $event)
    {
        $request = $event->getRequest();

        $avatar = $event->getFile();
        $path = $avatar->getBasename();
        if ('oneup_uploader.controller.avatar:upload' === $request->get('_controller')) {
            $user = $this->securityContext->getToken()->getUser();
            $user->setAvatar($path);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
        }
    }
}
