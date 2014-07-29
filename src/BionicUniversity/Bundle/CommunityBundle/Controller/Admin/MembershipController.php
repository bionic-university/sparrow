<?php

namespace BionicUniversity\Bundle\CommunityBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\CommunityBundle\Entity\Membership;
use BionicUniversity\Bundle\CommunityBundle\Form\Type\MembershipType;

/**
 * Community controller.
 *
 */
class MembershipController extends Controller
{

    /**
     * Lists all Community entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BionicUniversityCommunityBundle:Membership')->findAll();

        return $this->render('BionicUniversityCommunityBundle:Membership/Admin:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Membership entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Membership();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('membership_show', array('id' => $entity->getId())));
        }

        return $this->render('BionicUniversityCommunityBundle:Membership/Admin:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Membership entity.
     *
     * @param Membership $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Membership $entity)
    {
        $form = $this->createForm(new MembershipType(), $entity, array(
            'action' => $this->generateUrl('membership_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Membership entity.
     *
     */
    public function newAction()
    {
        $entity = new Membership();
        $form   = $this->createCreateForm($entity);

        return $this->render('BionicUniversityCommunityBundle:Membership/Admin:new.html.twig', array(
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

        $entity = $em->getRepository('BionicUniversityCommunityBundle:Membership')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Membership entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BionicUniversityCommunityBundle:Membership/Admin:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Membership entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:Membership')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Membership entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BionicUniversityCommunityBundle:Membership/Admin:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Membership entity.
    *
    * @param Membership $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Membership $entity)
    {
        $form = $this->createForm(new MembershipType(), $entity, array(
            'action' => $this->generateUrl('membership_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Membership entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:Membership')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Membership entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('membership_edit', array('id' => $id)));
        }

        return $this->render('BionicUniversityCommunityBundle:Membership/Admin:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Membership entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BionicUniversityCommunityBundle:Membership')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Membership entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('membership'));
    }

    /**
     * Creates a form to delete a Membership entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('membership_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
