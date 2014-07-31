<?php

namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Form\CreatePasswordType;

use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\UserBundle\Entity\Friendship;
use BionicUniversity\Bundle\UserBundle\Form\UserSettingsType;
use BionicUniversity\Bundle\UserBundle\Doctrine\ORM\FriendshipRepository;

use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\WallBundle\Form\PostType;

class UserController extends Controller
{
    public function profileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityUserBundle:User')->find($id);
        $posts = $em->getRepository('BionicUniversityWallBundle:Post')->findByAuthor($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createPostForm();
        $csrfToken = $this->get('form.csrf_provider')->generateCsrfToken('delete_post');

        return $this->render('BionicUniversityUserBundle:User/Front:profile.html.twig', array(
            'entity' => $entity,
            'post' => $posts,
            'form' => $form->createView(),
            'csrfToken' => $csrfToken,
            //'wall' => $this->findWall(),
        ));
    }

    public function createPasswordAction(Request $request)
    {
        $entity = $this->getUser();
        $form = $this->createForm(new CreatePasswordType(), $entity, [
            'action' => $this->generateUrl('fos_user_registration_confirmed'),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager = $this->get("fos_user.user_manager");
            $userManager->updateUser($this->getUser());

            return $this->redirect($this->generateUrl('user_profile',
                ['id' => $this->getUser()->getId()]
            ));
        }

        return $this->render("BionicUniversityUserBundle:User/Front:create_password.html.twig", [
            'form' => $form->createView()
        ]);
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

        return $this->render('BionicUniversityUserBundle:User/Front:settings.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ]);
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
        $form = $this->createForm(new UserSettingsType(), $entity, [
            'action' => $this->generateUrl('user_update', ['id' => $entity->getId()]),
            'method' => 'PUT'
        ]);
        $form->add('submit', 'submit', ['label' => 'Update']);

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

            return $this->redirect($this->generateUrl('user_profile', ['id' => $id]));
        }

        return $this->render('BionicUniversityUserBundle:User/Admin:edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ]);
    }

    public function friendsAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $myRequests = $em->getRepository('BionicUniversityUserBundle:Friendship')->findByUserSender($user);
        $myInvites = $em->getRepository('BionicUniversityUserBundle:Friendship')->findByUserReceiver($user);
        $myFriendshipsAll=array_merge($myInvites, $myRequests);
        $myFriends = [];
        /**@var Friendship $friendship */
        foreach($myRequests as $friendship)
        {
            if($friendship->getAcceptanceStatus() == 1 && $friendship->getUserSender() == $user)
            {
                array_push($myFriends, $friendship->getUserSender());
            }
        }
        foreach($myInvites as $friendship)
        {
            if($friendship->getAcceptanceStatus() == 1 && $friendship->getUserReceiver() == $user)
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
        return $this->render('BionicUniversityUserBundle:User/Front:friends.html.twig', ['my_friends'=>$myFriends,'all_people'=>$allPeople]);
    }

    public function addFriendAction($id)
    {
        $friendship = new Friendship();
        $em = $this->getDoctrine()->getManager();
        $userSender = $em->getRepository("BionicUniversityUserBundle:User")->find($this->getUser()->getId());
        $userReceiver = $em->getRepository("BionicUniversityUserBundle:User")->find($id);
        /**
         * @var User $userSender
         */
        $userSender->addRequest($friendship);
        $friendship->setUserSender($this->getUser());
        $friendship->setUserReceiver($userReceiver);
        $friendship->setAcceptanceStatus(0);
        /**
         * @var User $userReceiver
         */
        $userReceiver->addInvite($friendship);
        $em->persist($friendship);
        $em->flush();

        return $this->redirect($this->generateUrl("user_friends"));
    }

    public function removeFriendAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $removeUser = $em->getRepository("BionicUniversityUserBundle:User")->find($id);
        $friendship = $em->getRepository("BionicUniversityUserBundle:Friendship")->findFriendshipByUsers($this->getUser(), $removeUser);
        $em->remove($friendship);

        return $this->redirect($this->generateUrl("user_friends"));
    }
}
