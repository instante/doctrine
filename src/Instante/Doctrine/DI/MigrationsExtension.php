<?php
/**
 * Based on Nella Framework component (http://nellafw.org).
 * please view the file license.md that was distributed with this source code.
 * Works with Kdyby framework instead of Nella
 */

namespace Instante\Doctrine\DI;

use Kdyby\Console\DI\ConsoleExtension;
use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\Utils\Strings;
use Symfony\Component\Console\Output\ConsoleOutput;
use Doctrine\DBAL\Migrations\OutputWriter;
use Nette\DI\CompilerExtension;

/**
 * Doctrine migration for Instante
 *
 * @author Patrik Votoček
 * @author Richard Ejem
 *
 * @property array defaults
 */
class MigrationsExtension extends CompilerExtension
{
    const DEFAULT_EXTENSION_NAME = 'migrations';

    public $defaultName = NULL;

    /**
     * @return array
     */
    public function getDefaults()
    {
        return array(
            'name' => $this->defaultName ?: 'Integration of Doctrine migrations into Nette',
            'connection' => '@doctrine.default.connection',
            'table' => 'db_version',
            'directory' => '%appDir%/migrations',
            'namespace' => 'App\Doctrine\Migrations',
            'console' => TRUE,
        );
    }

    /**
     * Processes configuration data
     *
     * @return void
     */
    public function loadConfiguration()
    {
        if (!$this->getConfig()) { // ignore migrations if config section not exist
            return;
        }

        $config = $this->getConfig($this->getDefaults());
        $builder = $this->getContainerBuilder();

        $connection = Strings::startsWith($config['connection'], '@')
            ? $config['connection'] : ('@' . $config['connection']);

        $consoleOutput = $builder->addDefinition($this->prefix('consoleOutput'))
            ->setClass('Doctrine\DBAL\Migrations\OutputWriter')
            ->setFactory(get_called_class() . '::createConsoleOutput')
            ->setAutowired(FALSE);

        $configuration = $builder->addDefinition($this->prefix('configuration'))
            ->setClass('Doctrine\DBAL\Migrations\Configuration\Configuration', array(
                $connection,
                $consoleOutput,
            ))
            ->addSetup('setName', array($config['name']))
            ->addSetup('setMigrationsTableName', array($config['table']))
            ->addSetup('setMigrationsDirectory', array($config['directory']))
            ->addSetup('setMigrationsNamespace', array($config['namespace']))
            ->addSetup('registerMigrationsFromDirectory', array($config['directory']));

        if (isset($config['console']) && $config['console']) {
            $this->processConsole($configuration);
        }
    }

    /**
     * @param \Nette\DI\ServiceDefinition|string
     */
    protected function processConsole($configuration)
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('consoleCommandDiff'))
            ->setClass('Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand')
            ->addSetup('setMigrationConfiguration', array($configuration))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setAutowired(FALSE);
        $builder->addDefinition($this->prefix('consoleCommandExecute'))
            ->setClass('Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand')
            ->addSetup('setMigrationConfiguration', array($configuration))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setAutowired(FALSE);
        $builder->addDefinition($this->prefix('consoleCommandGenerate'))
            ->setClass('Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand')
            ->addSetup('setMigrationConfiguration', array($configuration))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setAutowired(FALSE);
        $builder->addDefinition($this->prefix('consoleCommandLatest'))
            ->setClass('Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand')
            ->addSetup('setMigrationConfiguration', array($configuration))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setAutowired(FALSE);
        $builder->addDefinition($this->prefix('consoleCommandMigrate'))
            ->setClass('Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand')
            ->addSetup('setMigrationConfiguration', array($configuration))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setAutowired(FALSE);
        $builder->addDefinition($this->prefix('consoleCommandStatus'))
            ->setClass('Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand')
            ->addSetup('setMigrationConfiguration', array($configuration))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setAutowired(FALSE);
        $builder->addDefinition($this->prefix('consoleCommandVersion'))
            ->setClass('Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand')
            ->addSetup('setMigrationConfiguration', array($configuration))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setAutowired(FALSE);
    }

    /**
     * @return \Doctrine\DBAL\Migrations\OutputWriter
     */
    public static function createConsoleOutput()
    {
        $output = new ConsoleOutput;
        return new OutputWriter(function ($message) use ($output) {
            $output->write($message, TRUE);
        });
    }

    /**
     * Register extension to compiler.
     *
     * @param \Nette\Configurator
     * @param string
     */
    public static function register(Configurator $configurator, $name = self::DEFAULT_EXTENSION_NAME)
    {
        $class = get_called_class();
        $configurator->onCompile[] = function (Configurator $configurator, Compiler $compiler) use ($class, $name) {
            $compiler->addExtension($name, new $class);
        };
    }
}

