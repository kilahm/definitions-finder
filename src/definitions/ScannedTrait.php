<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedTrait extends ScannedClass {
  public static function getType(): DefinitionType {
    return DefinitionType::TRAIT_DEF;
  }
}
