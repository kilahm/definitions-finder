<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedConstantBuilder extends ScannedSingleTypeBuilder<ScannedConstant> {
  public function __construct(
    string $name,
    private mixed $value,
  ) {
    parent::__construct($name);
  }

  public function build(): ScannedConstant {
    return new ScannedConstant(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      $this->value,
    );
  }
}
