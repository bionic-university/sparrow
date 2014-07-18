<?php

namespace BionicUniversity\Bundle\MessagesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\MessagesBundle\Entity\Messages;
use BionicUniversity\Bundle\MessagesBundle\Form\MessagesType;

/**
 * Messages controller.
 *
 */
class MessagesController extends Controller
{

    /**
     * Lists all Messages entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BionicUniversityMessagesBundle:Messages')->findAll();

        return $this->render('BionicUniversityMessagesBundle:Messages:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Messages entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Messages();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('messages_show', array('id' => $entity->getId())));
        }

        return $this->render('BionicUniversityMessagesBundle:Messages:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Messages entity.
     *
     * @param Messages $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Messages $entity)
    {
        $form = $this->createForm(new MessagesType(), $entity, array(
            'action' => $this->generateUrl('messages_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Messages entity.
     *
     */
    public function newAction()
    {
        $entity = new Messages();
        $form   = $this->createCreateForm($entity);

        return $this->render('BionicUniversityMessagesBundle:Messages:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Messages entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityMessagesBundle:Messages')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Messages entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BionicUniversityMessagesBundle:Messages:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Messages entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityMessagesBundle:Messages')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Messages entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BionicUniversityMessagesBundle:Messages:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Messages entity.
    *
    * @param Messages $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Messages $entity)
    {
        $form = $this->createForm(new MessagesType(), $entity, array(
            'action' => $this->generateUrl('messages_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Messages entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityMessagesBundle:Messages')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Messages entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('messages_edit', array('id' => $id)));
        }

        return $this->render('BionicUniversityMessagesBundle:Messages:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Messages entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BionicUniversityMessagesBundle:Messages')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Messages entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('messages'));
    }

    /**
     * Creates a form to delete a Messages entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('messages_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
