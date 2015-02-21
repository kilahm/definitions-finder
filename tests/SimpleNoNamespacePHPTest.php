<?hh // strict

class SimpleNoNamespacePHPTest extends PHPUnit_Framework_TestCase {
  private ?FredEmmott\DefinitionFinder\FileParser $parser;

  protected function setUp(): void {
    $this->parser = \FredEmmott\DefinitionFinder\FileParser::fromFile(
      __DIR__.'/data/no_namespace_php.php'
    );
  }

  public function testClasses(): void {
    $this->assertEquals(
      Vector {
        'SimpleClass',
        'SimpleAbstractClass',
        'SimpleFinalClass',
      },
      $this->parser?->getClasses(),
    );
  }

  public function testInterfaces(): void {
    $this->assertEquals(
      Vector { 'SimpleInterface' },
      $this->parser?->getInterfaces(),
    );
  }

  public function testTraits(): void {
    $this->assertEquals(
      Vector { 'SimpleTrait' },
      $this->parser?->getTraits(),
    );
  }
}
