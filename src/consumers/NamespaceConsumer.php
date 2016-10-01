<?hh // strict


namespace FredEmmott\DefinitionFinder;

final class NamespaceConsumer extends Consumer {
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

    // empty $parts is valid inside HHVM's systemlib: namespace { } is used
    // in files that also contain HH\ or __SystemLib\

    $ns = implode("\\", $parts);
    $context = $this->context;
    $context['namespace'] = $ns;

    $builder = (new ScannedNamespaceBuilder($ns, $this->getBuilderContext()))
      ->setContents(
        (new ScopeConsumer(
          $this->tq,
          $context,
          ScopeType::NAMESPACE_SCOPE,
        ))->getBuilder()
    );
    return $builder;
  }
}
