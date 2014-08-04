<?php
namespace BionicUniversity\Bundle\UserBundle\Twig;

use Symfony\Bridge\Twig\Extension\RoutingExtension as Base;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;

class RoutingExtension extends Base
{

    private $provider;

    public function getPath($name, $parameters = array(), $relative = false)
    {
        return parent::getPath($name, array_merge($parameters, ['_token' => $this->generateToken()]), $relative);
    }

    public function setCsrfProvider(CsrfProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    private function generateToken()
    {
        return $this->provider->generateCsrfToken('anything');
    }

}
