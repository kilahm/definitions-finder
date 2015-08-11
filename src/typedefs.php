<?hh // strict

namespace FredEmmott\DefinitionFinder;

// Composer can't autoload these, so put them all in one file that we tell
// composer to always autoload

type SourcePosition = shape(
  'filename' => string,
);

type AttributeMap = Map<string, Vector<mixed>>;

enum VisibilityToken: int {
  T_PUBLIC = T_PUBLIC;
  T_PRIVATE = T_PRIVATE;
  T_PROTECTED = T_PROTECTED;
}
