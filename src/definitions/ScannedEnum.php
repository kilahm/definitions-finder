<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedEnum extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::ENUM_DEF;
  }
}
