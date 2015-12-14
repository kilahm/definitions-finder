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

    // Check that it parses
    $parser = FileParser::FromData($data);
    $this->assertNotNull($parser->getFunction('select'));
  }

  public function testConstantCalledOn(): void {
    $data = '<?hh class Foo { const ON = 0; }';

    $this->assertEquals(
      Vector { 'ON' },
      FileParser::FromData($data)
      ->getClass('Foo')
      ->getConstants()
      ->map($x ==> $x->getName())
    );
  }

  public function testClassMagicConstant(): void {
      $data = "<?hh Foo::class;\nclass Foo{}";

      // Make sure that Foo::class tokenizes as T_STRING, T_DOUBLE_COLON, T_CLASS
      $tokens = token_get_all($data);
      $this->assertContains([T_CLASS, 'class', 1], $tokens);

      // This could throw because the ; comes after the keyword class
      $this->assertEquals(
          'Foo',
          FileParser::FromData($data)
          ->getClass('Foo')
          ->getName()
      );
  }
}
