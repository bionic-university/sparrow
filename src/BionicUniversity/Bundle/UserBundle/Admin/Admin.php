<?php
namespace BionicUniversity\Bundle\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin as Base;
use Doctrine\Common\Util\ClassUtils;

class Admin extends Base
{
    public function toString($object)
    {
        if (!is_object($object)) {
            return '';
        }

        if (method_exists($object, '__toString') && null !== $object->__toString()) {
            return (string) $object;
        }
        if (method_exists($object, 'getId') && null !== $object->getId()) {
            return sprintf("%s #%s", ClassUtils::getClass($object), $object->getId());
        }

        return sprintf("new %s", ClassUtils::getClass($object));
    }
}
