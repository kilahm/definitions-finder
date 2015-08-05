<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedInterface extends ScannedClass {
  public static function getType(): DefinitionType {
    return DefinitionType::INTERFACE_DEF;
  }
}
