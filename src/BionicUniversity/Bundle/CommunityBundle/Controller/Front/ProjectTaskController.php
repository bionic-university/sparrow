<?php

namespace BionicUniversity\Bundle\CommunityBundle\Controller\Front;

use BionicUniversity\Bundle\CommunityBundle\Entity\Community;
use BionicUniversity\Bundle\CommunityBundle\Entity\TaskManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\CommunityBundle\Entity\ProjectTask;
use BionicUniversity\Bundle\CommunityBundle\Entity\Membership;
use BionicUniversity\Bundle\CommunityBundle\Form\ProjectTaskType;

/**
 * ProjectTask controller.
 *
 */
class ProjectTaskController extends Controller
{

    /**
     * Lists all ProjectTask entities.
     *
     */
    public function indexAction($communityId)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var ProjectTask $projectTasks
         */
        $projectTasks =  $em->getRepository('BionicUniversityCommunityBundle:ProjectTask')->findByCommunity($communityId);
        $taskManagers = $em->getRepository('BionicUniversityCommunityBundle:TaskManager')->findBy(['projectTask' => $projectTasks]);
        $users = $em->getRepository('BionicUniversityUserBundle:User')->findAll();

        /**
         * @var User $user
         */
        foreach ($users as $user ) {
            $users[$user->getId()] = $user;
        }

        $tasks = [];
        /**
         * @var TaskManager $taskManager
         */
        if(null != $taskManagers) {
            foreach ($taskManagers as $taskManager) {
                $projectTaskId = $taskManager->getProjectTask()->getId();
                $tasks[$projectTaskId]['green'] = 0;
                if(null != $taskManager->getDetails()) {
                    $tasks[$projectTaskId]['count'] = count(json_decode($taskManager->getDetails(),true));
                    foreach (json_decode($taskManager->getDetails()) as $detail) {
                        $tasks[$projectTaskId]['tasks'][$detail->user][] = strip_tags($detail->text);
                      //  $tasks[$projectTaskId]['dates'][$detail->user][] = $detail->date;
                       // $tasks[$projectTaskId]['tasks']['task'] = $detail->text;
                        if($detail->type == 'green') {
                            $tasks[$projectTaskId]['green']++;
                        }
                    }
                    foreach ($tasks[$projectTaskId] as $key => $value) {
                        $tasks[$projectTaskId]['percent'] = ceil($tasks[$projectTaskId]['green'] * 100 / $tasks[$projectTaskId]['count']);
                    }
                }
            }
        }
//        echo '<pre>';
//        print_r($tasks);
//        die;

