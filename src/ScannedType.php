<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedType extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::TYPE_DEF;
  }
}

class ScannedTypeBuilder extends ScannedSingleTypeBuilder<ScannedType> {
  public function build(): ScannedType {
    return new ScannedType(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      /* attributes = */ Map { },
    );
  }
}
