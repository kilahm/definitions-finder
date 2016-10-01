<?hh // strict

namespace FredEmmott\DefinitionFinder;

class FunctionConsumer extends FunctionAbstractConsumer<ScannedFunction> {
  <<__Override>>
  protected function constructBuilder(
    string $name,
  ): ScannedFunctionBuilder {
    return new ScannedFunctionBuilder(
      $this->normalizeName($name),
      $this->getBuilderContext(),
    );
  }
}
