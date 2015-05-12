<?php
namespace BionicUniversity\Bundle\MessageBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SendMessageType extends AbstractType
{

    /**
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', null, ['label' => false]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BionicUniversity\Bundle\MessageBundle\Entity\Message',
            'show_legend' => false
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'send_message';
    }
}
