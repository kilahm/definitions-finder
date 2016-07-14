<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedScopeBuilder extends ScannedSingleTypeBuilder<ScannedScope> {
  public function __construct() {
    parent::__construct('__SCOPE__');
  }

  private Vector<ScannedClassBuilder> $classBuilders = Vector { };
  private Vector<ScannedFunctionBuilder> $functionBuilders = Vector { };
  private Vector<ScannedMethodBuilder> $methodBuilders = Vector { };
  private Vector<ScannedPropertyBuilder> $propertyBuilders = Vector { };
  private Vector<ScannedConstantBuilder> $constantBuilders = Vector { };
  private Vector<ScannedTypeConstantBuilder> $typeConstantBuilders = Vector { };
  private Vector<ScannedEnumBuilder> $enumBuilders = Vector { };
  private Vector<ScannedTypeBuilder> $typeBuilders = Vector { };
  private Vector<ScannedNewtypeBuilder> $newtypeBuilders = Vector { };

  private Vector<ScannedNamespaceBuilder> $namespaceBuilders = Vector { };
  private Vector<ScannedScope> $subscopes = Vector { };

  public function addProperty(ScannedPropertyBuilder $b): void {
    $this->propertyBuilders[] = $b;
  }

  public function addClass(ScannedClassBuilder $b): void {
    $this->classBuilders[] = $b;
  }

  public function addFunction(ScannedFunctionBuilder $b): void {
    $this->functionBuilders[] = $b;
  }

  public function addMethod(ScannedMethodBuilder $b): void {
    $this->methodBuilders[] = $b;
  }

  public function addConstant(ScannedConstantBuilder $b): void {
    $this->constantBuilders[] = $b;
  }

  public function addTypeConstant(ScannedTypeConstantBuilder $b): void {
    $this->typeConstantBuilders[] = $b;
  }

  public function addEnum(ScannedEnumBuilder $b): void {
    $this->enumBuilders[] = $b;
  }

  public function addType(ScannedTypeBuilder $b): void {
    $this->typeBuilders[] = $b;
  }

  public function addNewtype(ScannedNewtypeBuilder $b): void {
    $this->newtypeBuilders[] = $b;
  }

  public function addNamespace(ScannedNamespaceBuilder $b): void {
    $this->namespaceBuilders[] = $b;
  }

  public function addSubScope(ScannedScope $s): void {
    $this->subscopes[] = $s;
  }

  public function build(): ScannedScope {
    $ns = nullthrows($this->namespace);
    $pos = nullthrows($this->position);

    $classes = Vector { };
    $interfaces= Vector { };
    $traits = Vector { };
    foreach ($this->classBuilders as $b) {
      $b->setPosition($pos)->setNamespace($ns);
      switch ($b->getType()) {
        case ClassDefinitionType::CLASS_DEF:
          $classes[] = $b->build(ScannedBasicClass::class);
          break;
        case ClassDefinitionType::INTERFACE_DEF:
          $interfaces[] = $b->build(ScannedInterface::class);
          break;
        case ClassDefinitionType::TRAIT_DEF:
          $traits[] = $b->build(ScannedTrait::class);
          break;
      }
    }

    $functions = $this->buildAll($this->functionBuilders);
    $methods = $this->buildAll($this->methodBuilders);
    $properties = $this->buildAll($this->propertyBuilders);
    $constants = $this->buildAll($this->constantBuilders);
    $typeConstants = $this->buildAll($this->typeConstantBuilders);
    $enums = $this->buildAll($this->enumBuilders);
    $types = $this->buildAll($this->typeBuilders);
    $newtypes = $this->buildAll($this->newtypeBuilders);

    $namespaces = $this->buildAll($this->namespaceBuilders);
    $scopes = $namespaces->map($ns ==> $ns->getContents());
    $scopes->addAll($this->subscopes);
    foreach ($scopes as $scope) {
      $classes->addAll($scope->getClasses());
      $interfaces->addAll($scope->getInterfaces());
      $traits->addAll($scope->getTraits());
      $functions->addAll($scope->getFunctions());
      $methods->addAll($scope->getMethods());
      $properties->addAll($scope->getProperties());
      $constants->addAll($scope->getConstants());
      $typeConstants->addAll($scope->getTypeConstants());
      $enums->addAll($scope->getEnums());
      $types->addAll($scope->getTypes());
      $newtypes->addAll($scope->getNewtypes());
    }

    return new ScannedScope(
      nullthrows($this->position),
      $classes,
      $interfaces,
      $traits,
      $functions,
      $methods,
      $properties,
      $constants,
      $typeConstants,
      $enums,
      $types,
      $newtypes,
    );
  }

  private function buildAll<T>(
    \ConstVector<ScannedSingleTypeBuilder<T>> $v,
  ): Vector<T> {
    return $v->map($b ==> $b
      ->setPosition(nullthrows($this->position))
      ->setNamespace(nullthrows($this->namespace))
      ->build()
    )->toVector();
  }

  public function getNamespace(): string {
    return nullthrows($this->namespace);
  }
}
