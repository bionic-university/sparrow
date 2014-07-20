<?php

namespace BionicUniversity\Bundle\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('position')
            ->add('department')
            ->add('enabled')
            ->add('gender', 'choice', array(
                'choices' => array ( 'm'  =>  'Male' ,  'f'  =>  'Female' ),
                'empty_value' => 'Choose user gender',
                'empty_data' => null
                )
            )
            ->add('dateOfBirth', 'birthday', [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BionicUniversity\Bundle\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bionicuniversity_bundle_userbundle_user';
    }
}
