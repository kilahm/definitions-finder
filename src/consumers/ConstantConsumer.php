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

    while ($this->tq->haveTokens()) {
      list ($next, $next_type) = $this->tq->shift();
      if ($next_type === T_WHITESPACE) {
        continue;
      }
      if ($next_type === T_STRING) {
        $name = $next;
        continue;
      }
      if ($next === '=') {
        $builder = new ScannedConstantBuilder(
          nullthrows($name),
          $value,
        );
        break;
      }
    }
    invariant($builder, 'invalid constant definition');
    $this->consumeStatement();
    return $builder;
  }
}
