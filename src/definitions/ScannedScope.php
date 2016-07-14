<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedScope extends ScannedBase {

  public function __construct(
    private SourcePosition $position,
    private \ConstVector<ScannedBasicClass> $classes,
    private \ConstVector<ScannedInterface> $interfaces,
    private \ConstVector<ScannedTrait> $traits,
    private \ConstVector<ScannedFunction> $functions,
    private \ConstVector<ScannedMethod> $methods,
    private \ConstVector<ScannedProperty> $properties,
    private \ConstVector<ScannedConstant> $constants,
    private \ConstVector<ScannedTypeConstant> $typeConstants,
    private \ConstVector<ScannedEnum> $enums,
    private \ConstVector<ScannedType> $types,
    private \ConstVector<ScannedNewtype> $newtypes,
  ) {
    parent::__construct(
      $position,
      '__SCOPE__',
      /* attributes = */ Map { },
      /* docblock = */ null,
    );
  }

  public static function getType(): ?DefinitionType {
    return null;
  }

  public function getClasses(): \ConstVector<ScannedBasicClass> {
    return $this->classes;
  }

  public function getInterfaces(): \ConstVector<ScannedInterface> {
    return $this->interfaces;
  }

  public function getTraits(): \ConstVector<ScannedTrait> {
    return $this->traits;
  }

  public function getFunctions(): \ConstVector<ScannedFunction> {
    return $this->functions;
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

  public function getTypeConstants(): \ConstVector<ScannedTypeConstant> {
    return $this->typeConstants;
  }

  public function getEnums(): \ConstVector<ScannedEnum> {
    return $this->enums;
  }

  public function getTypes(): \ConstVector<ScannedType> {
    return $this->types;
  }

  public function getNewtypes(): \ConstVector<ScannedNewtype> {
    return $this->newtypes;
  }
}
