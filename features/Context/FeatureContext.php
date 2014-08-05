<?php

namespace Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\DropSchemaDoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Knp\FriendlyContexts\Context\RawPageContext;

use Symfony\Component\PropertyAccess\PropertyAccess;

class FeatureContext extends RawPageContext implements Context, SnippetAcceptingContext
{
    use KernelDictionary;

    /**
     * @BeforeScenario
     */
    public function clearCache()
    {
        $this->execute('cache:clear');
    }

    /**
     * Executes registered Symfony2 command in app.
     *
     * @param $alias
     * @param array $options
     */
    protected function execute($alias, array $options = [])
    {
        $application = new Application($this->getKernel());

        $application->add(new CacheClearCommand());
        $application->add(new DropSchemaDoctrineCommand());
        $application->add(new DropDatabaseDoctrineCommand());
        $application->add(new CreateSchemaDoctrineCommand());
        $application->add(new CreateDatabaseDoctrineCommand());

        $arguments = array_merge(['command' => $alias], $options, ['--env' => 'test']);
        var_dump($arguments);
        $output = new BufferedOutput();
        $application->find($alias)->run(new ArrayInput($arguments), new BufferedOutput());
        var_dump($output->fetch());
    }
}
