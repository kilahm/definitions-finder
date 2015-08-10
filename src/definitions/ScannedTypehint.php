<?hh // strict

namespace FredEmmott\DefinitionFinder;

/** Represents a parameter, property, constant, or return type hint */
class ScannedTypehint {
  public function __construct(
    private string $typeName,
    private \ConstVector<ScannedTypehint> $generics,
  ) {
  }

  public function getTypeName(): string {
    return $this->typeName;
  }

  public function isGeneric(): bool {
    return (bool) $this->generics;
  }

  public function getGenerics(): \ConstVector<ScannedTypehint> {
    return $this->generics;
  }
}
