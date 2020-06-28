<?php

namespace MiniTool;

class CommandNamespace
{
    /**
     * Namespace name
     *
     * @var String
     */
    protected $name;

    /**
     * Namespace controllers list
     *
     * @var array
     */
    protected $controllers = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns namespace name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Load all controllers in the namespace.
     *
     * @param string $commandsPath
     * @return mixed
     */
    public function loadControllers($commandsPath)
    {
        foreach (glob($commandsPath . '/' . $this->getName() . '/*Controller.php') as $controllerFile) {
            $this->loadCommandMap($controllerFile);
        }

        return $this->getControllers();
    }

    /**
     * Returns controllers list.
     *
     * @return array
     */
    public function getControllers()
    {
        return $this->controllers;
    }

    /**
     * Returns a given controller
     *
     * @param string $commandName
     * @return Lib/CommandController
     */
    public function getController($commandName)
    {
        return isset($this->controllers[$commandName]) ? $this->controllers[$commandName] : null;
    }

    /**
     * Load a controller into controllers array.
     *
     * @param string $controllerFile
     * @return void
     */
    protected function loadCommandMap($controllerFile)
    {
        $filename = basename($controllerFile);

        $controllerClass = str_replace('.php', '', $filename);
        $commandName = strtolower(str_replace('Controller', '', $controllerClass));
        $fullClassName = sprintf("App\\Commands\\%s\\%s", $this->getName(), $controllerClass);

        /** @var CommandController $controller */
        $controller = new $fullClassName();
        $this->controllers[$commandName] = $controller;
    }
}
