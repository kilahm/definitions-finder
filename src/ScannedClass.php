<?hh // strict

namespace FredEmmott\DefinitionFinder;

<<__ConsistentConstruct>>
abstract class ScannedClass extends ScannedBase {

  public function __construct(
    SourcePosition $position,
    string $name,
    Map<string, Vector<mixed>> $attributes,
  ) {
    parent::__construct($position, $name, $attributes);
  }

  public function isInterface(): bool {
    return static::getType() === DefinitionType::INTERFACE_DEF;
  }

  public function isTrait(): bool {
    return static::getType() === DefinitionType::TRAIT_DEF;
  }
}

final class ScannedBasicClass extends ScannedClass {
  public static function getType(): DefinitionType {
    return DefinitionType::CLASS_DEF;
  }
}

final class ScannedInterface extends ScannedClass {
  public static function getType(): DefinitionType {
    return DefinitionType::INTERFACE_DEF;
  }
}

final class ScannedTrait extends ScannedClass {
  public static function getType(): DefinitionType {
    return DefinitionType::TRAIT_DEF;
  }
}

final class ScannedClassBuilder extends ScannedBaseBuilder {

  public function __construct(
    private ClassDefinitionType $type,
    string $name,
  ) {
    parent::__construct($name);
  }

  // Can be safe in 3.9, assuming D2311514 is cherry-picked
  // public function build<T as ScannedClass>(classname<T> $what): T {
  public function build<T as ScannedClass>(string $what): T {
    // UNSAFE
    ClassDefinitionType::assert($what::getType());
    invariant(
      $this->type === $what::getType(),
      "Can't build a %s for a %s",
      $what,
      token_name($this->type),
    );
    return new $what(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      nullthrows($this->attributes),
    );
  }

  public function getType(): ClassDefinitionType {
    return $this->type;
  }
}
