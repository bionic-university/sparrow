<?php

namespace Page;

use Knp\FriendlyContexts\Page\Page;

/**
 * Class ProfilePage
 * @package Page
 */
class ProfilePage extends Page
{
    /**
     * @return string
     */
    public function getPath()
    {
        return '/profile';
    }
}
