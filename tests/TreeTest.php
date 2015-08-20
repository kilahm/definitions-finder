<?hh // strict

namespace FredEmmott\DefinitionFinder\Tests;

use FredEmmott\DefinitionFinder\TreeParser;

class TreeTest extends \PHPUnit_Framework_TestCase {
  public function testTreeDefs(): void {
    $parser = TreeParser::FromPath(__DIR__.'/data/');
    // From multiple files
    $classes = $parser->getClassNames();
    $this->assertContains(
      "SingleNamespace\\SimpleClass",
      $classes,
    );
    $this->assertContains(
      "Namespaces\\AreNestedNow\\SimpleClass",
      $classes,
    );
  }
}
