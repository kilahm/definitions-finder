<?hh // strict

final class MultiNamespacePHPTest extends PHPUnit_Framework_TestCase {
  private ?FredEmmott\DefinitionFinder\FileParser $parser;

  protected function setUp(): void {
    $this->parser = \FredEmmott\DefinitionFinder\FileParser::fromFile(
      __DIR__.'/data/multi_namespace_php.php',
    );
  }

  public function testClasses(): void {
    $this->assertEquals(
      Vector {
        'Foo\\Bar',
        'Herp\\Derp',
        'EmptyNamespace',
      },
      $this->parser?->getClasses(),
    );
  }
}
