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

    }
        public function newAction()
    {
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('dueDate', 'date')
            ->add('save', 'submit')
            ->getForm();

        return $this->render('BionicUniversityUserBundle:User/Front:new', array(
            'form' => $form->createView(),
        ));
    }


        //return $this->render('BionicUniversityUserBundle:User/Front:search.html.twig');
    }

