<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;

final class SingleNamespaceHackTest extends \AbstractHackTest {
  protected function getFilename(): string {
    return 'single_namespace_hack.php';
  }

  protected function getPrefix(): string {
    return 'SingleNamespace\\';
  }

  public function testConsistentNames(): void {
    $data =
      "<?hh\n".
      "class Herp extends Foo\Bar {}\n".
      "class Derp extends \Foo\Bar {}\n";

    $parser = FileParser::FromData($data);
    $herp = $parser->getClass('Herp');
    $derp = $parser->getClass('Derp');

    $this->assertSame(
      'Foo\Bar',
      $herp->getParentClassName(),
    );
    $this->assertSame(
      $herp->getParentClassName(),
      $derp->getParentClassName(),
    );
  }
}
