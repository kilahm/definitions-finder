<?hh // strict

use FredEmmott\DefinitionFinder\ScannedClass;
use FredEmmott\DefinitionFinder\ScannedFunction;
use FredEmmott\DefinitionFinder\ScannedFunctionAbstract;
use FredEmmott\DefinitionFinder\ScannedMethod;

abstract class AbstractHackTest extends PHPUnit_Framework_TestCase {
  private ?FredEmmott\DefinitionFinder\FileParser $parser;

  abstract protected function getFilename(): string;
  abstract protected function getPrefix(): string;

  protected function setUp(): void {
    $this->parser = \FredEmmott\DefinitionFinder\FileParser::FromFile(
      __DIR__.'/data/'.$this->getFilename(),
    );
  }

  public function testClasses(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'SimpleClass',
        $this->getPrefix().'GenericClass',
        $this->getPrefix().'GenericAliasedConstraintClass',
        $this->getPrefix().'AbstractFinalClass',
        $this->getPrefix().'AbstractClass',
        $this->getPrefix().'xhp_foo',
        $this->getPrefix().'xhp_foo__bar',
      },
      $this->parser?->getClassNames(),
    );
  }

  public function testTypes(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'MyType',
        $this->getPrefix().'MyGenericType',
      },
      $this->parser?->getTypeNames(),
    );
  }

  public function testNewtypes(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'MyNewtype',
        $this->getPrefix().'MyGenericNewtype',
      },
      $this->parser?->getNewtypeNames(),
    );
  }

  public function testEnums(): void {
    $this->assertEquals(
      Vector {
        $this->getPrefix().'MyEnum',
      },
      $this->parser?->getEnumNames(),
    );
  }

  public function testFunctions(): void {
    // As well as testing that these functions were mentioned,
    // this also checks that SimpelClass::iAmNotAGlobalFunction
    // was not listed
    $this->assertEquals(
      Vector {
        $this->getPrefix().'simple_function',
        $this->getPrefix().'generic_function',
        $this->getPrefix().'constrained_generic_function',
        $this->getPrefix().'byref_return_function',
        $this->getPrefix().'returns_int',
        $this->getPrefix().'returns_generic',
        $this->getPrefix().'returns_nested_generic',
        $this->getPrefix().'aliased',
        $this->getPrefix().'aliased_with_namespace',
        $this->getPrefix().'aliased_with_nested_namespace',
        $this->getPrefix().'aliased_namespace',
        $this->getPrefix().'aliased_no_as',
      },
      $this->parser?->getFunctionNames(),
    );
  }

  public function testConstants(): void {
    // Makes sure that GenericClass::NOT_A_GLOBAL_CONSTANT is not returned
    $this->assertEquals(
      Vector {
        $this->getPrefix().'MY_CONST',
        $this->getPrefix().'MY_TYPED_CONST',
        $this->getPrefix().'MY_OLD_STYLE_CONST',
        $this->getPrefix().'MY_OTHER_OLD_STYLE_CONST',
        $this->getPrefix().'NOW_IM_JUST_FUCKING_WITH_YOU',
      },
      $this->parser?->getConstantNames(),
    );
  }

  public function testClassGenerics(): void {
    $class = $this->parser?->getClass($this->getPrefix().'GenericClass');
    assert($class !== null);

    $this->assertEquals(
      Vector {'Tk', 'Tv'},
      $class->getGenericTypes()->map($x ==> $x->getName()),
    );

    $this->assertEquals(
      Vector {null, null},
      $class->getGenericTypes()->map($x ==> $x->getConstraintTypeName()),
    );

    $class = $this->parser?->getClass(
      $this->getPrefix().'GenericAliasedConstraintClass'
    );
    assert($class !== null);

    $this->assertEquals(
      Vector {'T'},
      $class->getGenericTypes()->map($x ==> $x->getName()),
    );

    $this->assertEquals(
      Vector {'Foo'},
      $class->getGenericTypes()->map($x ==> $x->getConstraintTypeName()),
    );
  }

  public function testFunctionGenerics(): void {
    $func = $this->getFunction('generic_function');

    $this->assertEquals(
      Vector {'Tk', 'Tv'},
      $func->getGenericTypes()->map($x ==> $x->getName()),
    );

    $this->assertEquals(
      Vector {null, null},
      $func->getGenericTypes()->map($x ==> $x->getConstraintTypeName()),
    );

    $func = $this->getFunction('constrained_generic_function');

    $this->assertEquals(
      Vector {'Tk', 'Tv'},
      $func->getGenericTypes()->map($x ==> $x->getName()),
    );

    $this->assertEquals(
      Vector {'arraykey', null},
      $func->getGenericTypes()->map($x ==> $x->getConstraintTypeName()),
    );
  }

  public function testFunctionReturnTypes(): void {
    $type = $this->getFunction('returns_int')->getReturnType();
    $this->assertSame('int', $type?->getTypeName());
    $this->assertEmpty($type?->getGenericTypes());

    $type = $this->getFunction('returns_generic')->getReturnType();
    $this->assertSame('Vector', $type?->getTypeName());
    $generics = $type?->getGenericTypes();
    $this->assertSame(1, count($generics));
    $sub_type = $generics?->get(0);
    $this->assertSame('int', $sub_type?->getTypeName());
    $this->assertEmpty($sub_type?->getGenericTypes());

    $type = $this->getFunction('returns_nested_generic')->getReturnType();
    $this->assertSame('Vector', $type?->getTypeName());
    $generics = $type?->getGenericTypes();
    $this->assertSame(1, count($generics));
    $sub_type = $generics?->get(0);
    $this->assertSame('Vector', $sub_type?->getTypeName());
    $sub_generics = $sub_type?->getGenericTypes();
    $this->assertSame(1, count($sub_generics));
    $sub_sub_type = $sub_generics?->get(0);
    $this->assertSame('int', $sub_sub_type?->getTypeName());
    $this->assertEmpty($sub_sub_type?->getGenericTypes());
  }

  public function testAliasedTypehints(): void {
    $data = Map {
      'Foo' => $this->getFunction('aliased'),
        'SingleNamespace\Foo' => $this->getFunction(
          'aliased_with_namespace'
        ),
      'Namespaces\AreNested\Now\Foo' => $this->getFunction(
        'aliased_with_nested_namespace'
      ),
      'Namespaces\AreNested\Now\Foo' => $this->getFunction(
        'aliased_namespace'
      ),
      'Namespaces\AreNested\Now\Bar' => $this->getFunction(
        'aliased_no_as'
      ),
      'Namespaces\AreNested\Now\Bar' => $this->getClassMethod(
        'SimpleClass',
        'aliasInClassScope'
      ),
    };
    foreach($data as $typeName => $fun) {
      $returnType = $fun->getReturnType();
      $paramType = $fun->getParameters()->get(0)?->getTypehint();
      $this->assertSame($typeName, $returnType?->getTypeName());
      $this->assertSame($typeName, $paramType?->getTypeName());
    }
  }

  private function getFunction(string $name): ScannedFunction {
    $func = $this->parser?->getFunction($this->getPrefix().$name);
    invariant($func !== null, 'Could not find function %s', $name);
    return $func;
  }

  private function getClass(string $name): ScannedClass {
    $class = $this->parser?->getClass($this->getPrefix().$name);
    invariant($class !== null, 'Could not find class %s', $name);
    return $class;
  }

  private function getClassMethod(
    string $className,
    string $methodName
  ): ScannedMethod {
    $method = $this
      ->getClass($className)
      ->getMethods()
      ->filter($m ==> $m->getName() === $methodName)
      ->get(0);
    invariant(
      $method !== null,
      'Could not find method %s in class %s',
      $methodName,
      $className
    );
    return $method;
  }
}
