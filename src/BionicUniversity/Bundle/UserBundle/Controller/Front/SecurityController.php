<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use FOS\UserBundle\Controller\SecurityController as Base;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Base
{
    public function loginAction(Request $request)
    {
        if (false === $this->getSecurityContext()->isGranted('ROLE_USER')) {
            return parent::loginAction($request);
        }

        return $this->redirect($this->getRouter()->generate('user_profile', [
                'id' => $this->getSecurityContext()->getToken()->getUser()->getId(),
                '_token' =>$this->get('form.csrf_provider')->generateCsrfToken('anything')
            ]
        ));
    }

    protected function renderLogin(array $data)
    {
        return $this->render('BionicUniversityUserBundle:User/Front:login.html.twig', $data);
    }

    /**
     * @param $id
     * @return object
     */
    private function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @param $url
     * @param  int              $status
     * @return RedirectResponse
     */
    private function redirect($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * @return RouterInterface
     */
    private function getRouter()
    {
        return $this->get('router');
    }

    /**
     * @return SecurityContextInterface
     */
    private function getSecurityContext()
    {
        return $this->get('security.context');
    }

    /**
     * @param $view
     * @param  array    $parameters
     * @param  Response $response
     * @return mixed
     */
    private function render($view, array $parameters = array(), Response $response = null)
    {
        return $this->get('templating')->renderResponse($view, $parameters, $response);
    }
}
