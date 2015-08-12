<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;

class SelfTest extends \PHPUnit_Framework_TestCase {

  public function filenameProvider(): array<array<string>> {
    return array_map(
      $filename ==> [basename($filename), $filename],
      glob(dirname(__DIR__).'/src/**/*.php'),
    );
  }

  /**
   * @dataProvider filenameProvider
   *
   * Bogus first argument to make test failure messages more useful
   */
  public function testSelf(string $_, string $filename): void {
    $parser = FileParser::FromFile($filename);
    $this->assertNotNull($parser);
  }

  public function elfSectionsProvider(): array<array<string>> {
    $extractor = new \HHVM\SystemlibExtractor\SystemlibExtractor();
    return $extractor->getSectionNames()
      ->toVector()
      ->map($name ==> [$name, $extractor->getSectionContents($name)])
      ->toArray();
  }

  /**
   * @dataProvider elfSectionsProvider
   */
  public function testELFSection(string $name, string $bytes): void {
    try {
      $parser = FileParser::FromData($bytes, $name);
    } catch (\Exception $e) {
      file_put_contents(
        '/tmp/'.$name.'.php',
        $bytes,
      );
      throw $e;
    }
    $this->assertNotNull($parser);
  }
}
