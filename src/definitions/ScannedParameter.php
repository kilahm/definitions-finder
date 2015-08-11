<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedParameter {
  public function __construct(
    private string $name,
    private ?ScannedTypehint $type,
    private bool $byref,
  ) {
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
}
