<?php

namespace BionicUniversity\Bundle\UserBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BionicUniversity\Bundle\UserBundle\Form\CreatePasswordType;
use BionicUniversity\Bundle\UserBundle\Entity\User;
use BionicUniversity\Bundle\UserBundle\Entity\Friendship;
use BionicUniversity\Bundle\UserBundle\Form\UserSettingsType;
use BionicUniversity\Bundle\UserBundle\Doctrine\ORM\FriendshipRepository;
use BionicUniversity\Bundle\WallBundle\Entity\Post;
use BionicUniversity\Bundle\WallBundle\Form\PostType;

class UploadController extends Controller
{
    public function uploadAction()
    {
        $random = md5(rand());
        $uploadsDir = $this->get('kernel')->getRootDir() . '/../web/uploads/files/';
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadsDir . $random . '_' . $_FILES['file']['name']);

        $array = array(
            'filelink' => $this->get('router')->getContext()->getBaseUrl() . '/uploads/files/' . $random . '_'. $_FILES['file']['name'],
            'filename' => $_FILES['file']['name']
        );

        return new Response(stripslashes(json_encode($array)));
    }
}
