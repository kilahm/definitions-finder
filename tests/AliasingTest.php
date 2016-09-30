<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;

final class AliasingTest extends \PHPUnit_Framework_TestCase {
  public function testSimpleUse(): void {
    $code =
      "<?hh\n".
      "namespace MyNamespace;\n".
      "use MyOtherNamespace\\Foo;\n".
      'class Bar extends Foo {}';
    $def = FileParser::FromData($code)->getClass('MyNamespace\\Bar');
    $this->assertSame(
      "MyOtherNamespace\\Foo",
      $def->getParentClassName(),
    );
  }

  public function testUseWithClassAlias(): void {
    $code =
      "<?hh\n".
      "namespace MyNamespace;\n".
      "use MyOtherNamespace\\Foo as SuperClass;\n".
      'class Bar extends SuperClass {}';
    $def = FileParser::FromData($code)->getClass('MyNamespace\\Bar');
    $this->assertSame(
      "MyOtherNamespace\\Foo",
      $def->getParentClassName(),
    );
  }

  public function testUseWithNSAlias(): void {
    $code =
      "<?hh\n".
      "namespace MyNamespace;\n".
      "use MyOtherNamespace as OtherNS;\n".
      "class Bar extends OtherNS\\Foo{}";
    $def = FileParser::FromData($code)->getClass('MyNamespace\\Bar');
    $this->assertSame(
      "MyOtherNamespace\\Foo",
      $def->getParentClassName(),
    );
  }
}
