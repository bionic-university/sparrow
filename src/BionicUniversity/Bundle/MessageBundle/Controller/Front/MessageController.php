<?php

namespace BionicUniversity\Bundle\MessageBundle\Controller\Front;

use BionicUniversity\Bundle\MessageBundle\BionicUniversityMessageBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\MessageBundle\Entity\Message;

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
    public function messagesAction($id = null)
    {
        $user=$this->getUser();

        $em = $this->getDoctrine()->getManager();
        $outcomingMessages = $em->getRepository('BionicUniversityMessageBundle:Message')->findByFromUser($user, ['createdAt'=>'desc']);
        $incomingMessages = $em->getRepository('BionicUniversityMessageBundle:Message')->findByToUser($user, ['createdAt'=>'desc']);

        $message = new Message();
        if(null !== $id){
            $receiver = $em->getRepository('BionicUniversityUserBundle:User')->find($id);
            if(!$receiver){
                throw $this->createNotFoundException('User not found');
            }
            $message->setToUser($receiver);
        }
        $form = $this->createCreateForm($message);


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
        $em = $this->getDoctrine()->getManager();

        $entity = new Message();
        $entity->setFromUser($this->getUser());

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

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
            'action' => $this->generateUrl('message_create_front')
        ));

        $form->add('submit', 'submit', array('label' => 'Send', 'attr'=>['class' => 'btn btn-success pull-right']));

        return $form;
    }
}
