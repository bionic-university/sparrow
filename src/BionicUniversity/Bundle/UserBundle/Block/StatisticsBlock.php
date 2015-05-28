<?php

namespace BionicUniversity\Bundle\UserBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockContextInterface;

class StatisticsBlock extends BaseBlockService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct($name, $templating, EntityManager $entityManager)
    {
        parent::__construct($name, $templating);
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $block, Response $response = null)
    {
        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());

        $repository = $this->em->getRepository('BionicUniversityWallBundle:Article');
        $articles = $repository->findAll();

        return $this->renderResponse('BionicUniversityWallBundle:Article/Admin/Block:statistics.html.twig', array(
            'block' => $block->getBlock(),
            'settings' => $settings,
            'articles' => $articles,
        ), $response);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
// TODO: Implement validateBlock() method.
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('content', 'textarea', array()),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Text (core)';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSettings()
    {
        return array(
            'content' => 'Insert your custom content here',
        );
    }
}
