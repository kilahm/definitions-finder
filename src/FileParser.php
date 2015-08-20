<?hh // strict

namespace FredEmmott\DefinitionFinder;

class FileParser extends BaseParser {
  private function __construct(
    private string $file,
    TokenQueue $tq,
  ) {
    $this->defs = (new ScopeConsumer($tq, ScopeType::FILE_SCOPE))
      ->getBuilder()
      ->setPosition(shape('filename' => $file))
      ->build();
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
