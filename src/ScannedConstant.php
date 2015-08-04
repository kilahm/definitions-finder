<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedConstant extends ScannedBase {
  public function __construct(
    SourcePosition $position,
    string $name,
    private mixed $value,
  ) {
    parent::__construct(
      $position,
      $name,
      /* attributes = */ Map { },
    );
  }

  public static function getType(): DefinitionType {
    return DefinitionType::CONST_DEF;
  }

  public function getValue(): mixed {
    return $this->value;
  }
}

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
