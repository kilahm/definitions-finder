<?hh // strict


namespace FredEmmott\DefinitionFinder;

class NamespaceConsumer extends Consumer {
  public function getBuilder(): ScannedNamespaceBuilder {
    $parts = [];
    do {
      $this->consumeWhitespace();
      list($next, $next_type) = $this->tq->shift();
      if ($next_type === T_STRING) {
        $parts[] = $next;
        continue;
      } else if ($next_type === T_NS_SEPARATOR) {
        continue;
      } else if ($next === '{' || $next === ';') {
        break;
      }
      invariant_violation(
        'Unexpected token %s',
        var_export($next, true),
      );
    } while ($this->tq->haveTokens());

    $ns = $parts ? (implode('\\', $parts).'\\') : '';

    $builder = (new ScannedNamespaceBuilder($ns))
      ->setContents(
        (new ScopeConsumer($this->tq, ScopeType::NAMESPACE_SCOPE))
          ->getBuilder()
    );
    return $builder;
  }
}
