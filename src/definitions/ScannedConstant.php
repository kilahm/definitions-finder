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
