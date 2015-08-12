<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

class ClassWithContents {
  private bool $foo = true;
  public string $herp = 'derp';

  /** FooDoc */
  const string FOO = 'bar';

  public function publicMethod(): void {}
  protected function protectedMethod(): void {}
  private function privateMethod(): void {}

  public static function PublicStaticMethod(): void {}
}
