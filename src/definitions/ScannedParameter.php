<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedParameter {
  public function __construct(
    private string $name,
    private ?ScannedTypehint $type,
    private bool $byref,
    private bool $variadic,
  ) {
    if ($variadic) {
      invariant($type === null, 'variadics must be untyped');
    }
  }

  public function getName(): string {
    return $this->name;
  }

  public function getTypehint(): ?ScannedTypehint {
    return $this->type;
  }

  public function isPassedByReference(): bool {
    return $this->byref;
  }

  public function isVariadic(): bool {
    return $this->variadic;
  }
}
