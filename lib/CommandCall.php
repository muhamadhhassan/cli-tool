<?php

namespace MiniTool;

class CommandCall
{
    /**
     * The namespace of the input command
     *
     * @var string
     */
    public $command;

    /**
     * The subcommand of the input command ex "text manipulate"
     *
     * @var string
     */
    public $subcommand;

    /**
     * The complete user input from the cli
     *
     * @var array
     */
    public $args = [];

    /**
     * Command parameters
     *
     * @var array
     */
    public $params = [];

    public function __construct(array $argv)
    {
        $this->args = $argv;
        $this->command = isset($argv[1]) ? $argv[1] : null;
        $this->subcommand = isset($argv[2]) ? $argv[2] : 'default';

        $this->loadParams($argv);
    }

    /**
     * Extract the parameters from the cli input
     *
     * @param array $args
     * @return void
     */
    protected function loadParams(array $args)
    {
        foreach ($args as $arg) {
            $pair = explode('=', $arg);
            if (count($pair) == 2) {
                $this->params[$pair[0]] = $pair[1];
            }
        }
    }

    /**
     * Check if a parameter exists.
     *
     * @param string $param
     * @return boolean
     */
    public function hasParam($param)
    {
        return isset($this->params[$param]);
    }

    /**
     * Returns a given parameter value.
     *
     * @param string $param
     * @return void
     */
    public function getParam($param)
    {
        return $this->hasParam($param) ? $this->params[$param] : null;
    }
}
