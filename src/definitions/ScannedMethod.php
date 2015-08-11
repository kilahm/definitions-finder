<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedMethod extends ScannedFunctionAbstract {
  public function __construct(
    SourcePosition $position,
    string $name,
    Map<string, Vector<mixed>> $attributes,
    ?string $docComment,
    \ConstVector<ScannedGeneric> $generics,
    ?ScannedTypehint $returnType,
    \ConstVector<ScannedParameter> $parameters,
    private VisibilityToken $visibility,
    private bool $static,
  ) {
    parent::__construct(
      $position,
      $name,
      $attributes,
      $docComment,
      $generics,
      $returnType,
      $parameters,
    );
  }

  public function isPublic(): bool {
    return $this->visibility === T_PUBLIC;
  }

  public function isProtected(): bool {
    return $this->visibility === T_PROTECTED;
  }

  public function isPrivate(): bool {
    return $this->visibility === T_PRIVATE;
  }

  public function isStatic(): bool {
    return $this->static;
  }
}
