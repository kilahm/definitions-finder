<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedParameter extends ScannedBase {
  public function __construct(
    SourcePosition $position,
    string $name,
    Map<string, Vector<mixed>> $attributes,
    ?string $docComment,
    private ?ScannedTypehint $type,
    private bool $byref,
    private bool $variadic,
    private ?string $defaultString,
    private ?VisibilityToken $visibility,
  ) {
    parent::__construct($position, $name, $attributes, $docComment);
    if ($variadic) {
      invariant($type === null, 'variadics must be untyped');
    }
  }

  public static function getType(): ?DefinitionType {
    return null;
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
