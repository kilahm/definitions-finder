<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedFunctionAbstractBuilder<T as ScannedFunctionAbstract>
  extends ScannedSingleTypeBuilder<T> {

  protected ?bool $byRefReturn;
  protected ?\ConstVector<ScannedGeneric> $generics = null;
  protected ?ScannedTypehint $returnType;
  protected ?\ConstVector<ScannedParameter> $parameters = null;

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
}
