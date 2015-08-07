<?hh // strict

namespace FredEmmott\DefinitionFinder;

/** Represents a parameter, property, constant, or return type hint */
class ScannedTypehint {
  public function __construct(
    private string $typehint,
    private ?\ConstVector<ScannedTypehint> $generics,
  ) {
  }

  public function getTypehint(): string {
    return $this->typehint;
  }

  public function isGeneric(): bool {
    return $this->generics !== null;
  }

  public function getGenerics(): ?\ConstVector<ScannedTypehint> {
    return $this->generics;
  }
}
