<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedTypeConstantBuilder extends ScannedSingleTypeBuilder<ScannedTypeConstant> {
  public function __construct(
    string $name,
    private ?ScannedTypehint $value,
    private bool $isAbstract,
  ) {
    parent::__construct($name);
  }

  public function build(): ScannedTypeConstant {
    return new ScannedTypeConstant(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      $this->docblock,
      $this->value,
      $this->isAbstract,
    );
  }
}
