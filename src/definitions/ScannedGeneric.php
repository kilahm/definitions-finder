<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedGeneric {
  public function __construct(
    private string $name,
    private ?string $constraint,
  ) {
  }

  public function getName(): string {
    return $this->name;
  }

  public function getConstraint(): ?string {
    return $this->constraint;
  }
}
