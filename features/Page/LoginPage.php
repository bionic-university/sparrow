<?php

namespace Page;

use Knp\FriendlyContexts\Page\Page;

/**
 * Class LoginPage
 * @package Page
 */
class LoginPage extends Page
{
    /**
     * @return string
     */
    public function getPath()
    {
        return '/login';
    }
}
