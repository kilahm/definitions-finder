<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;
use FredEmmott\DefinitionFinder\ScannedBase;
use FredEmmott\DefinitionFinder\ScannedClass;
use FredEmmott\DefinitionFinder\ScannedFunction;

class AttributesTest extends \PHPUnit_Framework_TestCase {
  private \ConstVector<ScannedClass> $classes = Vector {};
  private \ConstVector<ScannedFunction> $functions = Vector {};

  protected function setUp(): void {
    $parser = FileParser::FromFile(
      __DIR__.'/data/attributes.php'
    );
    $this->classes = $parser->getClasses();
    $this->functions = $parser->getFunctions();
  }

  public function testSingleSimpleAttribute(): void {
    $class = $this->findClass('ClassWithSimpleAttribute');
    $this->assertEquals(
      Map { "Foo" => Vector { } },
      $class->getAttributes(),
    );
  }

  public function testMultipleSimpleAttributes(): void {
    $class = $this->findClass('ClassWithSimpleAttributes');
    $this->assertEquals(
      Map { "Foo" => Vector { }, "Bar" => Vector { } },
      $class->getAttributes(),
    );
  }

  public function testWithSingleStringAttribute(): void {
    $class = $this->findClass('ClassWithStringAttribute');
    $this->assertEquals(
      Map { 'Herp' => Vector {'derp'} },
      $class->getAttributes(),
    );
  }

  public function testWithFormattedAttributes(): void {
    $class = $this->findClass('ClassWithFormattedAttributes');
    $this->assertEquals(
      Map { 'Foo' => Vector { }, 'Bar' => Vector {'herp', 'derp'} },
      $class->getAttributes(),
    );
  }

  public function testWithSingleIntAttribute(): void {
    $class = $this->findClass('ClassWithIntAttribute');
    $this->assertEquals(
      Map { 'Herp' => Vector {123} },
      $class->getAttributes(),
    );
    // Check it's an int, not a string
    $this->assertSame(
      123,
      $class->getAttributes()['Herp'][0],
    );
  }

  public function testFunctionHasAttributes(): void {
    $func = $this->findScanned($this->functions, 'function_after_classes');
    $this->assertEquals(
      Map { 'FunctionFoo' => Vector { } },
      $func->getAttributes(),
    );
  }

  public function testFunctionContainingBitShift(): void {
    $data = '<?hh function foo() { 1 << 3; }';
    $parser = FileParser::FromData($data);
    $fun = $parser->getFunction('foo');
    $this->assertEmpty($fun->getAttributes());
  }

  public function testFunctionAttrsDontPolluteClass(): void {
    $class = $this->findClass('ClassAfterFunction');
    $this->assertEquals(
      Map { 'ClassFoo' => Vector {} },
      $class->getAttributes(),
    );
  }

  public function testParameterHasAttribute(): void {
    $data = '<?hh function foo(<<Bar>> $baz) {}';
    $parser = FileParser::FromData($data);
    $fun = $parser->getFunction('foo');
    $params = $fun->getParameters();
    $this->assertEquals(
      Vector { 'baz' },
      $params->map($x ==> $x->getName()),
    );

    $this->assertEquals(
      Vector { Map { 'Bar' => Vector { } } },
      $params->map($x ==> $x->getAttributes()),
    );
  }

  public function testConcatenatedValues(): void {
    $data = "<?hh <<__Deprecated('herp'.'derp')>> function foo(){}";
    $parser = FileParser::FromData($data);
    $fun = $parser->getFunction('foo');
    $this->assertEquals(
      Map { '__Deprecated' => Vector { 'herpderp' } },
      $fun->getAttributes(),
    );
  }

  private function findScanned<T as ScannedBase>(
    \ConstVector<T> $container,
    string $name,
  ): T {
    foreach ($container as $scanned) {
      if ($scanned->getName() === "FredEmmott\\DefinitionFinder\\Test\\".$name) {
        return $scanned;
      }
    }
    invariant_violation('Could not find scanned %s', $name);
  }

  private function findClass(string $name): ScannedClass {
    return $this->findScanned($this->classes, $name);
  }
}
