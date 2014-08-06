<?php
namespace BionicUniversity\Bundle\UserBundle\Twig;

use Symfony\Bridge\Twig\Extension\RoutingExtension as Base;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RoutingExtension extends Base
{

    public function __construct(RouterInterface $generator, CsrfProviderInterface $csrfProvider)
    {
        $this->router = $generator;
        $this->csrfProvider = $csrfProvider;
    }

    public function getPath($name, $parameters = array(), $relative = false)
    {
        return $this->router->generate($name, array_merge($parameters, ['_token' => $this->generateToken()]), $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    private function generateToken()
    {
        return $this->csrfProvider->generateCsrfToken('anything');
    }
}
