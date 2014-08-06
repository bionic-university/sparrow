<?php

namespace Page;

use Knp\FriendlyContexts\Page\Page;

/**
 * Class RegistrationConfirmedPage
 * @package Page
 */
class RegistrationConfirmedPage extends Page
{
    /**
     * @return string
     */
    public function getPath()
    {
        return '/register/confirmed';
    }
}
