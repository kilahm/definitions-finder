<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedFunctionBuilder
  extends ScannedFunctionAbstractBuilder<ScannedFunction> {

  public function build(): ScannedFunction {
    return new ScannedFunction(
      nullthrows($this->position),
      $this->name,
      nullthrows($this->attributes),
      $this->docblock,
      nullthrows($this->generics),
      $this->returnType,
      $this->buildParameters(),
    );
  }
}
