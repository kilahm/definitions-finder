<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;
use FredEmmott\DefinitionFinder\ScannedClass;

class ClassAttributesTest extends \PHPUnit_Framework_TestCase {
  private \ConstVector<ScannedClass> $classes
    = Vector {};

  protected function setUp(): void {
    $parser = FileParser::FromFile(
      __DIR__.'/data/class_attributes.php'
    );
    $this->classes = $parser->getClasses();
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

  private function findClass(string $name): ScannedClass {
    foreach ($this->classes as $class) {
      if ($class->getName() === "FredEmmott\\DefinitionFinder\\Test\\".$name) {
        return $class;
      }
    }
    invariant_violation('Could not find class %s', $name);
  }
}
