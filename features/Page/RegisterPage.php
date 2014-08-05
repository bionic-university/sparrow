<?php

namespace Page;

use Knp\FriendlyContexts\Page\Page;

/**
 * Class RegisterPage
 * @package Page
 */
class RegisterPage extends Page
{
    /**
     * @return string
     */
    public function getPath()
    {
        return '/register';
    }
}
