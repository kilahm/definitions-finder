<?hh // strict
namespace FredEmmott\DefinitionFinder;

abstract class ScannedFunctionAbstract
  extends ScannedBase
  implements HasScannedGenerics {
  public function __construct(
    string $name,
    self::TContext $context,
    Map<string, Vector<mixed>> $attributes,
    ?string $docComment,
    private \ConstVector<ScannedGeneric> $generics,
    private ?ScannedTypehint $returnType,
    private \ConstVector<ScannedParameter> $parameters,
  ) {
    parent::__construct(
      $name,
      $context,
      $attributes,
      $docComment,
    );
  }

  public static function getType(): DefinitionType {
    return DefinitionType::FUNCTION_DEF;
  }

  public function getGenericTypes(): \ConstVector<ScannedGeneric> {
    return $this->generics;
  }

  public function getReturnType(): ?ScannedTypehint {
    return $this->returnType;
  }

  public function getParameters(): \ConstVector<ScannedParameter> {
    return $this->parameters;
  }
}
