<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedPropertyBuilder extends ScannedSingleTypeBuilder<ScannedProperty> {
  private ?ScannedTypehint $typehint;
  private ?VisibilityToken $visibility;
  private ?bool $isStatic;

  public function setVisibility(VisibilityToken $visibility): this {
    $this->visibility = $visibility;
    return $this;
  }

  public function setTypehint(?ScannedTypehint $typehint): this {
    $this->typehint = $typehint;
    return $this;
  }

  public function setIsStatic(bool $static): this {
    $this->isStatic = $static;
    return $this;
  }

  public function build(): ScannedProperty {
    return new ScannedProperty(
      nullthrows($this->position),
      $this->name,
      nullthrows($this->attributes),
      $this->docblock,
      $this->typehint,
      nullthrows($this->visibility),
      nullthrows($this->isStatic),
    );
  }
}
