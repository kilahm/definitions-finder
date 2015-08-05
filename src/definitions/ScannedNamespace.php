<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedNamespace extends ScannedBase {
  public function __construct(
    SourcePosition $position,
    string $name,
    private ScannedScope $contents,
  ) {
    parent::__construct($position, $name, /* attributes = */ Map { });
  }

  public static function getType(): ?DefinitionType {
    return null;
  }

  public function getContents(): ScannedScope {
    return $this->contents;
  }
}
