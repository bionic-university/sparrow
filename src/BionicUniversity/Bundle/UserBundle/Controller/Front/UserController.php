<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Form\CreatePasswordType;

use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\UserBundle\Form\UserSettingsType;

class UserController extends Controller
{
    public function profileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityUserBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('BionicUniversityUserBundle:User/Front:profile.html.twig', array('entity'=> $entity));
    }

    public function createPasswordAction(Request $request)
    {
        $entity = $this->getUser();
        $form = $this->createForm(new CreatePasswordType(), $entity, array(
            'action' => $this->generateUrl('fos_user_registration_confirmed'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager = $this->get("fos_user.user_manager");
            $userManager->updateUser($this->getUser());

            return $this->redirect($this->generateUrl('user_profile',array(
                'id' => $this->getUser()->getId())));
        }

        return $this->render("BionicUniversityUserBundle:User/Front:create_password.html.twig", array(
            'form' => $form->createView()
        ));
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityUserBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('BionicUniversityUserBundle:User/Front:profile.html.twig', array('entity'=> $entity));
    }

    public function editAction()
    {
        $id = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('BionicUniversityUserBundle:User/Front:settings.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserSettingsType(), $entity, array(
            'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile', array('id' => $id)));
        }

        return $this->render('BionicUniversityUserBundle:User/Front:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function friendsAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $myFriendshipsSender = $em->getRepository('BionicUniversityUserBundle:Friendship')->findByUserSender($user);
        $myFriendshipsReceiver = $em->getRepository('BionicUniversityUserBundle:Friendship')->findByUserReceiver($user);
        $myFriendshipsAll=array_merge($myFriendshipsSender, $myFriendshipsReceiver);

        foreach($myFriendshipsAll as $friendship => $data)
        {
            if($data->getAcceptanceStatus()==0)
            {
                unset($myFriendshipsAll[$friendship]);
            }
        }

        $myFriends=array();
        foreach($myFriendshipsAll as $friendship)
        {
            if($friendship->getUserSender() != $user)
            {
                array_push($myFriends, $friendship->getUserSender());
            }
            if($friendship->getUserReceiver() != $user)
            {
                array_push($myFriends, $friendship->getUserReceiver());
            }
        }

        $allPeople = $em->getRepository('BionicUniversityUserBundle:User')->findAll();

        foreach($allPeople as $man => $data)
        {
            foreach($myFriendshipsAll as $friendship)
            {
                if($friendship->getUserSender() == $data)
                {
                    unset($allPeople[$man]);
                }
                if($friendship->getUserReceiver() == $data)
                {
                    unset($allPeople[$man]);
                }
            }
        }


        return $this->render('BionicUniversityUserBundle:User/Front:friends.html.twig', array('my_friends'=>$myFriends,'all_people'=>$allPeople));
    }

    //==========================================================================
    //==========================================================================
//    public function addAction($id)
//    {
//        $entity = new Friendship();
//        $entity->setUserSender($this->getUser());
//        $em = $this->getDoctrine()->getManager();
//
//        $userReceiver = $em->getRepository('BionicUniversityUserBundle:User')->findOneById($id);
//        $entity->setUserReceiver($userReceiver);
//        $entity->setAcceptanceStatus(0);
//
//        $em->persist($entity);
//        $em->flush();
//
//        return $this->redirect($this->generateUrl('communities'));
//    }
//
//    public function removeAction($id)
//    {
//
//        $em = $this->getDoctrine()->getManager();
//
//        $removeUser = $em->getRepository('BionicUniversityUserBundle:User')->findById($id);
//        $thisUser = $this->getUser();
//
//        $friendshipSender = $em->getRepository('BionicUniversityUserBundle:Friendship')->findByUserSender($id);
//        $friendshipReceiver = $em->getRepository('BionicUniversityUserBundle:Friendship')->findByUserReceiver($id);
//
//        if($friendshipReceiver->getUserSender() == $removeUser && $friendshipReceiver->getUserReceiver() == $thisUser){
//            $em->remove($friendshipReceiver);
//            $em->flush();
//        }
//
//
//        return $this->redirect($this->generateUrl('friends'));
//    }
    //==========================================================================
    //==========================================================================
}
