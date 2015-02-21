<?hh // strict

class NestedNamespaceHackTest extends AbstractHackTest {
  protected function getFilename(): string {
    return 'nested_namespace_hack.php';
  }

  protected function getPrefix(): string {
    return 'Namespaces\\AreNestedNow\\';
  }
}
