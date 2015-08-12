<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedParameter {
  public function __construct(
    private string $name,
    private ?ScannedTypehint $type,
    private bool $byref,
    private bool $variadic,
    private ?string $defaultString,
    private ?VisibilityToken $visibility,
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

  public function isOptional(): bool {
    return $this->defaultString !== null;
  }

  public function getDefaultString(): string {
    invariant(
      $this->isOptional(),
      'trying to retrieve default for non-optional param',
    );
    return nullthrows($this->defaultString);
  }

  public function __isPromoted(): bool {
    return $this->visibility !== null;
  }

  public function __getVisibility(): VisibilityToken {
    $v = $this->visibility;
    invariant(
      $v !== null,
      'Tried to get visibility for a non-promoted parameter',
    );
    return $v;
  }
}
