<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Form\CreatePasswordType;

use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\UserBundle\Form\UserSettingsType;

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
        $form = $this->createForm(new CreatePasswordType(), $entity, array(
            'action' => $this->generateUrl('fos_user_registration_confirmed'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager = $this->get("fos_user.user_manager");
            $userManager->updateUser($this->getUser());

            return $this->redirect($this->generateUrl('user_profile', array(
                'id' => $this->getUser()->getId())));
        }

        return $this->render("BionicUniversityUserBundle:User/Front:create_password.html.twig", array(
            'form' => $form->createView()
        ));
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
            'action' => $this->generateUrl('user_front_update', array('id' => $entity->getId())),
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
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;

    }
}
