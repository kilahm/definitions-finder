<?hh // strict

abstract class AbstractHackTest extends PHPUnit_Framework_TestCase {
  private ?FredEmmott\DefinitionFinder\FileParser $parser;

  abstract protected function getFilename(): string;
  abstract protected function getPrefix(): string;

  protected function setUp(): void {
    $this->parser = \FredEmmott\DefinitionFinder\FileParser::fromFile(
      __DIR__.'/data/'.$this->getFilename(),
    );
  }

  public function testClasses(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'SimpleClass',
        $this->getPrefix().'GenericClass',
        $this->getPrefix().'AbstractFinalClass',
        $this->getPrefix().'xhp_foo',
        $this->getPrefix().'xhp_foo__bar',
      },
      $this->parser?->getClasses(),
    );
  }

  public function testTypes(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'MyType',
        $this->getPrefix().'MyGenericType',
      },
      $this->parser?->getTypes(),
    );
  }

  public function testNewtypes(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'MyNewtype',
        $this->getPrefix().'MyGenericNewtype',
      },
      $this->parser?->getNewtypes(),
    );
  }

  public function testEnums(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'MyEnum',
      },
      $this->parser?->getEnums(),
    );
  }

  public function testFunctions(): void {
    // As well as testing that these functions were mentioned,
    // this also checks that SimpelClass::iAmNotAGlobalFunction
    // was not listed
    $this->assertEquals(
      Vector {
        $this->getPrefix().'simple_function',
        $this->getPRefix().'generic_function',
      },
      $this->parser?->getFunctions(),
    );
  }
}
