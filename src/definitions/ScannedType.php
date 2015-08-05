<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedType extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::TYPE_DEF;
  }
}
