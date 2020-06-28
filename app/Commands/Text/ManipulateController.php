<?php

namespace App\Commands\Text;

use Exception;
use MiniTool\CommandController;

class ManipulateController extends CommandController
{
    /**
     * Execution entry point.
     *
     * @param string $string
     * @return void
     */
    public function handle()
    {   
        $this->getFormatter()->info('Type some text and hit return...');
        $string = trim(fgets(STDIN));

        try {
            $this->validateInput($string);
            $this->processString($string);
        } catch (\Exception $e) {
            $this->getFormatter()->error($e->getMessage());
        }
    }
    
    /**
     * Applies transformation on the given string.
     *
     * @param [type] $string
     * @return void
     */
    protected function processString($string)
    {
        $this->getFormatter()->display(sprintf($this->toUpperCase($string)));
        $this->getFormatter()->display(sprintf($this->alternateCase($string)));
        
        if($this->putToFile($string)) {
            $this->getFormatter()->display("CSV Created!");
        }
    }

    /**
     * Returns the string in all caps.
     *
     * @param string $string
     * @return void
     */
    protected function toUpperCase($string)
    {
        return strtoupper($string);
    }

    /**
     * Returns the string in alternating casing. 
     *
     * @param string $string
     * @return void
     */
    protected function alternateCase($string)
    {
        $charArray = str_split($string);

        for ($i=1; $i <= count($charArray) ; $i++) { 
            if ($i % 2) {
                $charArray[$i - 1] = strtolower($charArray[$i - 1]);
            } else {
                $charArray[$i - 1] = strtoupper($charArray[$i - 1]);
            }
        }

        return implode('', $charArray);
    }

    /**
     * Creates a csv file and save the given string as comma separated values.
     *
     * @param string $string
     * @return mixed
     */
    protected function putToFile($string)
    {
        $file = fopen('./output.csv', 'w');
        $charArray = str_split($string);
        fputcsv($file, $charArray);

        return fclose($file);
    }

    /**
     * Validate the input is not empty.
     *
     * @param string $input
     * @return mixed
     */
    protected function validateInput($input)
    {
        if(!empty($input)) {
            return;
        }

        throw new Exception('You entered an empty string!');
    }
}
