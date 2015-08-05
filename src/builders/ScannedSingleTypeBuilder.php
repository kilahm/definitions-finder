<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedSingleTypeBuilder<T> extends ScannedBaseBuilder {
  abstract public function build(): T;
}
