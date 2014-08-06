<?php

namespace Context;

use App\Document\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Knp\FriendlyContexts\Context\RawPageContext;
use Page\ConfirmPage;
use Symfony\Component\PropertyAccess\PropertyAccess;

class SecurityContext extends RawPageContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;

    /**
     * Supports only one account at the moment
     * @Given I have an account with the following:
     */
    public function iHaveAnAccountWithTheFollowing(TableNode $table)
    {
        $userManager = $this->getService('bionic.user.util.user_manipulator');
        $userVars = [
            'username' => null,
            'plain_password' => null,
            'last_name' => null,
            'first_name' => null,
            'email' => null,
            'enabled' => 1,
            'super_admin' => 1,
        ];

        foreach ($table as $row) {
            foreach ($row as $key => $value) {
                if (!array_key_exists($key, $userVars)) {
                    throw new \RuntimeException(sprintf('Key % for array with default keys %s does not exist', $key, implode(',', $userVars)));
                }
                $userVars[$key] = $value;
            }
        }
        array_walk($userVars, function ($element, $key) {
            if (null === $element) {
                throw new \RuntimeException(sprintf('Table cell "%s" should be added', $key));
            }
        });
        $userManager->create($userVars['username'],
            $userVars['first_name'],
            $userVars['last_name'], $userVars['plain_password'], $userVars['email'], $userVars['enabled'], $userVars['super_admin'] );
    }

    /**
     * @When I go to the confirmation page with confirmation token for :username
     */
    public function iConfirmRegistrationWithToken($username)
    {
        $documentManager = $this->getService('doctrine.orm.entity_manager');
        /** @var \App\Document\User $user */
        $user = $documentManager
            ->getRepository('BionicUniversityUserBundle:User')
            ->findOneBy(['username' => $username]);
        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->getService('fos_user.util.token_generator')->generateToken());
            $documentManager->flush($user);
        }

        $this->visitPage('confirmation', ['token' => $user->getConfirmationToken()]);
    }
    /**
     * Gets a service by id.
     *
     * @param $alias
     * @return object
     */
    protected function getService($alias)
    {
        return $this->getKernel()->getContainer()->get($alias);
    }

    /**
     * @param $parameter
     * @return mixed
     */
    protected function getAppParameter($parameter)
    {
        return $this->getKernel()->getContainer()->getParameter($parameter);
    }
}
