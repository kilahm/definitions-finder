<?hh // strict

namespace FredEmmott\DefinitionFinder;

/** Deals with new-style constants.
 *
 * const CONST_NAME =
 * const type_name CONST_NAME =
 *
 * See DefineConsumer for old-style constants.
 */
final class ConstantConsumer extends Consumer {
  public function getBuilder(): ScannedConstantBuilder {
    $name = null;
    $value = null;
    $builder = null;
    $typehint = null;

    while ($this->tq->haveTokens()) {
      list ($next, $next_type) = $this->tq->shift();
      if ($next_type === T_WHITESPACE) {
        continue;
      }
      if (StringishTokens::isValid($next_type)) {
        $this->consumeWhitespace();
        list($_, $nnt) = $this->tq->peek();
        if ($nnt === T_STRING) {
          $this->tq->unshift($next, $next_type);
          $typehint = (new TypehintConsumer($this->tq))->getTypehint();
          continue;
        } else {
          $name = $next;
          continue;
        }
      }
      if ($next === '=') {
        $builder = new ScannedConstantBuilder(
          nullthrows($name),
          $value,
          $typehint,
        );
        $name = null;
        $value = null;
        $typehint = null;
        break;
      }
    }
    invariant($builder, 'invalid constant definition');
    $this->consumeStatement();
    return $builder;
  }
}
