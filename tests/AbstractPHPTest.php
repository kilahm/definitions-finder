<?hh // strict

abstract class AbstractPHPTest extends PHPUnit_Framework_TestCase {
  private ?FredEmmott\DefinitionFinder\FileParser $parser;

  abstract protected function getFilename(): string;
  abstract protected function getPrefix(): string;

  protected function setUp(): void {
    $this->parser = \FredEmmott\DefinitionFinder\FileParser::FromFile(
      __DIR__.'/data/'.$this->getFilename(),
    );
  }

  public function testClasses(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'SimpleClass',
        $this->getPrefix().'SimpleAbstractClass',
        $this->getPrefix().'SimpleFinalClass',
      },
      $this->parser?->getClassNames(),
    );
  }

  public function testInterfaces(): void {
    $this->assertEquals(
      Vector { $this->getPrefix().'SimpleInterface' },
      $this->parser?->getInterfaces(),
    );
  }

  public function testTraits(): void {
    $this->assertEquals(
      Vector { $this->getPrefix().'SimpleTrait' },
      $this->parser?->getTraits(),
    );
  }
}
