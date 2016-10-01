<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedNewtypeBuilder extends ScannedSingleTypeBuilder<ScannedNewtype> {
  public function build(): ScannedNewtype {
    return new ScannedNewtype(
      $this->name,
      $this->getDefinitionContext(),
      /* attributes = */ Map { },
      $this->docblock,
    );
  }
}
