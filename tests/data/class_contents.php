<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

class ClassWithContents {
  public function publicMethod(): void {}
  protected function protectedMethod(): void {}
  private function privateMethod(): void {}

  public static function PublicStaticMethod(): void {}
}
