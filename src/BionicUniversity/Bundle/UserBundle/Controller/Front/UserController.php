<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Controller\Admin;
use BionicUniversity\Bundle\UserBundle\Entity\User;
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

    public function searchAction(Request $request)
    {
            $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('user_search'))

            ->add('firstName', 'text', [
            ])
            ->add('lastName', 'text', [
            ])
            ->add('department', 'text', [
            ])
            ->add('email', 'email', [
            ])
            ->add('gender', 'choice', array(
                'choices' => array(User::GENDER_MALE => 'Male', User::GENDER_FEMALE => 'Female'),
                'empty_value' => 'Choose user gender',
                'empty_data' => null,
                    ))
            ->add('Search', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $search_name = $request->request->get("form")['firstName'];
            $search_lname = $request->request->get("form")['lastName'];
            $search_dep = $request->request->get("form")['department'];
            $search_email = $request->request->get("form")['email'];
            $search_gender = $request->request->get("form")['gender'];
            /**
             * @var User $entity
             */
            $entity = $em->getRepository('BionicUniversityUserBundle:User')->findUsers($search_name, $search_lname, $search_gender, $search_dep, $search_email);
           // var_dump($entity->getFirstName());

            return $this->render('BionicUniversityUserBundle:User/Front:resultsearch.html.twig', array('users' => $entity));
        }

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

