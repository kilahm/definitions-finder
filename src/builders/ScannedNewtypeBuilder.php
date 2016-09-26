<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedNewtypeBuilder extends ScannedSingleTypeBuilder<ScannedNewtype> {
  public function build(): ScannedNewtype {
    return new ScannedNewtype(
      nullthrows($this->position),
      $this->name,
      /* attributes = */ Map { },
      $this->docblock,
    );
  }
}
