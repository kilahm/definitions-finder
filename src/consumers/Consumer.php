<?hh // strict

namespace FredEmmott\DefinitionFinder;

abstract class Consumer {
  public function __construct(
    protected TokenQueue $tq,
    protected \ConstMap<string, string> $aliases
  ) {
  }

  protected function consumeWhitespace(): void {
    while (!$this->tq->isEmpty()) {
      list($_, $ttype) = $this->tq->peek();
      if ($ttype === T_WHITESPACE || $ttype === T_COMMENT) {
        $this->tq->shift();
        continue;
      }
      break;
    }
  }

  protected function consumeStatement(): void {
    $first = null;
    while ($this->tq->haveTokens()) {
      list($tv, $ttype) = $this->tq->shift();
      if ($first === null) {
        $first = $tv;
      }
      if ($tv === ';') {
        return;
      }
      if ($tv === '{') {
        $this->consumeBlock();
        if ($first === '{') {
          return;
        }
      }
    }
  }

  protected function skipToBlock(): void {
    while ($this->tq->haveTokens()) {
      list($next, $next_type) = $this->tq->shift();
      if ($next === '{' || $next_type === T_CURLY_OPEN) {
        return;
      }
    }
    invariant_violation('no block');
  }

  protected function consumeBlock(): void {
    $nesting = 1;
    while ($this->tq->haveTokens()) {
      list($next, $next_type) = $this->tq->shift();
      if ($next === '{' || $next_type === T_CURLY_OPEN) {
        ++$nesting;
      } else if ($next === '}') { // no such thing as T_CURLY_CLOSE
        --$nesting;
        if ($nesting === 0) {
          return;
        }
      }
    }
  }

  protected function unaliasName(?string $name): ?string {

    if ($name === null) {
      return $name;
    }

    $parts = explode('\\', $name);
    $base = $parts[0];
    $realBase = $this->aliases->get($base);

    if ($realBase === null) {
      return $name;
    }

    $parts[0] = $realBase;
    return implode('\\', $parts);
  }
}
