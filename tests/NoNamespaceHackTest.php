<?hh // strict

class NoNamespaceHackTest extends AbstractHackTest {
  protected function getFilename(): string {
    return 'no_namespace_hack.php';
  }

  protected function getPrefix(): string {
    return '';
  }
}
