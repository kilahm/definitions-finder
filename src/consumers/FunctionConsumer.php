<?hh // strict

namespace FredEmmott\DefinitionFinder;

class FunctionConsumer extends FunctionAbstractConsumer<ScannedFunction> {
  protected static function ConstructBuilder(
    string $name,
  ): ScannedFunctionBuilder {
    return new ScannedFunctionBuilder($name);
  }
}
