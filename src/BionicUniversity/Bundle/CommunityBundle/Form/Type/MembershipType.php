<?php

namespace BionicUniversity\Bundle\CommunityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MembershipType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add(  'user',
                    'entity', array(
                    'class' => 'BionicUniversity\Bundle\UserBundle\Entity\User',
                    'property' => 'firstName')
                 )
            ->add('community',
                'entity', array(
                    'class' => 'BionicUniversity\Bundle\CommunityBundle\Entity\Community',
                    'property' => 'Name')
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BionicUniversity\Bundle\CommunityBundle\Entity\Membership'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bionicuniversity_bundle_communitybundle_membership';
    }
}
