<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedBasicClass extends ScannedClass {
  public static function getType(): DefinitionType {
    return DefinitionType::CLASS_DEF;
  }
}
