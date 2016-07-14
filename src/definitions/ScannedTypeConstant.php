<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedTypeConstant extends ScannedBase {
  public function __construct(
    SourcePosition $position,
    string $name,
    ?string $docblock,
    private ?ScannedTypehint $value,
    private AbstractnessToken $abstractness,
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

  public function isAbstract(): bool {
    return $this->abstractness === AbstractnessToken::IS_ABSTRACT;
  }

  public function getValue(): ?ScannedTypehint {
    return $this->value;
  }
}
