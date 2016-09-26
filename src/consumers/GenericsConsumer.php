<?hh // strict

namespace FredEmmott\DefinitionFinder;

const int T_SUPER = 436;

class GenericsConsumer extends Consumer {
  public function getGenerics(): \ConstVector<ScannedGeneric> {
    $tq = $this->tq;
    list($t, $ttype) = $tq->shift();
    invariant($ttype = T_TYPELIST_LT, 'Consuming generics, but not a typelist');

    $ret = Vector { };

    $name = null;
    $constraint = null;
    $variance = VarianceToken::INVARIANT;
    $relationship = null;

    while ($tq->haveTokens()) {
      list($t, $ttype) = $tq->shift();

      invariant(
        $ttype !== T_TYPELIST_LT,
        "nested generic type",
      );

      if ($ttype === T_WHITESPACE) {
        continue;
      }

      if ($ttype === T_TYPELIST_GT) {
        if ($name !== null) {
          $ret[] = new ScannedGeneric(
            $name,
            $constraint,
            $variance,
            $relationship,
          );
        }
        return $ret;
      }

      if ($t === '-' || $t === '+') {
        $variance = VarianceToken::assert($t);
        continue;
      }

      if ($t === ',') {
        $ret[] = new ScannedGeneric(
          nullthrows($name),
          $this->unaliasName($constraint),
          $variance,
          $relationship,
        );
        $name = null;
        $constraint = null;
        $variance = VarianceToken::INVARIANT;
        $relationship = null;
        continue;
      }

      if ($name === null) {
        invariant(
          $ttype === T_STRING,
          'expected type variable name at line %d',
          $tq->getLine(),
        );
        $name = $t;
        continue;
      }

      if ($ttype === T_AS) {
        $relationship = RelationshipToken::SUBTYPE;
        $this->consumeWhitespace();
        $constraint = (new TypehintConsumer(
          $tq,
          $this->namespace,
          $this->aliases,
        ))->getTypehint()->getTypeText();
        continue;
      }

      if ($ttype === T_SUPER) {
        $relationship = RelationshipToken::SUPERTYPE;
        $this->consumeWhitespace();
        $constraint = (new TypehintConsumer(
          $tq,
          $this->namespace,
          $this->aliases,
        ))->getTypehint()->getTypeText();
        continue;
      }
    }
    invariant_violation('never reached end of generics definition');
  }
}
