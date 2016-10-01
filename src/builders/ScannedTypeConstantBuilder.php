<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedTypeConstantBuilder extends ScannedSingleTypeBuilder<ScannedTypeConstant> {
  public function __construct(
    string $name,
    self::TContext $context,
    private ?ScannedTypehint $value,
    private AbstractnessToken $abstractness,
  ) {
    parent::__construct($name, $context);
  }

  public function build(): ScannedTypeConstant {
    return new ScannedTypeConstant(
      $this->name,
      $this->getDefinitionContext(),
      $this->docblock,
      $this->value,
      $this->abstractness,
    );
  }
}
