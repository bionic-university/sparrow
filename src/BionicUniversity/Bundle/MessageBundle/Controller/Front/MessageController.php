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
        $uid = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $message = new Message();
        if(null != $id)
        {
            $messages = $em->getRepository("BionicUniversityMessageBundle:Message")->findMessages($user,$id);
            $interlocutor = $em->getRepository("BionicUniversityUserBundle:User")->find($id);
            $message->setToUser($interlocutor);
            $messageForm = $this->createCreateForm($message)->createView();
            $unreadMessages = $em->getRepository('BionicUniversityMessageBundle:Message')->findBy(array( "toUser"=> $uid, 'fromUser' => $id,"isread" => "0"));
            foreach ($unreadMessages as $elem){ $elem->setIsRead(1);}
            $em->flush();
        }
        else
        {
            $interlocutor = null;
            $messages = null;
            $messageForm = null;
        }

        $userSearchForm = $this
            ->createFormBuilder($user)
            ->add('friends', 'entity', [
                'class'=> 'BionicUniversity\Bundle\UserBundle\Entity\User',
                'show_legend' => false,
                'label' => false,
                'empty_value' => 'Choose an friend'
            ])
            ->getForm();

        return $this->render('@BionicUniversityMessage/Message/Front/messages.html.twig', [
            'messages' => $messages,
            'interlocutor' => $interlocutor,
            'userSearchForm' =>$userSearchForm->createView(),
            'token' => $this->get('form.csrf_provider')->generateCsrfToken(''),
            'messageForm' => $messageForm
        ]);
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
    public function createAction(Request $request, $id)
    {
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $entity = new Message();
        $entity->setFromUser($user);
        $interlocutor = $em->getRepository('BionicUniversityUserBundle:User')->find($id);
        if(null === $interlocutor){
            throw $this->createNotFoundException('Interlocutor not found');
        }
        $entity->setToUser($interlocutor);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()){
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('message_conversation', ['id'=>$interlocutor->getId()]));
        }

        return $this->render('BionicUniversityMessageBundle:Message:Front/messages.html.twig',
            [
                'form' => $form->createView()
            ]);

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
            'action' => $this->generateUrl('message_create_front', ['id'=>$entity->getToUser()->getId()])
        ]);

        $form->add('submit', 'submit', ['label' => 'Write', 'attr' =>['class' => 'btn pull-right btn btn-success']]);

        return $form;
    }

    public function unreadMessagesAction()
    {
        $user=$this->getUser();
        $uid = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $unreadMessages = null;
        $allunreadmessages = $em->getRepository('BionicUniversityMessageBundle:Message')->findBy([ "toUser"=> $uid, "isread" => "0"]);
        $unreadcounter =(string)count($allunreadmessages);
        return $this->render('BionicUniversityMessageBundle:Message:Front/unread_messages.html.twig',
            [
                'unreadmessages' => $unreadMessages,
                'unreadcounter' => $unreadcounter
            ]
        );
    }
}
