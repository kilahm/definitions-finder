<?hh // strict

class SingleNamespaceHackTest extends AbstractHackTest {
  protected function getFilename(): string {
    return 'single_namespace_hack.php';
  }

  protected function getPrefix(): string {
    return 'SingleNamespace\\';
  }
}
