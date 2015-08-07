<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class ScannedFunctionAbstract extends ScannedBase {
  public function __construct(
    SourcePosition $position,
    string $name,
    Map<string, Vector<mixed>> $attributes,
    ?string $docComment,
    private \ConstVector<ScannedGeneric> $generics,
    private ?ScannedTypehint $returnType,
  ) {
    parent::__construct($position, $name, $attributes, $docComment);
  }

  public static function getType(): DefinitionType {
    return DefinitionType::FUNCTION_DEF;
  }

  public function getGenerics(): \ConstVector<ScannedGeneric> {
    return $this->generics;
  }

  public function getReturnType(): ?ScannedTypehint {
    return $this->returnType;
  }
}
