<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedConstant extends ScannedBase {
  public function __construct(
    string $name,
    self::TContext $context,
    ?string $docblock,
    private mixed $value,
    private ?ScannedTypehint $typehint,
  ) {
    parent::__construct(
      $name,
      $context,
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
