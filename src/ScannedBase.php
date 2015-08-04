<?hh // strict

namespace FredEmmott\DefinitionFinder;

type SourcePosition = shape(
  'filename' => string,
);

abstract class ScannedBase {
  public function __construct(
    private SourcePosition $position,
    private string $name,
    private Map<string, Vector<mixed>> $attributes,
  ) {
  }

  abstract public static function getType(): DefinitionType;

  public function getFileName(): string {
    return $this->position['filename'];
  }

  public function getName(): string {
    return $this->name;
  }

  public function getAttributes(): Map<string, Vector<mixed>> {
    return $this->attributes;
  }
}

abstract class ScannedBaseBuilder {
  protected ?string $namespace;
  protected ?SourcePosition $position;
  protected ?Map<string, Vector<mixed>> $attributes;

  public function __construct(protected string $name) {
  }

  public function setNamespace(string $name): this {
    $this->namespace = $name;
    return $this;
  }

  public function setPosition(SourcePosition $pos): this {
    $this->position = $pos;
    return $this;
  }

  public function setAttributes(
    Map<string, Vector<mixed>> $v
  ): this {
    $this->attributes = $v;
    return $this;
  }
}
