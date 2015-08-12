<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedConstant extends ScannedBase {
  public function __construct(
    SourcePosition $position,
    string $name,
    ?string $docblock,
    private mixed $value,
    private ?ScannedTypehint $typehint,
  ) {
    parent::__construct(
      $position,
      $name,
      /* attributes = */ Map { },
      $docblock,
    );
  }

  public static function getType(): DefinitionType {
    return DefinitionType::CONST_DEF;
  }

  public function getValue(): mixed {
    return $this->value;
  }

  public function getTypehint(): ?ScannedTypehint {
    return $this->typehint;
  }
}
