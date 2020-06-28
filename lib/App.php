<?php

namespace MiniTool;

class App
{
    /**
     * Cli Formatter
     *
     * @var Lib/Formatter
     */
    protected $formatter;

    /**
     * Command Registry Object that load tha available commands
     *
     * @var Lib/CommandRegistry
     */
    protected $commandRegistry;

    public function __construct()
    {
        $this->formatter = new Formatter();
        $this->commandRegistry = new CommandRegistry(__DIR__ . '/../app/Commands');
    }

    /**
     * Returns the app cli formatter
     *
     * @return Lib/Formatter
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * Support creating commands with anonymous functions.
     *
     * @param string $name
     * @param callback $callable
     * @return void
     */
    public function registerCommand($name, $callable)
    {
        $this->commandRegistry->registerCommand($name, $callable);
    }

    /**
     * Receives user input from cli and execute the command
     * If the command was not found in the loaded controllers
     * It tries to look it up in the single commands.
     *
     * @param array $argv
     * @return void
     */    
    public function runCommand(array $argv = [])
    {
        $input = new CommandCall($argv);

        $controller = $this->commandRegistry->getCallableController($input->command, $input->subcommand);

        if ($controller instanceof CommandController) {
            $controller->boot($this);
            $controller->run($input);
            exit;
        }

        $this->runSingle($input);
    }

    /**
     * Execute the command if it was found in the registry.
     *
     * @param Lib/CommandCall $input
     * @return void
     */
    public function runSingle(CommandCall $input)
    {
        try {
            $callable = $this->commandRegistry->getCallable($input->command);
            call_user_func($callable, $input);
        } catch (\Exception $e) {
            $this->getFormatter()->display("ERROR: " . $e->getMessage());
            exit;
        }
    }
}
