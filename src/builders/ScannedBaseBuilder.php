<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedBaseBuilder {
  const type TContext = ScannedBase::TContext;

  protected ?Map<string, Vector<mixed>> $attributes;
  protected ?string $docblock;


  public function __construct(
    protected string $name,
    protected self::TContext $context,
  ) {
  }

  public function setDocComment(?string $docblock): this {
    $this->docblock = $docblock;
    return $this;
  }

  public function setAttributes(
    Map<string, Vector<mixed>> $v
  ): this {
    $this->attributes = $v;
    return $this;
  }

  protected function getDefinitionContext(): ScannedBase::TContext {
    $context = $this->context;
    $context['sourceType'] = nullthrows(Shapes::idx($context, 'sourceType'));
    return $context;
  }
}
