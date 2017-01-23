<?php

namespace Instante\Doctrine\DI;

use Instante\Doctrine\Helpers\FixtureSupport;
use Instante\Doctrine\LoadFixturesCommand;
use Kdyby\Console\DI\ConsoleExtension;
use Nette\DI\CompilerExtension;

/**
 * Integration of doctrine/data-fixtures into Nette
 */
class FixturesExtension extends CompilerExtension
{
    private $defaults = [
        'directory' => '%appDir%/fixtures',
    ];

    public function loadConfiguration()
    {
        FixtureSupport::check();
        $config = $this->getConfig($this->defaults);
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('consoleCommandLoadFixtures'))
            ->setClass(LoadFixturesCommand::class, [$config['directory']])
            ->addTag(ConsoleExtension::TAG_COMMAND)
            ->setAutowired(FALSE);
    }

}