        return $this->render('BionicUniversityCommunityBundle:ProjectTask:index.html.twig', array(
            'entities' => $projectTasks,
            'communityId' => $communityId,
            'tasks' => $tasks,
            'users' => $users
        ));
    }
    /**
     * Creates a new ProjectTask entity.
     *
     */
    public function createAction(Request $request, $communityId)
    {
        $entity = new ProjectTask();
        $form = $this->createCreateForm($entity, $communityId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $community = $em->getRepository('BionicUniversityCommunityBundle:Community')->findById($communityId);
            $entity->setCommunity($community[0]);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('community_profile', ['id' => $communityId]));
        }

        return $this->render('BionicUniversityCommunityBundle:ProjectTask:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'communityId' => $communityId
        ));
    }

    /**
     * Creates a form to create a ProjectTask entity.
     *
     * @param ProjectTask $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProjectTask $entity, $communityId)
    {
        $form = $this->createForm(new ProjectTaskType(), $entity, array(
            'action' => $this->generateUrl('community_projecttask_create', ['communityId' => $communityId]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProjectTask entity.
     *
     */
    public function newAction(Request $request, $communityId)
    {
        $entity = new ProjectTask();
        $form   = $this->createCreateForm($entity, $communityId);
        return $this->render('BionicUniversityCommunityBundle:ProjectTask:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'communityId' => $communityId
        ));
    }

    /**
     * Finds and displays a ProjectTask entity.
     *
     */
    public function showAction($communityId, $taskId)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:ProjectTask')->find($taskId);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectTask entity.');
        }

        $deleteForm = $this->createDeleteForm($taskId, $communityId);

        return $this->render('BionicUniversityCommunityBundle:ProjectTask:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'communityId' => $communityId
        ));
    }

    /**
     * Displays a form to edit an existing ProjectTask entity.
     *
     */
    public function editAction($communityId, $taskId)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:ProjectTask')->find($taskId);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectTask entity.');
        }

        $editForm = $this->createEditForm($entity, $communityId);
        $deleteForm = $this->createDeleteForm($taskId, $communityId);

        return $this->render('BionicUniversityCommunityBundle:ProjectTask:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'communityId' => $communityId
        ));
    }

    /**
    * Creates a form to edit a ProjectTask entity.
    *
    * @param ProjectTask $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProjectTask $entity, $communityId)
    {
        $form = $this->createForm(new ProjectTaskType(), $entity, array(
            'action' => $this->generateUrl('community_projecttask_update', array('communityId' => $communityId,'taskId' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ProjectTask entity.
     *
     */
    public function updateAction(Request $request,$communityId, $taskId)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityCommunityBundle:ProjectTask')->find($taskId);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectTask entity.');
        }

        $deleteForm = $this->createDeleteForm($taskId, $communityId);
        $editForm = $this->createEditForm($entity, $communityId);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('community_profile', ['id' => $communityId]));
        }

        return $this->render('BionicUniversityCommunityBundle:ProjectTask:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ProjectTask entity.
     *
     */
    public function deleteAction(Request $request, $communityId, $taskId)
    {
        $form = $this->createDeleteForm($taskId, $communityId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BionicUniversityCommunityBundle:ProjectTask')->find($taskId);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProjectTask entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('community_profile', ['id' => $communityId]));
    }

    public function removeAction($communityId, $taskId)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var ProjectTask $removeProjectTask
         */
        $removeProjectTask = $em->getRepository("BionicUniversityCommunityBundle:ProjectTask")->find($taskId);
        $em->remove($removeProjectTask);

        $em->flush();

        return $this->redirect($this->generateUrl('community_profile', ['id' => $communityId]));
    }

    /**
     * Creates a form to delete a ProjectTask entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($taskId, $communityId)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('community_projecttask_delete', ['communityId' => $communityId, 'taskId' => $taskId]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function newTaskManagerAction($communityId, $taskId)
    {
        $em = $this->getDoctrine()->getManager();
        $community = $em->getRepository('BionicUniversityCommunityBundle:Community')->findOneBy(['id' => $communityId]);
        /**
         * @var ProjectTask $projectTask
         */
        $projectTask = $em->getRepository('BionicUniversityCommunityBundle:ProjectTask')->findOneBy(['id' => $taskId]);


        if(isset($community) && isset($projectTask))
        {
            $taskManager = new TaskManager();
            $taskManager->setProjectTask($projectTask);
            $projectTask->setTaskManager($taskManager);
            $em->persist($taskManager);
            $em->flush();

            return $this->redirect($this->generateUrl('community_profile', ['id' => $communityId]));
        }
        else
        {
            throw $this->createNotFoundException('Unable to find Community or ProjectTask entities.');
        }
    }

    public function deleteTaskManagerAction($communityId, $taskId, $taskManagerId)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var TaskManager $taskManager
         */
        $taskManager = $em->getRepository('BionicUniversityCommunityBundle:TaskManager')->findOneBy(['id' => $taskManagerId]);
        $details = json_decode($taskManager->getDetails());

        $users = [];
        if(null != $details)
        {
            foreach ($details as $item)
            {
                if(isset($item->user) && is_numeric($item->user))
                {
                    $users[] = $item->user;
                    /**
                     * @var User $user
                     */
                    $user = $em->getRepository('BionicUniversityUserBundle:User')->findOneById($item->user);
                    $user->setTasksCount(0);
                    $em->persist($user);
                }
            }
        }


        $em->remove($taskManager);
        $em->flush();

        return $this->redirect($this->generateUrl('community_profile', ['id' => $communityId]));
    }

    public function showTaskManagerAction($communityId, $taskId, $taskManagerId)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var TaskManager $taskManager
         */
        $taskManager = $em->getRepository('BionicUniversityCommunityBundle:TaskManager')->findOneBy(['id' => $taskManagerId]);

        $taskManagers = $em->getRepository('BionicUniversityCommunityBundle:TaskManager')->findAll();

        $usersTaskCounts = [];
        /**
         * @var TaskManager $taskManager
         */
        foreach($taskManagers as $taskManager)
        {
            if(null != $taskManager->getDetails())
            {
                foreach(json_decode($taskManager->getDetails()) as $detail)
                {
                    if(isset($detail->user) && is_numeric($detail->user))
                    {
                        $usersTaskCounts[] =  $detail->user;
                    }
                }
            }
        }

        foreach(array_count_values($usersTaskCounts) as $id => $count)
        {
            /**
             * @var User $user
             */
            $user = $em->getRepository('BionicUniversityUserBundle:User')->findOneById($id);
            $user->setTasksCount($count);
            $em->persist($user);
            $em->flush();
        }

        $users = [];
        /**
         * @var Membership $user
         */
        foreach($taskManager->getProjectTask()->getCommunity()->getMemberships() as $user)
        {
            $users[] = $user->getUser();
        }

        $taskManager = $em->getRepository('BionicUniversityCommunityBundle:TaskManager')->findOneBy(['id' => $taskManagerId]);

        return $this->render('@BionicUniversityCommunity/TaskManager/taskManager.html.twig',
            [
                'users' => $users,
                'taskManager' => $taskManager->getDetails(),
                'communityId' => $communityId,
                'taskId' => $taskId,
                'taskManagerId' => $taskManagerId
            ]
        );
    }

    public function updateTaskManagerAction(Request $request, $communityId, $taskId, $taskManagerId)
    {

        $data = $request->request->get('data');

        if(!empty($data))
        {
            $em = $this->getDoctrine()->getManager();
            /**
             * @var TaskManager $taskManager
             */
            $taskManager = $em->getRepository('BionicUniversityCommunityBundle:TaskManager')->findOneBy(['id' => $taskManagerId]);

            $taskManager->setDetails($data);
            $em->persist($taskManager);
            $em->flush();

        }

        return $this->render('@BionicUniversityCommunity/TaskManager/details.html.twig', ['taskManager' => $taskManager->getDetails()]);
    }

}
