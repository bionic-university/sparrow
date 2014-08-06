<?php

namespace BionicUniversity\Bundle\CommunityBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\CommunityBundle\Entity\Community;
use BionicUniversity\Bundle\CommunityBundle\Form\CommunityType;

/**
 * Community controller.
 *
 */
class CommunityController extends Controller
{
    /**
     * Lists all Community entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BionicUniversityCommunityBundle:Community')->findAll();

        return $this->render('BionicUniversityCommunityBundle:Community/Admin:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Community entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Community();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('community_show', array('id' => $entity->getId())));
        }

        return $this->render('BionicUniversityCommunityBundle:Community/Admin:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
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
        $form = $this->createForm(new CommunityType(), $entity, array(
            'action' => $this->generateUrl('community_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

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

        return $this->render('BionicUniversityCommunityBundle:Community/Admin:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Community entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:Community')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Community entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BionicUniversityCommunityBundle:Community/Admin:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
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

        return $this->render('BionicUniversityCommunityBundle:Community/Admin:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
        $form = $this->createForm(new CommunityType(), $entity, array(
            'action' => $this->generateUrl('community_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

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

            return $this->redirect($this->generateUrl('community_edit', array('id' => $id)));
        }

        return $this->render('BionicUniversityCommunityBundle:Community/Admin:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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

        return $this->redirect($this->generateUrl('community'));
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
            ->setAction($this->generateUrl('community_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
