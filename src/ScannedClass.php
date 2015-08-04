<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedClass extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::CLASS_DEF;
  }
}

final class ScannedInterface extends ScannedBase {
  public static function getType(): DefinitionType {
    return DefinitionType::INTERFACE_DEF;
  }
}

final class ScannedTrait extends ScannedBase {
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
  //public function build<T as ScannedBase>(classname<T> $what): T {
  public function build<T as ScannedBase>(string $what): T {
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
}
