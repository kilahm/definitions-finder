<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedFunctionAbstract extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::FUNCTION_DEF;
  }
}
