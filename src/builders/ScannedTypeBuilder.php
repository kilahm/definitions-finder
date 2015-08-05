<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedTypeBuilder extends ScannedSingleTypeBuilder<ScannedType> {
  public function build(): ScannedType {
    return new ScannedType(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      /* attributes = */ Map { },
      $this->docblock,
    );
  }
}
