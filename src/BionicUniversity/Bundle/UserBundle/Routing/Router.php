<?php

namespace BionicUniversity\Bundle\UserBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as Base;
use Symfony\Component\Routing\Router as BaseRouter;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class Router extends Base
{
    public function __construct(ContainerInterface $container, $resource, array $options = array(), RequestContext $context = null)
    {
        $this->con = $container;
        parent::__construct($container, $resource, $options, $context);

    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return parent::generate($name, array_merge($parameters, ['_token' => $this->con->get('form.csrf_provider')->generateCsrfToken('anything')]), $referenceType);
    }
}
