<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedFunction extends ScannedBase {
}

final class ScannedFunctionBuilder {
  private ?string $namespace;
  private ?bool $byRefReturn;
  private ?SourcePosition $position;
  private ?Map<string, Vector<mixed>> $attributes;

  public function __construct(private string $name) {
  }

  public function setNamespace(string $name): this {
    $this->namespace = $name;
    return $this;
  }

  public function setPosition(SourcePosition $pos): this {
    $this->position = $pos;
    return $this;
  }

  public function setByRefReturn(bool $v): this {
    $this->byRefReturn = $v;
    return $this;
  }

  public function build(): ScannedFunction {
    return new ScannedFunction(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      nullthrows($this->attributes),
    );
  }

  public function setAttributes(
    Map<string, Vector<mixed>> $v
  ): this {
    $this->attributes = $v;
    return $this;
  }
}
