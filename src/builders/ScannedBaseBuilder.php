<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedBaseBuilder {
  protected ?string $namespace;
  protected ?SourcePosition $position;
  protected ?Map<string, Vector<mixed>> $attributes;
  protected ?string $docblock;

  public function __construct(protected string $name) {
  }

  public function setNamespace(string $name): this {
    $this->namespace = $name;
    return $this;
  }

  public function prefixNamespace(string $name): this {
    $this->namespace = $name.nullthrows($this->namespace);
    return $this;
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
