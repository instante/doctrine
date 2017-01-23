<?php

namespace Instante\Doctrine\DI;

use Instante\Doctrine\FixtureLoader;
use Instante\Doctrine\Helpers\FixtureSupport;
use Instante\Doctrine\LoadFixturesCommand;
use Kdyby\Console\DI\ConsoleExtension;
use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Nette\DI\Helpers as DiHelpers;
use Nette\DI\Statement;

/**
 * Integration of doctrine/data-fixtures into Nette
 */
class FixturesExtension extends CompilerExtension
{
    private $defaults = ['fixtures' => []];

    public function loadConfiguration()
    {
        FixtureSupport::check();
        $config = $this->getConfig($this->defaults);
        $builder = $this->getContainerBuilder();

        $fixtureLoaderDef = $builder->addDefinition($this->prefix('fixtureLoader'))
            ->setClass(FixtureLoader::class);

        foreach ($config['fixtures'] as $i => $fixtureClass) {
            $this->addFixtureDefinition($fixtureLoaderDef, $i, $fixtureClass);
        }

        $builder->addDefinition($this->prefix('consoleCommandLoadFixtures'))
            ->setClass(LoadFixturesCommand::class)
            ->addTag(ConsoleExtension::TAG_COMMAND)
            ->setAutowired(FALSE);
    }

    private function addFixtureDefinition(ServiceDefinition $loaderDef, $index, $fixtureClass)
    {
        $serviceName = $this->prefix(sprintf('fixtures.%d', $index));
        $fixtureDef = $this->getContainerBuilder()->addDefinition($serviceName);

        $fixtureDef->setFactory(DiHelpers::filterArguments([
            is_string($fixtureClass) ? new Statement($fixtureClass) : $fixtureClass,
        ])[0]);

        $fixtureDef->setAutowired(false);
        $loaderDef->addSetup('addFixture', ['@'.$serviceName]);
    }

}

