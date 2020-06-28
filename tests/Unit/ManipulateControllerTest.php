<?php

use PHPUnit\Framework\TestCase;
use App\Commands\Text\ManipulateController;

class ManipulateControllerTest extends TestCase
{
    public $manipulator;

    public function __construct()
    {
        parent::__construct();
        $this->manipulator = new ManipulateController();
    }

    public function testToUpperCase()
    {
        $lowerCaseString = 'hello world';
        $upperCaseString = 'HELLO WORLD';

        return $this->assertEquals($this->invokeMethod($this->manipulator, 'toUpperCase', [$lowerCaseString]), $upperCaseString);
    }

    public function testAlternateCase()
    {
        $testString = 'hello World';
        $resultString = 'hElLo wOrLd';

        return $this->assertEquals($this->invokeMethod($this->manipulator, 'alternateCase', [$testString]), $resultString);
    }

    public function testPutToFile()
    {
        $testString = 'hello world';
        $expectedReadData = str_split($testString);

        $this->invokeMethod($this->manipulator, 'putToFile', [$testString]);

        $file = fopen('./output.csv', 'r');
        
        return $this->assertEquals($expectedReadData, fgetcsv($file));
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
