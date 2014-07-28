<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Controller\Admin;
use Symfony\Component\HttpFoundation\Request;

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
        $this->createSearchForm();
       /* $form = $this->createFormBuilder()
            ->add('name', 'text')
            ->add('lastname', 'text')
            ->add('search', 'submit')
            ->getForm();
        return $this->render('BionicUniversityUserBundle:User/Front:search.html.twig');
       */
    }

    private function createSearchForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Search'))
            ->getForm();
    }


        //
    }

