<?hh // strict

namespace FredEmmott\DefinitionFinder\Tests;

use FredEmmott\DefinitionFinder\FileParser;
use FredEmmott\DefinitionFinder\SourceType;

class SourceTypeTest extends \PHPUnit_Framework_TestCase {

  public function getExamples(): array<(string, SourceType)> {
    return [
      tuple('<?hh', SourceType::HACK_PARTIAL),
      tuple('<?hh // foo', SourceType::HACK_PARTIAL),
      tuple("<?hh\n// strict", SourceType::HACK_PARTIAL),
      tuple("<?hh // strict", SourceType::HACK_STRICT),
      tuple("<?hh //strict", SourceType::HACK_STRICT),
      tuple("<?hh // decl", SourceType::HACK_DECL),
      tuple('<?php', SourceType::PHP),
      tuple('<?', SourceType::PHP),
    ];
  }

  /**
   * @dataProvider getExamples
   */
  public function testHasExpectedType(
    string $prefix,
    SourceType $expected,
  ): void {
    $code = $prefix."\nclass Foo {}";
    $parser = FileParser::FromData($code);
    $this->assertSame(
      $expected,
      $parser->getClass('Foo')->getSourceType(),
    );
  }
}
