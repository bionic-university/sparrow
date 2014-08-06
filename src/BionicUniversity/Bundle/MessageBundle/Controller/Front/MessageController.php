<?php

namespace BionicUniversity\Bundle\UserBundle\Doctrine\ORM;
namespace BionicUniversity\Bundle\MessageBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Doctrine\ORM\UserRepository;
use BionicUniversity\Bundle\MessageBundle\Entity\Message;
use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\UserBundle\Entity\Friendship;

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
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if(null != $id)
        {
            $messages = $em->getRepository("BionicUniversityMessageBundle:Message")->findMessages($user,$id);
            $interlocutor = $em->getRepository("BionicUniversityUserBundle:User")->find($id);
        }
        else
        {
            $interlocutor = null;
            $messages = null;
        }


        return $this->render('@BionicUniversityMessage/Message/Front/messages.html.twig', ['messages' => $messages, 'interlocutor' => $interlocutor]);
    }

    public function lastMessageAction($max = 3)
    {
        $user = $this->getUser();
        $entity = $this->getDoctrine()->getManager()->getRepository("BionicUniversityMessageBundle:Message")->findBy(['toUser' => $user],['createdAt' => 'desc'],$max);

        return $this->render("@BionicUniversityMessage/Message/Front/last_messages.html.twig", ['lastMessages' => $entity]);
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

    public function recentConversationAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $conversations = $em->getRepository("BionicUniversityUserBundle:User")->findConversation($user);

        return $this->render('BionicUniversityMessageBundle:Message/Front:conversation.html.twig',['conversations' => $conversations]);
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
        $form = $this->createForm('send_message', $entity, [
            'action' => $this->generateUrl('message_create_front')
        ]);

        $form->add('submit', 'submit', array('label' => 'Create', 'attr'=>['class' => 'btn btn-success pull-right']));

        return $form;
    }

    public function unreadMessagesAction($max = 3)
    {
        $user=$this->getUser();
        $uid = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $unreadMessages = null;
        $allunreadmessages = $em->getRepository('BionicUniversityMessageBundle:Message')->findBy(array( "toUser"=> $uid, "isread" => "0"));
        $unreadcounter =(string)count($allunreadmessages);
        return $this->render('BionicUniversityMessageBundle:Message:Front/unread_messages.html.twig',
            array(
                'unreadmessages' => $unreadMessages,
                'unreadcounter' => $unreadcounter
            )
        );
    }
}
