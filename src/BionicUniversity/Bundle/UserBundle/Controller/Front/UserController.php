<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Controller\Admin;
use BionicUniversity\Bundle\UserBundle\Entity\Search;

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

    public function searchAction()
    {
        $search = new Search();
        $search->firstName = 'Hello';

        $form = $this->createFormBuilder($search)
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('department', 'text')
            ->add('gender', 'text')
            ->add('Search', 'submit')
            ->getForm();
        return $this->render('BionicUniversityUserBundle:User/Front:search.html.twig', array('form' => $form->createView(),));
       // $em = $this->getDoctrine()->getManager();

        // $entity = $em->getRepository('BionicUniversityUserBundle:User')->findOneByfirstName();

        //$form = $this->createSearchForm($entity);





       /* $form = $this->createFormBuilder()
            ->add('name', 'text')
            ->add('lastname', 'text')
            ->add('search', 'submit')
            ->getForm();
        return $this->render('BionicUniversityUserBundle:User/Front:search.html.twig');
       */
    }

    private function createSearchForm(Search $entity)
    {
        $form = $this->createForm(new UserSearchType(), $entity, array(
            'action' => $this->generateUrl('search', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;

        /*
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Search'))
            ->getForm();
        */
    }


        //
    }

