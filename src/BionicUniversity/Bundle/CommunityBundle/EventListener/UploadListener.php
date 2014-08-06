<?php
namespace BionicUniversity\Bundle\CommunityBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;

class UploadListener
{
    private $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function onUpload(PostPersistEvent $event)
    {

        $request = $event->getRequest();
        $gallery = $request->get('community');
        if ('oneup_uploader.controller.community_logo:upload' === $request->get('_controller')) {
            $avatar = $event->getFile();
            $path = $avatar->getBasename();

            //$em = $this->getDoctrine()->getManager();
            $community = $this->entityManager->getRepository('BionicUniversityCommunityBundle:Community')->find($gallery);
            $community->setAvatar($path);

            //$this->doctrine->getManager();
            $this->entityManager->persist($community);
            $this->entityManager->flush();
        }
    }
}
