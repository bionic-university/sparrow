<?php

namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Form\CreatePasswordType;

use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\UserBundle\Entity\Friendship;
use BionicUniversity\Bundle\UserBundle\Form\UserSettingsType;

use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\WallBundle\Form\PostType;

class UserController extends Controller
{
    public function profileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityUserBundle:User')->find($id);
        $posts = $em->getRepository('BionicUniversityWallBundle:Post')->findBy(['author'=>$entity, 'community'=>null], ['createdAt'=>'desc']);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createPostForm();

        return $this->render('BionicUniversityUserBundle:User/Front:profile.html.twig', array(
            'entity' => $entity,
            'post' => $posts,
            'form' => $form->createView(),
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

        return $this->render('BionicUniversityUserBundle:User/Front:settings.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ]);
    }

    public function friendsAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $myFriendships = $em->getRepository("BionicUniversityUserBundle:Friendship")->findFriends($user);
        $myFriends = [];
        /**
         * #@var Friendship $friendship
         */
        foreach ($myFriendships as $friendship) {
            if ($friendship->getUserReceiver() == $user) {
                array_push($myFriends, $friendship->getUserSender());
            } else {
                array_push($myFriends, $friendship->getUserReceiver());
            }

        }
        $requests = $user->getRequests();

        $unconfirmedRequests = [];
        /**
         * @var Friendship $friendship
         */
        foreach ($requests as $friendship) {
            if ($friendship->getUserSender() == $user && $friendship->getAcceptanceStatus() != 1) {
                array_push($unconfirmedRequests, $friendship->getUserReceiver());
            }
        }
        $invites = $user->getInvites();
        $unconfirmedInvites = [];
        /**
         * @var Friendship $friendship
         */
        foreach ($invites as $friendship) {
            if ($friendship->getUserReceiver() == $user && $friendship->getAcceptanceStatus() != 1) {
                array_push($unconfirmedInvites, $friendship->getUserSender());
            }
        }

        return $this->render('BionicUniversityUserBundle:User/Front:friends.html.twig', [
            'my_friends' => $myFriends,
            'all_people' => $em->getRepository("BionicUniversityUserBundle:User")->findAll(),
            'requests' => $unconfirmedRequests,
            'invites' => $unconfirmedInvites
        ]);
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
        $em->flush();

        return $this->redirect($this->generateUrl("user_friends"));
    }

    public function confirmFriendAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var Friendship $entity
         */
        $entity = $em->getRepository("BionicUniversityUserBundle:Friendship")->findUnconfirmedFriends($id, $this->getUser());
        $entity->setAcceptanceStatus(1);
        $em->flush();

        return $this->redirect($this->generateUrl("user_friends"));
    }

    /**
     * Creates a form to create user posts.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPostForm()
    {
        $form = $this->createForm(new PostType(), null, array(
            'action' => $this->generateUrl('create_post'),
            'method' => 'POST',
            'show_legend' => true,
            'label' => 'Write a new post'
        ));

        $form->add('submit', 'submit', array('label' => 'Create new post', 'attr' => ['class' => 'pull-right btn btn-success']));

        return $form;
    }
}
