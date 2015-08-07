<?hh // strict
namespace FredEmmott\DefinitionFinder;

function nullthrows<T>(?T $v): T {
  invariant(
    $v !== null,
    'unexpected null',
  );
  return $v;
}

// Defined in runtime in global namespace, but not in HHI
// facebook/hhvm#4872
const int T_TYPELIST_LT = 398;
const int T_TYPELIST_GT = 399;
