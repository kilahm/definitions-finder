<?hh // strict

class NoNamespacePHPTest extends AbstractPHPTest {
  protected function getFilename(): string {
    return 'no_namespace_php.php';
  }

  protected function getPrefix(): string {
    return '';
  }
}
