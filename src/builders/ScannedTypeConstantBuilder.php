<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedTypeConstantBuilder extends ScannedSingleTypeBuilder<ScannedTypeConstant> {
  public function __construct(
    string $name,
    private ?ScannedTypehint $value,
    private AbstractnessToken $abstractness,
  ) {
    parent::__construct($name);
  }

  public function build(): ScannedTypeConstant {
    return new ScannedTypeConstant(
      nullthrows($this->position),
      $this->name,
      $this->docblock,
      $this->value,
      $this->abstractness,
    );
  }
}
