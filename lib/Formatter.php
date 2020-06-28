<?php

namespace MiniTool;

class Formatter
{
    /**
     * Echo a message to cli.
     *
     * @param string $message
     * @return void
     */
    public function out($message)
    {
        echo $message;
    }

    /**
     * Ads new line
     *
     * @return void
     */
    public function newLine()
    {
        $this->out("\n");
    }

    /**
     * Displays regular message.
     *
     * @param string $message
     * @return void
     */
    public function display($message)
    {
        $this->out($message);
        $this->newLine();
    }

    /**
     * Displays an error message.
     *
     * @param string $message
     * @return void
     */
    public function error($message)
    {
        $this->out("\033[31mERROR! \033[0m $message");
        $this->newLine();
    }

    /**
     * Displays a hint of info.
     *
     * @param string $message
     * @return void
     */
    public function info($message)
    {
        $this->out("\033[32mHint! \033[0m $message");
        $this->newLine();
    }
}
