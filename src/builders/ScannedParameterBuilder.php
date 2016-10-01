<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedParameterBuilder
  extends ScannedSingleTypeBuilder<ScannedParameter> {
  private ?ScannedTypehint $typehint;
  private ?bool $variadic;
  private ?bool $byref;
  private ?string $defaultString;
  private ?VisibilityToken $visibility;

  public function setTypehint(?ScannedTypehint $typehint): this {
    $this->typehint = $typehint;
    return $this;
  }

  public function setVisibility(?VisibilityToken $visibility): this {
    $this->visibility = $visibility;
    return $this;
  }

  public function setIsVariadic(bool $variadic): this {
    $this->variadic = $variadic;
    return $this;
  }

  public function setIsPassedByReference(bool $byref): this {
    $this->byref = $byref;
    return $this;
  }

  public function setDefaultString(?string $default): this {
    $this->defaultString = $default;
    return $this;
  }

  public function build(): ScannedParameter {
    return new ScannedParameter(
      $this->name,
      $this->getDefinitionContext(),
      nullthrows($this->attributes),
      $this->docblock,
      $this->typehint,
      nullthrows($this->byref),
      nullthrows($this->variadic),
      $this->defaultString,
      $this->visibility,
    );
  }
}
