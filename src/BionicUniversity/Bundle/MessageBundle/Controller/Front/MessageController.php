<?php

namespace BionicUniversity\Bundle\MessageBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\MessageBundle\Entity\Message;
use BionicUniversity\Bundle\MessageBundle\Form\MessageType;

/**
 * Message controller.
 *
 */
class MessageController extends Controller
{

    /**
     * Lists all Message entities.
     *
     */
    public function messagesAction()
    {
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();

        $listOfUsers=$em->getRepository('BionicUniversityUserBundle:User')->findAll();

        $outcomingMessages=$em->getRepository('BionicUniversityMessageBundle:Message')->findByFromUser($user->getId());
        $incomingMessages=$em->getRepository('BionicUniversityMessageBundle:Message')->findByToUser($user->getId());

        return $this->render('BionicUniversityMessageBundle:Message:Front/messages.html.twig',
            array(
                'out_mess'=>$outcomingMessages,
                'in_mess'=>$incomingMessages,
                'toUsers'=> $listOfUsers
                 )
        );
    }

    /**
     * Creates a new Message entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Message();

        $em = $this->getDoctrine()->getManager();

        $toUser=$em->getRepository('BionicUniversityUserBundle:User')->findOneById($_POST['toUser']);

        $entity->setFromUser($this->getUser());
        $entity->setToUser($toUser);
        $entity->setBody($_POST['text']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('messages'));
    }

}
