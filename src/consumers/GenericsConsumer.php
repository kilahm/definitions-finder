<?hh // strict

namespace FredEmmott\DefinitionFinder;

class GenericsConsumer extends Consumer {
  public function getGenerics(): \ConstVector<ScannedGeneric> {
    $tq = $this->tq;
    list($t, $ttype) = $tq->shift();
    invariant($ttype = T_TYPELIST_LT, 'Consuming generics, but not a typelist');

    $ret = Vector { };

    $name = null;
    $constraint = null;
    $variance = VarianceToken::INVARIANT;

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
          $ret[] = new ScannedGeneric($name, $constraint, $variance);
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
          $constraint,
          $variance,
        );
        $name = null;
        $constraint = null;
        $variance = VarianceToken::INVARIANT;
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
        continue;
      }

      invariant(
        $ttype === T_STRING,
        'expected type constraint at line %d',
        $tq->getLine(),
      );
      $constraint = $t;
    }
    invariant_violation('never reached end of generics definition');
  }
}
