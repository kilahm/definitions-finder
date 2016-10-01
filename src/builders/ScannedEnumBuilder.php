<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedEnumBuilder extends ScannedSingleTypeBuilder<ScannedEnum> {
  public function build(): ScannedEnum {
    return new ScannedEnum(
      $this->name,
      $this->getDefinitionContext(),
      /* attributes = */ Map { },
      $this->docblock,
    );
  }
}
