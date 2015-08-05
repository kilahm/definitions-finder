<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedBase {
  public function __construct(
    private SourcePosition $position,
    private string $name,
    private Map<string, Vector<mixed>> $attributes,
    private ?string $docComment,
  ) {
  }

  abstract public static function getType(): ?DefinitionType;

  public function getPosition(): SourcePosition {
    return $this->position;
  }

  public function getDocComment(): ?string {
    return $this->docComment;
  }

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
