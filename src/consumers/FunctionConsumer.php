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
    $name = $t;
 
    list($_, $ttype) = $tq->peek();
    $generics = null;
    if ($ttype === T_TYPELIST_LT) {
      $generics = $this->consumeType();
    }
    $params = $this->consumeParameterList();

    return (new ScannedFunctionBuilder($name))
      ->setByRefReturn($by_ref_return);
  }

  private function consumeParameterList(): \ConstVector<(?string, string)> {
    $tq = $this->tq;
    list($t, $ttype) = $tq->shift();
    invariant($t === '(', 'expected parameter list, got %s', $t);

    $params = Vector { };
    $param_type = null;
    while (true) {
      list($t, $ttype) = $tq->shift();

      if ($t === ')') {
        break;
      }

      if ($ttype === T_VARIABLE) {
        $params[] = tuple($param_type, $t);
        $param_type = null;
        continue;
      }

      if ($ttype === T_WHITESPACE || $t === ',') {
        continue;
      }
      
      invariant(
        $param_type === null,
        'found two things that look like typehints for the same parameter',
      );
      $tq->unshift($t, $ttype);
      $param_type = $this->consumeType();
    }
    return $params;
  }

  private function consumeType(): string {
    $type = '';
    $nesting = 0;
    while (true) {
      list($t, $ttype) = $this->tq->shift();

      if ($ttype === T_WHITESPACE) {
        if ($nesting === 0) {
          break;
        }
        continue;
      }

      $type .= $t;
      if ($t === '{' || $ttype === T_TYPELIST_LT || $t === '(') {
        ++$nesting;
      }
      if ($t === '}' || $ttype === T_TYPELIST_GT || $t === ')') {
        --$nesting;
        if ($nesting === 0) {
          break;
        }
      }
    }
    return $type;
  }
}
