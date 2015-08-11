<?hh // strict

namespace FredEmmott\DefinitionFinder;

class MethodConsumer extends FunctionAbstractConsumer<ScannedMethod> {
  protected static function ConstructBuilder(
    string $name,
  ): ScannedMethodBuilder {
    return new ScannedMethodBuilder($name);
  }
}
