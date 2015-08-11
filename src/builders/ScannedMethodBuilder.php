<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedMethodBuilder
  extends ScannedFunctionAbstractBuilder<ScannedMethod> {

  protected ?VisibilityToken $visibility;

  public function build(): ScannedMethod{
    return new ScannedMethod(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      nullthrows($this->attributes),
      $this->docblock,
      nullthrows($this->generics),
      $this->returnType,
      nullthrows($this->parameters),
      nullthrows($this->visibility),
    );
  }
  
  public function setVisibility(VisibilityToken $visibility): this {
    $this->visibility = $visibility;
    return $this;
  }
}
