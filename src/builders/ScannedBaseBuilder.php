<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedBaseBuilder {
  protected ?SourcePosition $position;
  protected ?Map<string, Vector<mixed>> $attributes;
  protected ?string $docblock;

  public function __construct(protected string $name) {
  }

  public function setPosition(SourcePosition $pos): this {
    $this->position = $pos;
    return $this;
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
}
