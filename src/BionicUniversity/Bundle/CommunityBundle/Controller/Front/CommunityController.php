<?php
namespace BionicUniversity\Bundle\CommunityBundle\Controller\Front;

use BionicUniversity\Bundle\CommunityBundle\Entity\Membership;
use BionicUniversity\Bundle\CommunityBundle\Entity\Community;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Entity\Avatar;

use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\CommunityBundle\Form\Type\PostType;
use BionicUniversity\Bundle\CommunityBundle\Form\Type\FrontCommunityType;
use BionicUniversity\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class CommunityController extends Controller
{

    public function profileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);
        $posts = $em->getRepository('BionicUniversityWallBundle:Post')->findByCommunity($entity, ['createdAt'=>'desc']);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Community entity.');
        }
        $form = $this->createPostForm($id);
        return $this->render('BionicUniversityCommunityBundle:Community/Front:community.html.twig', [
            'entity' => $entity,
            'posts' => $posts,
            'form' => $form->createView()
        ]);
    }

    public function communitiesAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $myMemberships = $em->getRepository('BionicUniversityCommunityBundle:Membership')->findByUser($user);
        $all = $em->getRepository('BionicUniversityCommunityBundle:Community')->findAll();
        $allCommunities = [];

        if (null != $myMemberships) {
            foreach ($all as $community => $data) {
                foreach ($myMemberships as $membership) {
                    if ($data->getId() === $membership->getCommunity()->getId()) {
                        unset($all[$community]);
                    }
                }
            }
        }
        $allCommunities = $all;

        return $this->render('BionicUniversityCommunityBundle:Community/Front:communities.html.twig', ['memberships'=>$myMemberships,'communities'=>$allCommunities]);
    }

    public function joinAction($id)
    {
        $entity = new Membership();
        $entity->setUser($this->getUser());
        $em = $this->getDoctrine()->getManager();

        $community = $em->getRepository('BionicUniversityCommunityBundle:Community')->findOneById($id);
        $entity->setCommunity($community);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('communities'));
    }

    public function leaveAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $membership = $em->getRepository('BionicUniversityCommunityBundle:Membership')->findOneById($id);
        if(null != $membership)
        {
            $em->remove($membership);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('communities'));
    }

    /**
     * Creates a form to create communities posts.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPostForm($id)
    {
        $form = $this->createForm(new PostType(), null, [
            'action' => $this->generateUrl('create_community_post', ['id'=>$id]),
            'method' => 'POST',
            'show_legend' => true,
            'label' => 'Write a new post'
        ]);

        $form->add('submit', 'submit', [
            'label' => 'Create new post',
            'attr' => ['class' => 'pull-right btn btn-success']]);

        return $form;
    }

    /**
     * Displays a form to create a new Community entity.
     *
     */
    public function newAction()
    {
        $entity = new Community();
        $form   = $this->createCreateForm($entity);

        return $this->render('BionicUniversityCommunityBundle:Community/Front:new.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * Creates a form to create a Community entity.
     *
     * @param Community $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Community $entity)
    {
        $form = $this->createForm(new FrontCommunityType(), $entity, [
            'action' => $this->generateUrl('front_community_create'),
            'method' => 'POST',
        ]);

        $form->add('submit', 'submit', ['label' => 'Create']);

        return $form;
    }

    /**
     * Creates a new Community entity.
     *
     */
    public function createAction(Request $request)
    {
        $owner = $this->getUser();

        $entity = new Community();
        $entity->setOwner($owner);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('community_profile', ['id'=>$entity->getId()]));
        }

        return $this->render('BionicUniversityCommunityBundle:Community/Front:new.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Community entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Community entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BionicUniversityCommunityBundle:Community/Front:edit.html.twig', [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a form to edit a Community entity.
     *
     * @param Community $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Community $entity)
    {
        $form = $this->createForm(new FrontCommunityType(), $entity,
        [
            'action' => $this->generateUrl('front_community_update', ['id' => $entity->getId()]),
            'method' => 'PUT'
        ]);

        $form->add('submit', 'submit', ['label' => 'Update']);

        return $form;
    }
    /**
     * Edits an existing Community entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Community entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('front_community_edit', ['id' => $id]));
        }

        return $this->render('BionicUniversityCommunityBundle:Community/Front:edit.html.twig', [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }
    /**
     * Deletes a Community entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Community entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('communities'));
    }

    /**
     * Creates a form to delete a Community entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('front_community_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}
