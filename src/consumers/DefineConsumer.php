<?hh // strict

namespace FredEmmott\DefinitionFinder;

/** Deals with old-style constants.
 *
 * define('CONST_NAME', ...)
 * define("CONST_NAME", ...)
 * define(CONST_NAME, ...)
 *
 * See ConstantConsumer for new-style constants.
 */
final class DefineConsumer extends Consumer {
  public function getBuilder(): ScannedConstantBuilder {
    $tq = $this->tq;
    $value = null;

    $this->consumeWhitespace();
    list($next, $_) = $tq->shift();
    invariant(
      $next === '(',
      'Expected define to be followed by a paren',
    );
    $this->consumeWhitespace();
    list ($next, $next_type) = $tq->shift();
    invariant(
      $next_type === T_CONSTANT_ENCAPSED_STRING || $next_type === T_STRING,
      'Expected arg to define() to be a T_CONSTANT_ENCAPSED_STRING or '.
      'T_STRING, got %s',
      token_name($next_type),
    );
    $name = $next;
    if ($next_type !== T_STRING) {
      // 'CONST_NAME' or "CONST_NAME"
      invariant(
        $name[0] === $name[strlen($name) - 1],
        'Mismatched quotes',
      );
      $name = substr($name, 1, strlen($name) - 2);
    }
    $this->consumeStatement();
    return new ScannedConstantBuilder(
      $name,
      $value,
      /* typehint = */ null,
    );
  }
}
