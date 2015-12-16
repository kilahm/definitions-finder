<?hh // strict

namespace FredEmmott\DefinitionFinder;

class ParseException extends \Exception {
  public function __construct(
    private SourcePosition $source,
    \Exception $previous,
  ) {
    parent::__construct(
      sprintf(
        "%s:%d: %s",
        $source['filename'],
        Shapes::idx($source, 'line', -1),
        $previous->getMessage(),
      ),
      /* code = */ 0,
      $previous
    );
  }

  public function getSourcePosition(): SourcePosition {
    return $this->source;
  }
}
