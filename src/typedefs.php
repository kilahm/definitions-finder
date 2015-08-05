<?hh // strict

namespace FredEmmott\DefinitionFinder;

// Composer can't autoload these, so put them all in one file that we tell
// composer to always autoload

type SourcePosition = shape(
  'filename' => string,
);

type AttributeMap = Map<string, Vector<mixed>>;
