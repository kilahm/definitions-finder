<?hh // strict

namespace FredEmmott\DefinitionFinder;

/** Represents a parameter, property, constant, or return type hint */
class ScannedTypehint {
  public function __construct(
    private string $typeName,
    private \ConstVector<ScannedTypehint> $generics,
    private bool $nullable,
  ) {
  }

  public function getTypeName(): string {
    return $this->typeName;
  }

  public function isGeneric(): bool {
    return (bool) $this->generics;
  }

  public function isNullable(): bool {
    return $this->nullable;
  }

  public function getGenericTypes(): \ConstVector<ScannedTypehint> {
    return $this->generics;
  }

  public function getTypeText(): string {
    $base = $this->getTypeName();
    invariant(strpbrk($base, '<>') === false, 'generics in type text');
    $generics = $this->getGenericTypes();
    if ($generics) {
      $sub = implode(',',$generics->map($g ==> $g->getTypeText()));
      if ($base === 'tuple') {
        return '('.$sub.')';
      } else {
        return $base.'<'.$sub.'>';
      }
    }
    return $base;
  }
}
