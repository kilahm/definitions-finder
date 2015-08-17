<?hh // strict

namespace FredEmmott\DefinitionFinder;

<<__ConsistentConstruct>>
abstract class ScannedClass
  extends ScannedBase
  implements HasScannedGenerics {

  public function __construct(
    SourcePosition $position,
    string $name,
    Map<string, Vector<mixed>> $attributes,
    ?string $docblock,
    private \ConstVector<ScannedMethod> $methods,
    private \ConstVector<ScannedProperty> $properties,
    private \ConstVector<ScannedConstant> $constants,
    private \ConstVector<ScannedGeneric> $generics,
    private ?ScannedTypehint $parent,
    private \ConstVector<ScannedTypehint> $interfaces,
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

  public function getGenericTypes(): \ConstVector<ScannedGeneric> {
    return $this->generics;
  }

  public function getInterfaceNames(): \ConstVector<string> {
    return $this->interfaces->map($x ==> $x->getTypeName());
  }

  public function getParentClassName(): ?string {
    return $this->parent?->getTypeName();
  }

  public function getParentClassInfo(): ?ScannedTypehint {
    return $this->parent;
  }

  public function getInterfaceInfo(): \ConstVector<ScannedTypehint> {
    return $this->interfaces;
  }
}
