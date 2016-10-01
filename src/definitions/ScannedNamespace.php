<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedNamespace extends ScannedBase {
  public function __construct(
    string $name,
    self::TContext $context,
    private ScannedScope $contents,
  ) {
    parent::__construct(
      $name,
      $context,
      /* attributes = */ Map { },
      /* docblock = */ null,
    );
  }

  public static function getType(): ?DefinitionType {
    return null;
  }

  public function getContents(): ScannedScope {
    return $this->contents;
  }
}
