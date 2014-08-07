<?php

namespace BionicUniversity\Bundle\UserBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;

class BundleFixturesLoader extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return  array(
            __DIR__ . '/../../Resources/fixtures/departments.yml',
            __DIR__ . '/../../Resources/fixtures/user.yml',
            __DIR__ . '/../../Resources/fixtures/interests.yml',

        );
    }
}
