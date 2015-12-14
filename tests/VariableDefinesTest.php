<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;

class VariableDefinesTest extends \PHPUnit_Framework_TestCase {
  public function testVariableDefine(): void {
    $data = '<?php define($foo, $bar)';
    $parser = FileParser::FromData($data);
    $this->assertEmpty($parser->getConstants());
  }
}
