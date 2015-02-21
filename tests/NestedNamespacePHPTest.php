<?hh // strict

class NestedNamespacePHPTest extends AbstractPHPTest {
  protected function getFilename(): string {
    return 'nested_namespace_php.php';
  }

  protected function getPrefix(): string {
    return 'Namespaces\\AreNestedNow\\';
  }
}
