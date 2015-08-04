<?hh // strict

namespace FredEmmott\DefinitionFinder;

class FunctionConsumer extends Consumer {
  public function getBuilder(): ?ScannedFunctionBuilder {
    $by_ref_return = false;

    $tq = $this->tq;
    list($t, $ttype) = $tq->shift();

    if ($t === '&') {
      $by_ref_return = true;
      $this->consumeWhitespace();
      list($t, $ttype) = $tq->shift();
    }

    if ($t === '(') {
      // rvalue, eg '$x = function() { }'
      $this->consumeStatement();
      return null;
    }

    invariant($ttype === T_STRING, 'Expected function name');
    return (new ScannedFunctionBuilder($t))
      ->setByRefReturn($by_ref_return);
  }
}
