<?hh // strict

class SingleNamespacePHPTest extends AbstractPHPTest {
  protected function getFilename(): string {
    return 'single_namespace_php.php';
  }

  protected function getPrefix(): string {
    return 'SingleNamespace\\';
  }
}
