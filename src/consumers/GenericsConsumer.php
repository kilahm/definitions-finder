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
          $ret[] = new ScannedGeneric($name, $constraint);
        }
        return $ret;
      }

      if ($t === ',') {
        $ret[] = new ScannedGeneric(nullthrows($name), $constraint);
        $name = null;
        $constraint = null;
        continue;
      }

      if ($name === null) {
        invariant($ttype === T_STRING, 'expected type variable name');
        $name = $t;
        continue;
      }

      if ($ttype === T_AS) {
        continue;
      }

      invariant($ttype === T_STRING, 'expected type constraint');
      $constraint = $t;
    }
    invariant_violation('never reached end of generics definition');
  }
}
