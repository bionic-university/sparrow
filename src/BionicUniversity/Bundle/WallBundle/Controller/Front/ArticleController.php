<?php

namespace BionicUniversity\Bundle\WallBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BionicUniversity\Bundle\WallBundle\Entity\Article;
use BionicUniversity\Bundle\WallBundle\Form\ArticleType;

/**
 * Article controller.
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BionicUniversityWallBundle:Article')->findAll();

        return $this->render('@BionicUniversityWall/Post/Front/recent_news.html.twig', [
            'articles' => $entities,
        ]);
    }
    /**
     * Creates a new Article entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Article();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('front_article_show', ['id' => $entity->getId()]));
        }

        return $this->render('BionicUniversityWallBundle:Article/Front:index.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView()
        ]);
    }

    /**
     * Creates a form to create a Article entity.
     * @param  Article                      $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Article $entity)
    {
        $form = $this->createForm(new ArticleType(), $entity, [
            'action' => $this->generateUrl('front_article_create'),
            'method' => 'POST',
        ]);

        $form->add('submit', 'submit', ['label' => 'Create']);

        return $form;
    }

    /**
     * Displays a form to create a new Article entity.
     *
     */
    public function newAction()
    {
        $entity = new Article();
        $form   = $this->createCreateForm($entity);

        return $this->render('', [
            'entity' => $entity,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Article entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BionicUniversityWallBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        return $this->render('BionicUniversityWallBundle:Article/Front:show.html.twig', [
            'entity' => $entity,
        ]);
    }
}
