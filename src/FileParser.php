<?hh // strict

namespace FredEmmott\DefinitionFinder;

class FileParser extends BaseParser {
  private function __construct(
    private string $file,
    TokenQueue $tq,
  ) {
    try {
      $this->defs = (new ScopeConsumer(
        $tq,
        shape(
          'filename' => $file,
          'namespace' => null,
          'aliases' => ImmMap { },
          'sourceType' => SourceType::NOT_YET_DETERMINED,
          'genericTypeNames' => ImmSet { },
        ),
        ScopeType::FILE_SCOPE,
      ))->getBuilder()->build();
    } catch (/* HH_FIXME[2049] */ \HH\InvariantException $e) {
      throw new ParseException(
        shape('filename' => $file, 'line' => $tq->getLine()),
        $e
      );
    }
  }

  ///// Constructors /////

  public static function FromFile(
    string $filename,
  ): FileParser {
    return self::FromData(file_get_contents($filename), $filename);
  }

  public static function FromData(
    string $data,
    ?string $filename = null,
  ): FileParser {
    return new FileParser(
      $filename === null ? '__DATA__' : $filename,
      new TokenQueue($data),
    );
  }

  ///// Accessors /////

  public function getFilename(): string { return $this->file; }
}
