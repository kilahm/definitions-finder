<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;
use FredEmmott\DefinitionFinder\ScannedTypehint;

class ParameterVariantsTest extends \PHPUnit_Framework_TestCase {
  public function testBasicParameter(): void {
    $data = '<?hh function foo($bar) {}';
    $parser = FileParser::FromData($data);
    $function = $parser->getFunction('foo');
    
    $params = $function->getParameters();
    $this->assertEquals(
      Vector { '$bar' },
      $function->getParameters()->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { null },
      $function->getParameters()->map($x ==> $x->getTypehint()),
    );
  }

  public function testTypedParameter(): void {
    $data = '<?hh function foo(string $bar) {}';
    $parser = FileParser::FromData($data);
    $function = $parser->getFunction('foo');
    
    $params = $function->getParameters();
    $this->assertEquals(
      Vector { '$bar' },
      $function->getParameters()->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { new ScannedTypehint('string', Vector { }) },
      $function->getParameters()->map($x ==> $x->getTypehint()),
    );
  }

  public function testParameterWithDefault(): void {
    $data = '<?hh function foo($bar = "baz") {}';
    $parser = FileParser::FromData($data);
    $function = $parser->getFunction('foo');
    
    $params = $function->getParameters();
    $this->assertEquals(
      Vector { '$bar' },
      $function->getParameters()->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { null },
      $function->getParameters()->map($x ==> $x->getTypehint()),
    );
    $this->markTestIncomplete("can't currently retrieve default values");
  }

  public function testTypedParameterWithDefault(): void {
    $data = '<?hh function foo(string $bar = "baz") {}';
    $parser = FileParser::FromData($data);
    $function = $parser->getFunction('foo');
    
    $params = $function->getParameters();
    $this->assertEquals(
      Vector { '$bar' },
      $function->getParameters()->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { new ScannedTypehint('string', Vector { }) },
      $function->getParameters()->map($x ==> $x->getTypehint()),
    );
    $this->markTestIncomplete("can't currently retrieve default values");
  }
}
