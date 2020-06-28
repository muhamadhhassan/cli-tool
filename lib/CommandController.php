<?php

namespace MiniTool;

abstract class CommandController
{
    /**
     * App instance
     *
     * @var Lib/App
     */
    protected $app;

    /**
     * The command call object that holds the command data needed for execution.
     *
     * @var Lib/CommandCall
     */
    protected $input;

    /**
     * Execute the command instructions
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Assign the value of the app instance
     *
     * @param Lib/App $app
     * @return void
     */
    public function boot(App $app)
    {
        $this->app = $app;
    }

    /**
     * Starts Execution
     *
     * @param Lib/CommandCall $input
     * @return void
     */
    public function run(CommandCall $input)
    {
        $this->input = $input;
        $this->handle();
    }

    /**
     * Get input arguments
     *
     * @return void
     */
    protected function getArgs()
    {
        return $this->input->args;
    }
    
    /**
     * Returns command parameters.
     *
     * @return array
     */
    protected function getParams()
    {
        return $this->input->params;
    }

    /**
     * Check if a parameter exists.
     *
     * @param [type] $param
     * @return boolean
     */
    protected function hasParam($param)
    {
        return $this->input->hasParam($param);
    }

    /**
     * Returns Parameter value
     *
     * @param string $param
     * @return string
     */
    protected function getParam($param)
    {
        return $this->input->getParam($param);
    }

    /**
     * Returns the app instance.
     *
     * @return Lib/App
     */
    protected function getApp()
    {
        return $this->app;
    }

    /**
     * Returns app cli formatter instance
     *
     * @return void
     */
    protected function getFormatter()
    {
        return $this->getApp()->getFormatter();
    }
}
