<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedEnumBuilder extends ScannedSingleTypeBuilder<ScannedEnum> {
  public function build(): ScannedEnum {
    return new ScannedEnum(
      nullthrows($this->position),
      $this->name,
      /* attributes = */ Map { },
      $this->docblock,
    );
  }
}
