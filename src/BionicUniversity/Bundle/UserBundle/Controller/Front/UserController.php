<?php
namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Form\CreatePasswordType;

class UserController extends Controller
{
    public function profileAction($id)
    {
        return $this->render('BionicUniversityUserBundle:User/Front:profile.html.twig');
    }

    public function createPasswordAction(Request $request)
    {
        $entity = $this->getUser();
        $form = $this->createForm(new CreatePasswordType(), $entity, array(
            'action' => $this->generateUrl('fos_user_registration_confirmed'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager = $this->get("fos_user.user_manager");
            $userManager->updateUser($this->getUser());
            return $this->redirect($this->generateUrl('user_profile',array(
                'id' => $this->getUser()->getId())));
        }
        return $this->render("BionicUniversityUserBundle:User/Front:create_password.html.twig", array(
            'form' => $form->createView()
        ));
    }
}
