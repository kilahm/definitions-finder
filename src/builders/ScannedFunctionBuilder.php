<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedFunctionBuilder
  extends ScannedSingleTypeBuilder<ScannedFunction> {

  private ?bool $byRefReturn;
  private ?\ConstVector<ScannedGeneric> $generics = null;
  private ?ScannedTypehint $returnType;
  private ?\ConstVector<ScannedParameter> $parameters = null;

  public function setByRefReturn(bool $v): this {
    $this->byRefReturn = $v;
    return $this;
  }

  public function setGenerics(\ConstVector<ScannedGeneric> $generics): this {
    $this->generics = $generics;
    return $this;
  }

  public function setReturnType(?ScannedTypehint $type): this {
    $this->returnType = $type;
    return $this;
  }

  public function setParameters(
    \ConstVector<ScannedParameter> $parameters,
  ): this {
    $this->parameters = $parameters;
    return $this;
  }

  public function build(): ScannedFunction {
    return new ScannedFunction(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      nullthrows($this->attributes),
      $this->docblock,
      nullthrows($this->generics),
      $this->returnType,
      nullthrows($this->parameters),
    );
  }
}
