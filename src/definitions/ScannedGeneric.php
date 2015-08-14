<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ScannedGeneric {
  public function __construct(
    private string $name,
    private ?string $constraint,
    private VarianceToken $variance,
    private ?RelationshipToken $relationship,
  ) {
  }

  public function getName(): string {
    return $this->name;
  }

  public function getConstraintTypeName(): ?string {
    return $this->constraint;
  }

  public function getConstraintRelationship(): ?RelationshipToken {
    return $this->relationship;
  }

  public function isContravariant(): bool {
    return $this->variance === VarianceToken::CONTRAVARIANT;
  }

  public function isInvariant(): bool {
    return $this->variance === VarianceToken::INVARIANT;
  }

  public function isCovariant(): bool {
    return $this->variance === VarianceToken::COVARIANT;
  }
}
