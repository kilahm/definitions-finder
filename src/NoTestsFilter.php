<?hh // strict

namespace FredEmmott\DefinitionFinder;

class NoTestsFilter extends BaseTreeDefinitionsFilter {
  private static function TestPatterns(): Set<string> {
    return Set {
      '/test/',
      '/tests/',
      'Test.php',
      'Test.hh',
    };
  }

  protected static function Filtered(
    \ConstMap<string, Set<string>> $collection,
    DefinitionType $type,
  ): \ConstMap<string, Set<string>> {
    $out = Map { };
    foreach ($collection as $def => $paths) {
      $new_paths = $paths->filter($path ==> self::FilterPath($path));
      if ($new_paths) {
        $out[$def] = $new_paths;
      }
    }
    return $out;
  }

  private static function FilterPath(string $path): bool {
    foreach (self::TestPatterns() as $pattern) {
      if (strpos($path, $pattern) !== false) {
        return false;
      }
    }
    return true;
  }
}
