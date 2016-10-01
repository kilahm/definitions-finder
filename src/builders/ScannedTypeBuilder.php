<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedTypeBuilder extends ScannedSingleTypeBuilder<ScannedType> {
  public function build(): ScannedType {
    return new ScannedType(
      $this->name,
      $this->getDefinitionContext(),
      /* attributes = */ Map { },
      $this->docblock,
    );
  }
}
