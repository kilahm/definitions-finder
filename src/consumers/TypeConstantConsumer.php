<?hh // strict

namespace FredEmmott\DefinitionFinder;

/** Deals with type constants.
 *
 * abstract const type CONST_NAME [as ...];
 * const type CONST_NAME = type_name;
 *
 * expects the next token in the queue to be DefinitionType::TYPE_DEF
 */
final class TypeConstantConsumer extends Consumer {

  public function __construct(
    TokenQueue $tq,
    self::TContext $context,
    private AbstractnessToken $abstractness,
  ) {
    parent::__construct($tq, $context);
  }

  public function getBuilder(): ScannedTypeConstantBuilder {
    $this->checkForTypeToken();
    return new ScannedTypeConstantBuilder(
      $this->consumeName(),
      $this->getBuilderContext(),
      $this->consumeValue(),
      $this->abstractness,
    );
  }

  private function checkForTypeToken(): void {
    $this->consumeWhitespace();
    list($next, $next_token) = $this->tq->shift();
    invariant(
      $next_token === DefinitionType::TYPE_DEF,
      'misidentified type constant.',
   );
  }

  private function consumeName(): string {
    $this->consumeWhitespace();
    list($next, $next_type) = $this->tq->shift();
    invariant(
      StringishTokens::isValid($next_type),
      'invalid type constant name %s',
      $next,
    );
    return $next;
  }

  private function consumeValue(): ?ScannedTypehint {
    $this->consumeWhitespace();

    $expectValue = false;

    list($next, $next_type) = $this->tq->peek();
    if($next === RelationshipToken::SUBTYPE) {
      invariant(
        $this->abstractness === AbstractnessToken::IS_ABSTRACT,
        'concrete type constant may not have a type constraint',
      );
      $this->tq->shift();
      $this->consumeWhitespace();
      return (new TypehintConsumer(
        $this->tq,
        $this->context,
      ))->getTypehint();
    }

    if($next === '=') {
      invariant(
        $this->abstractness === AbstractnessToken::NOT_ABSTRACT,
        'abstract type constants may not have concrete values',
      );
      $this->tq->shift();
      $this->consumeWhitespace();
      return (new TypehintConsumer(
        $this->tq,
        $this->context,
      ))->getTypehint();
    }

      $this->consumeStatement();
      return null;
  }
}
