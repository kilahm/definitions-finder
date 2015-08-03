<?hh // strict

namespace FredEmmott\DefinitionFinder;

type SourcePosition = shape(
  'filename' => string,
);

abstract class ScannedBase {
  public function __construct(
    private SourcePosition $position,
    private string $name,
  ) {
  }

  public function getFileName(): string {
    return $this->position['filename'];
  }

  public function getName(): string {
    return $this->name;
  }
}

final class ScannedClass extends ScannedBase {
}
