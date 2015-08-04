<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedEnum extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::ENUM_DEF;
  }
}

class ScannedEnumBuilder extends ScannedSingleTypeBuilder<ScannedEnum> {
  public function build(): ScannedEnum {
    return new ScannedEnum(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      /* attributes = */ Map { },
    );
  }
}
