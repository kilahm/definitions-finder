<?hh // strict
namespace FredEmmott\DefinitionFinder;

function nullthrows<T>(?T $v): T {
  invariant(
    $v !== null,
    'unexpected null',
  );
  return $v;
}
