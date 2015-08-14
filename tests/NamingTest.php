<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;

// Hack is unaware of this
const int T_SELECT = 422;
const int T_ON = 415;

class NamingTest extends \PHPUnit_Framework_TestCase {
  public function testFunctionCalledSelect(): void {
    // 'select' is a T_SELECT, not a T_STRING
    $data = '<?hh function select() {}';

    // Check that we're still testing a 'magic' function name
    $tokens = token_get_all($data);
    $this->assertContains([T_SELECT, 'select', 1], $tokens);

    // Check that it parses
    $parser = FileParser::FromData($data);
    $this->assertNotNull($parser->getFunction('select'));
  }

  public function testConstantCalledOn(): void {
    $data = '<?hh class Foo { const ON = 0; }';

    $tokens = token_get_all($data);
    $this->assertContains([T_ON, 'ON', 1], $tokens);

    $this->assertEquals(
      Vector { 'ON' },
      FileParser::FromData($data)
      ->getClass('Foo')
      ->getConstants()
      ->map($x ==> $x->getName())
    );
  }
}
