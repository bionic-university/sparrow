<?php

namespace Page;

use Knp\FriendlyContexts\Page\Page;

/**
 * Class ConfirmationPage
 * @package Page
 */
class ConfirmationPage extends Page
{
    /**
     * @return string
     */
    public function getPath()
    {
        return '/register/confirm/{token}';
    }
}
