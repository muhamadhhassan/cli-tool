<?php

namespace MiniTool;

class CommandRegistry
{
    /**
     * Commands directory path
     *
     * @var string
     */
    protected $commandsPath;

    /**
     * Namespaces array
     *
     * @var array
     */
    protected $namespaces = [];

    /**
     * Single commands array.
     *
     * @var array
     */
    protected $defaultRegistry = [];

    public function __construct($commandsPath)
    {
        $this->commandsPath = $commandsPath;
        $this->autoloadNamespaces();
    }

    /**
     * Load all namespaces in the given path
     *
     * @return void
     */
    public function autoloadNamespaces()
    {
        foreach (glob($this->getCommandsPath() . '/*', GLOB_ONLYDIR) as $namespacePath) {
            $this->registerNamespace(basename($namespacePath));
        }
    }

    /**
     * Register a namespace in the namespaces array
     *
     * @param string $commandNamespace
     * @return void
     */
    public function registerNamespace($commandNamespace)
    {
        $namespace = new CommandNamespace($commandNamespace);
        $namespace->loadControllers($this->getCommandsPath());
        $this->namespaces[strtolower($commandNamespace)] = $namespace;
    }

    /**
     * Returns all namespaces
     *
     * @return void
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * Returns a single namespace.
     *
     * @param string $command
     * @return void
     */
    public function getNamespace($command)
    {
        return isset($this->namespaces[$command]) ? $this->namespaces[$command] : null;
    }

    /**
     * Returns commands directory path
     *
     * @return void
     */
    public function getCommandsPath()
    {
        return $this->commandsPath;
    }

    /**
     * Register a single command.
     *
     * @param string $name
     * @param callback $callable
     * @return void
     */
    public function registerCommand($name, $callable)
    {
        $this->defaultRegistry[$name] = $callable;
    }

    /**
     * Returns a single command.
     *
     * @param string $command
     * @return mixed
     */
    public function getCommand($command)
    {
        return isset($this->defaultRegistry[$command]) ? $this->defaultRegistry[$command] : null;
    }

    public function getCallableController($command, $subcommand = null)
    {
        $namespace = $this->getNamespace($command);

        if ($namespace !== null) {
            return $namespace->getController($subcommand);
        }

        return null;
    }

    /**
     * Return a single command callback.
     *
     * @param string $command
     * @return callback
     */
    public function getCallable($command)
    {
        $singleCommand = $this->getCommand($command);
        if ($singleCommand === null) {
            throw new \Exception(sprintf("Command \"%s\" not found.", $command));
        }

        return $singleCommand;
    }
}
