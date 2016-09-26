<?hh // strict

namespace FredEmmott\DefinitionFinder;

class MethodConsumer extends FunctionAbstractConsumer<ScannedMethod> {
  <<__Override>>
  protected function constructBuilder(
    string $name,
  ): ScannedMethodBuilder {
    return new ScannedMethodBuilder($name);
  }
}
