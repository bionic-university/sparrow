<?php
namespace BionicUniversity\Bundle\MessageBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $this->securityContext->getToken()->getUser();
        $builder
            ->add('toUser'
                , 'entity', array(
                    'class' => 'BionicUniversity\Bundle\UserBundle\Entity\User',
                    'property' => 'firstName',
                    'query_builder' => function (EntityRepository $er) use ($user) {
                            return $er->createQueryBuilder('u')
                                ->where('u !=:user')
                                ->setParameter('user', $user);
                        }
                )
            )
            ->add('body');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BionicUniversity\Bundle\MessageBundle\Entity\Message'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'send_message';
    }
}
