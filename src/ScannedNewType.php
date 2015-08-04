<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedNewtype extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::NEWTYPE_DEF;
  }
}

class ScannedNewtypeBuilder extends ScannedSingleTypeBuilder<ScannedNewtype> {
  public function build(): ScannedNewtype {
    return new ScannedNewtype(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      /* attributes = */ Map { },
    );
  }
}
