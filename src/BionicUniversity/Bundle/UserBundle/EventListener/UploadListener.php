<?php
namespace BionicUniversity\Bundle\UserBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Oneup\UploaderBundle\Uploader\File\FilesystemFile;
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
        $avatar = $event->getFile();
        $path = $avatar->getBasename();

        $user = $this->securityContext->getToken()->getUser();
        $user->setAvatar($path);

        $em = $this->doctrine->getManager();
        $em->persist($user);
        $em->flush();
    }
}