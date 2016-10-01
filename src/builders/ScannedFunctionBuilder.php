<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedFunctionBuilder
  extends ScannedFunctionAbstractBuilder<ScannedFunction> {

  public function build(): ScannedFunction {
    return new ScannedFunction(
      $this->name,
      $this->getDefinitionContext(),
      nullthrows($this->attributes),
      $this->docblock,
      nullthrows($this->generics),
      $this->returnType,
      $this->buildParameters(),
    );
  }
}
