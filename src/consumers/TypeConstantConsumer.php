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
    \ConstMap<string, string> $aliases,
    private bool $isAbstract,
  ) {
    parent::__construct($tq, $aliases);
  }

  public function getBuilder(): ScannedTypeConstantBuilder {
    $this->checkForTypeToken();
    return new ScannedTypeConstantBuilder(
      $this->extractName(),
      $this->extractValue(),
      $this->isAbstract,
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

  private function extractName(): string {
    $this->consumeWhitespace();
    list($next, $next_type) = $this->tq->shift();
    invariant(
      StringishTokens::isValid($next_type),
      'invalid type constant name %s',
      $next,
    );
    return $next;
  }

  private function extractValue(): ?ScannedTypehint {
    $this->consumeWhitespace();

    $expectValue = false;

    list($next, $next_type) = $this->tq->peek();
    if($next === RelationshipToken::SUBTYPE) {
      invariant(
        $this->isAbstract,
        'concrete type constant may not have a type constraint',
      );
      $this->tq->shift();
      $this->consumeWhitespace();
      return (new TypehintConsumer($this->tq, $this->aliases))->getTypehint();
    }

    if($next === '=') {
      invariant(!$this->isAbstract, 'abstract type constants may not have concrete values');
      $this->tq->shift();
      $this->consumeWhitespace();
      return (new TypehintConsumer($this->tq, $this->aliases))->getTypehint();
    }

      $this->consumeStatement();
      return null;
  }
}
