<?php

namespace BionicUniversity\Bundle\MessageBundle\Controller\Front;

use BionicUniversity\Bundle\MessageBundle\BionicUniversityMessageBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\MessageBundle\Entity\Message;
use BionicUniversity\Bundle\MessageBundle\Form\Type\MessageType;

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
        $entity = new Message();
        $form = $this->createCreateForm($entity);

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $outcomingMessages = $em->getRepository('BionicUniversityMessageBundle:Message')->findByFromUser($user, ['createdAt'=>'desc']);
        $incomingMessages = $em->getRepository('BionicUniversityMessageBundle:Message')->findByToUser($user, ['createdAt'=>'desc']);

        return $this->render('BionicUniversityMessageBundle:Message:Front/messages.html.twig',
            array(
                'out_mess' => $outcomingMessages,
                'in_mess' => $incomingMessages,
                'form' => $form->createView(),
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
        $entity->setFromUser($this->getUser());

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('messages'));
    }

    /**
     * Creates a form to create a Message entity.
     *
     * @param Message $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Message $entity)
    {
        $form = $this->createForm('send_message', $entity, array(
            'action' => $this->generateUrl('message_create_front'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}
