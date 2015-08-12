<?hh // strict

namespace FredEmmott\DefinitionFinder;

<<__ConsistentConstruct>>
abstract class ScannedClass extends ScannedBase {

  public function __construct(
    SourcePosition $position,
    string $name,
    Map<string, Vector<mixed>> $attributes,
    ?string $docblock,
    private \ConstVector<ScannedMethod> $methods,
    private \ConstVector<ScannedProperty> $properties,
    private \ConstVector<ScannedConstant> $constants,
  ) {
    parent::__construct($position, $name, $attributes, $docblock);
  }

  public function isInterface(): bool {
    return static::getType() === DefinitionType::INTERFACE_DEF;
  }

  public function isTrait(): bool {
    return static::getType() === DefinitionType::TRAIT_DEF;
  }

  public function getMethods(): \ConstVector<ScannedMethod> {
    return $this->methods;
  }

  public function getProperties(): \ConstVector<ScannedProperty> {
    return $this->properties;
  }

  public function getConstants(): \ConstVector<ScannedConstant> {
    return $this->constants;
  }
}
