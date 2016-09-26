<?hh // strict

namespace FredEmmott\DefinitionFinder;

class TreeParser extends BaseParser {
  protected ScannedScope $defs;

  private function __construct(
    string $path,
  ) {
    $builder = new ScannedScopeBuilder();

    $rdi = new \RecursiveDirectoryIterator($path);
    $rii = new \RecursiveIteratorIterator($rdi);
    foreach ($rii as $info) {
      if (!$info->isFile()) {
        continue;
      }
      if (!$info->isReadable()) {
        continue;
      }
      $ext = $info->getExtension();
      if ($ext !== 'php' && $ext !== 'hh' && $ext !== 'xhp') {
        continue;
      }
      $parser = FileParser::FromFile($info->getPathname());
      $builder->addSubScope($parser->defs);
    }
    $this->defs = $builder
      ->setPosition(shape('filename' => $path))
      ->build();
  }

  public static function FromPath(string $path): TreeParser {
    return new TreeParser($path);
  }
}
