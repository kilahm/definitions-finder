<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;
use FredEmmott\DefinitionFinder\ScannedClass;

class ClassContentsTest extends \PHPUnit_Framework_TestCase {
  private ?ScannedClass $class;

  protected function setUp(): void {
    $parser = FileParser::FromFile(
      __DIR__.'/data/class_contents.php'
    );
    $this->class = $parser->getClasses()[0];
    $this->assertSame(
      'FredEmmott\\DefinitionFinder\\Test\\ClassWithContents',
      $this->class->getName(),
    );
  }

  public function testHasMethod(): void {
    $this->assertNotEmpty($this->class?->getMethods());
  }

  public function testMethodName(): void {
    $this->assertSame(
      'doFoo',
      $this->class?->getMethods()?->get(0)?->getName(),
    );
  }
}
