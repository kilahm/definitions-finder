<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedNamespaceBuilder
extends ScannedSingleTypeBuilder<ScannedNamespace> {
  private ?ScannedScopeBuilder $scopeBuilder;

  public function setContents(ScannedScopeBuilder $scope): this {
    invariant($this->scopeBuilder === null, 'namespace already has a scope');
    $this->scopeBuilder = $scope;
    return $this;
  }

  public function build(): ScannedNamespace {
    $scope = nullthrows($this->scopeBuilder)->build();
    return new ScannedNamespace(
      nullthrows($this->name),
      $this->getDefinitionContext(),
      $scope,
    );
  }
}
