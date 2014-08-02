<?php

namespace BionicUniversity\Bundle\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use BionicUniversity\Bundle\UserBundle\Entity\User;

class UserAdmin extends Admin
{
    protected $baseRoutePattern = 'users';

    private $mailer;
    private $tokenGenerator;
    private $session;
    private $userManager;

    public function __construct($code, $class, $baseControllerName, $mailer, $tokenGenerator, $session, $userManager)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->mailer = $mailer;
        $this->tokenGenerator = $tokenGenerator;
        $this->session = $session;
        $this->userManager = $userManager;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('enabled')
            ->add('firstName')
            ->add('lastName')
            ->add('position')
            ->add('department')
            ->add('dateOfBirth')
            ->add('gender');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('firstName')
            ->add('lastName')
            ->add('department')
            ->add('position')
            ->add('gender', null, [

            ])
            ->add('dateOfBirth')
            ->add('enabled')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('firstName')
            ->add('lastName')
            ->add('department')
            ->add('email')
            ->add('position')
            ->add('dateOfBirth')
            ->add('gender', 'choice', [
                'choices' => array(User::GENDER_MALE => 'Male', User::GENDER_FEMALE => 'Female'),
                'empty_value' => 'Choose user gender',
                'empty_data' => null

            ])
            ->add('enabled');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('email')
            ->add('enabled')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('credentialsExpired')
            ->add('credentialsExpireAt')
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('position')
            ->add('department')
            ->add('dateOfBirth')
            ->add('gender')
            ->add('avatar');
    }

    public function prePersist($entity)
    {
        $entity->setUsername($entity->getEmail());
        $entity->setPlainPassword(' ');
        $entity->setEnabled(false);
        if (null === $entity->getConfirmationToken()) {
            $entity->setConfirmationToken($this->tokenGenerator->generateToken());
        }
        $this->mailer->sendConfirmationEmailMessage($entity);
        $this->session->set('fos_user_send_confirmation_email/email', $entity->getEmail());
        $this->userManager->updateUser($entity);
    }
}
