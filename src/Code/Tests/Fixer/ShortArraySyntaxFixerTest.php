<?php

namespace Code\Tests\Fixer;

use Code\Fixer\ShortArraySyntaxFixer;

class ShortArraySyntaxFixerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideExamples
     */
    public function testFix($expected, $input)
    {
        $fixer = new ShortArraySyntaxFixer();
        $file = $this->getTestFile();

        $this->assertEquals($expected, $fixer->fix($file, $input));
    }

    public function provideExamples()
    {
        return [
            ['<?php $x = [];', '<?php $x = array();'],
            ['<?php $x = []; $y = [];', '<?php $x = array(); $y = array();'],
            ['<?php $x = [ ];', '<?php $x = array( );'],
            ['<?php $x = [\'foo\'];', '<?php $x = array(\'foo\');'],
            ['<?php $x = [ \'foo\' ];', '<?php $x = array( \'foo\' );'],
            ['<?php $x = [($y ? true : false)];', '<?php $x = array(($y ? true : false));'],
            ['<?php $x = [($y ? [true] : [false])];', '<?php $x = array(($y ? array(true) : array(false)));'],//
            ['<?php $x = [($y ? [true] : [ false ])];', '<?php $x = array(($y ? array(true) : array( false )));'],
            ['<?php $x = [($y ? ["t" => true] : ["f" => false])];', '<?php $x = array(($y ? array("t" => true) : array("f" => false)));'],
            ['<?php print_r([($y ? true : false)]);', '<?php print_r(array(($y ? true : false)));'],
            ['<?php $x = [[[]]];', '<?php $x = array(array(array()));'],
            ['<?php $x = [[[]]]; $y = [[[]]];', '<?php $x = array(array(array())); $y = array(array(array()));'],
        ];
    }

    private function getTestFile($filename = __FILE__)
    {
        static $files = [];

        if (!isset($files[$filename])) {
            $files[$filename] = new \SplFileInfo($filename);
        }

        return $files[$filename];
    }
}
