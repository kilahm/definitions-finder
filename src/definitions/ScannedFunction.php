<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedFunction extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::FUNCTION_DEF;
  }
}
