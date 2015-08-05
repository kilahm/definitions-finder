<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedNewtype extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::NEWTYPE_DEF;
  }
}
