<?php

namespace BionicUniversity\Bundle\CommunityBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\CommunityBundle\Form\Type\PostType;

use BionicUniversity\Bundle\CommunityBundle\Entity\Community;

/**
 * Post controller.
 */
class PostController extends Controller
{
    /**
     * Creates a new Post entity.
     *
     */
    public function createAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);
        $post = new Post();
        $post->setCommunity($entity);
        $post->setAuthor($this->getUser());
        $form = $this->createCreateForm($post, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('community_profile', ['id'=>$id]));
        }

        return $this->render('BionicUniversityCommunityBundle:Community/Front:community.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Post $entity, $id)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('create_community_post', ['id'=>$id]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Deletes a Post entity.
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BionicUniversityWallBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $em->remove($entity);
        $em->flush();

        $UserId = $entity->getCommunity()->getId();

        return $this->redirect($this->generateUrl('community_profile' , ['id'=>$UserId]));
    }
}
