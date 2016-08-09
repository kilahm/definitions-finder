<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

use FredEmmott\DefinitionFinder\FileParser;
use FredEmmott\DefinitionFinder\ScannedClass;

class ClassContentsTest extends \PHPUnit_Framework_TestCase {
  private ?ScannedClass $class;

  protected function setUp(): void {
    $parser = FileParser::FromFile(
      __DIR__.'/data/class_contents.php'
    );
    $this->class = $parser->getClasses()[0];
    $this->assertSame(
      'FredEmmott\\DefinitionFinder\\Test\\ClassWithContents',
      $this->class->getName(),
    );
  }

  public function testNamespaceName(): void {
    $this->assertEquals(
      'FredEmmott\DefinitionFinder\Test',
      $this->class?->getNamespaceName(),
    );
    $this->assertEquals(
      Vector {'', '', '', ''},
      $this->class?->getMethods()?->map($x ==> $x->getNamespaceName()),
    );
  }

  public function testShortName(): void {
    $this->assertEquals(
      'ClassWithContents',
      $this->class?->getShortName(),
    );
    $this->assertEquals(
      Vector {
        'publicMethod',
        'protectedMethod',
        'privateMethod',
        'PublicStaticMethod',
      },
      $this->class?->getMethods()?->map($x ==> $x->getShortName()),
    );
  }

  public function testMethodNames(): void {
    $this->assertEquals(
      Vector {
        'publicMethod',
        'protectedMethod',
        'privateMethod',
        'PublicStaticMethod',
      },
      $this->class?->getMethods()?->map($x ==> $x->getName()),
    );
  }

  public function testMethodVisibility(): void {
    $this->assertEquals(
      Vector {true, false, false, true},
      $this->class?->getMethods()?->map($x ==> $x->isPublic()),
      'isPublic',
    );
    $this->assertEquals(
      Vector {false, true, false, false},
      $this->class?->getMethods()?->map($x ==> $x->isProtected()),
      'isProtected',
    );
    $this->assertEquals(
      Vector {false, false, true, false},
      $this->class?->getMethods()?->map($x ==> $x->isPrivate()),
      'isPrivate',
    );
  }

  public function testHackConstants(): void {
    $constants = $this->class?->getConstants();
    $this->assertEquals(
      Vector { 'FOO' },
      $constants?->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { 'string' },
      $constants?->map($x ==> $x->getTypehint()?->getTypeName()),
    );
    $this->assertEquals(
      Vector { '/** FooDoc */' },
      $constants?->map($x ==> $x->getDocComment()),
    );
  }

  public function testPHPConstants(): void {
    $parser = FileParser::FromFile(__DIR__.'/data/php_class_contents.php');
    $class = $parser->getClass('Foo');
    $constants = $class->getConstants();

    $this->assertEquals(
      Vector { 'FOO' },
      $constants->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { null },
      $constants->map($x ==> $x->getTypehint()),
    );
    $this->assertEquals(
      Vector { '/** FooDoc */' },
      $constants->map($x ==> $x->getDocComment()),
    );
  }

  /** Omitting public/protected/private is permitted in PHP */
  public function testDefaultMethodVisibility(): void {
    $parser = FileParser::FromFile(__DIR__.'/data/php_class_contents.php');
    $funcs = $parser->getClass('Foo')->getMethods();

    $this->assertEquals(
      Vector {
        'defaultVisibility',
        'privateVisibility',
        'alsoDefaultVisibility',
      },
      $funcs->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { true, false, true },
      $funcs->map($x ==> $x->isPublic()),
    );
  }

  public function testMethodsAreStatic(): void {
    $this->assertEquals(
      Vector { false, false, false, true },
      $this->class?->getMethods()?->map($x ==> $x->isStatic()),
      'isPublic',
    );
  }

  public function testPropertyNames(): void {
    $this->assertEquals(
      Vector { 'foo', 'herp' },
      $this->class?->getProperties()?->map($x ==> $x->getName()),
    );
  }

  public function testPropertyVisibility(): void {
    $this->assertEquals(
      Vector { false, true },
      $this->class?->getProperties()?->map($x ==> $x->isPublic()),
    );
  }

  public function testPropertyTypes(): void {
    $this->assertEquals(
      Vector { 'bool', 'string' },
      $this->class?->getProperties()?->map(
        $x ==> $x->getTypehint()?->getTypeName()
      ),
    );
  }

  public function testTypelessProperty(): void {
    $parser = FileParser::FromFile(__DIR__.'/data/php_class_contents.php');
    $props = $parser->getClass('Foo')->getProperties();

    $this->assertEquals(
      Vector { 'untypedProperty' },
      $props->map($x ==> $x->getName()),
    );
    $this->assertEquals(
      Vector { null },
      $props->map($x ==> $x->getTypehint()),
    );
  }

  public function staticPropertyProvider(): array<array<mixed>> {
    return [
      ['default', '<?php class Foo { static $bar; }', null],
      ['public static', '<?php class Foo { public static $bar; }', null],
      ['static public', '<?php class Foo { static public $bar; }', null],
      [
        'public static string',
        '<?hh class Foo { public static string $bar; }',
        'string',
      ],
      [
        'static public string',
        '<?hh class Foo { static public string $bar; }',
        'string',
      ],
    ];
  }

  /** @dataProvider staticPropertyProvider */
  public function testStaticProperty(
    string $_,
    string $code,
    ?string $type,
  ): void {
    $parser = FileParser::FromData($code);
    $class = $parser->getClass('Foo');
    $props = $class->getProperties();

    $this->assertEquals(
      Vector { 'bar' },
      $props->map($x ==> $x->getName()),
    );

    $this->assertEquals(
      Vector { $type },
      $props->map($x ==> $x->getTypehint()?->getTypeName()),
    );


    $this->assertEquals(
      Vector { true },
      $props->map($x ==> $x->isStatic()),
    );
  }

  public function testTypeConstant(): void {
    $data = '<?hh class Foo { const type BAR = int; }';
    $parser = FileParser::FromData($data);
    $constants = $parser->getClass('Foo')->getTypeConstants();
    $this->assertSame(1, $constants->count());
    $constant = $constants->at(0);

    $this->assertSame('BAR', $constant->getName());
    $this->assertFalse($constant->isAbstract());
    $this->assertSame('int', $constant->getValue()?->getTypeText());
  }

  public function testAbstractTypeConstant(): void {
    $data = '<?hh abstract class Foo { abstract const type BAR; }';
    $parser = FileParser::FromData($data);
    $constants = $parser->getClass('Foo')->getTypeConstants();
    $this->assertSame(1, $constants->count());
    $constant = $constants->at(0);

    $this->assertSame('BAR', $constant->getName());
    $this->assertTrue($constant->isAbstract());
    $this->assertNull($constant->getValue());
  }

  public function testConstrainedAbstractTypeConstant(): void {
    $data = '<?hh abstract class Foo { abstract const type BAR as Bar; }';
    $parser = FileParser::FromData($data);
    $constants = $parser->getClass('Foo')->getTypeConstants();
    $this->assertSame(1, $constants->count());
    $constant = $constants->at(0);

    $this->assertSame('BAR', $constant->getName());
    $this->assertTrue($constant->isAbstract());
    $this->assertSame('Bar', $constant->getValue()?->getTypeText());
  }

  public function testTypeConstantAsProperty(): void {
    $data = '<?hh class Foo { public this::FOO $foo; }';
    $parser = FileParser::FromData($data);
    $props = $parser->getClass('Foo')->getProperties();
    $this->assertSame(1, $props->count());
    $prop = $props->at(0);

    $this->assertSame('this::FOO', $prop->getTypehint()?->getTypeText());
    $this->assertSame('foo', $prop->getName());
  }

  public function testTypeconstantAsReturnType(): void {
    $data = '<?hh class Foo { public function bar(): this::FOO {} }';
    $parser = FileParser::FromData($data);
    $methods = $parser->getClass('Foo')->getMethods();
    $this->assertSame(1, $methods->count());
    $method = $methods->at(0);

    $this->assertSame('this::FOO', $method->getReturnType()?->getTypeText());
  }

  public function testTypeconstantAsParameterType(): void {
    $data = '<?hh class Foo { public function bar(this::FOO $foo): void {} }';
    $parser = FileParser::FromData($data);
    $methods = $parser->getClass('Foo')->getMethods();
    $this->assertSame(1, $methods->count());
    $method = $methods->at(0);
    $params = $method->getParameters();
    $this->assertSame(1, $params->count());
    $param = $params->at(0);

    $this->assertSame('this::FOO', $param->getTypehint()?->getTypeText());
    $this->assertSame('foo', $param->getName());
  }

  public static function namespacedReturns(): array<shape(
    'namespace' => string,
    'return type text' => string,
    'expected return type text' => string,
  )> {
    return [
      shape(
        'namespace' => '',
        'return type text' => 'this::FOO',
        'expected return type text' => 'this::FOO',
      ),
      shape(
        'namespace' => 'Bar',
        'return type text' => 'this::FOO',
        'expected return type text' => 'this::FOO',
      ),
      shape(
        'namespace' => '',
        'return type text' => 'Bar::FOO',
        'expected return type text' => 'Bar::FOO',
      ),
      shape(
        'namespace' => 'NS',
        'return type text' => 'Bar::FOO',
        'expected return type text' => 'NS\Bar::FOO',
      ),
      shape(
        'namespace' => 'NS',
        'return type text' => '\Bar::FOO',
        'expected return type text' => 'Bar::FOO',
      ),
      shape(
        'namespace' => 'NS',
        'return type text' => 'Nested\Bar::FOO',
        'expected return type text' => 'NS\Nested\Bar::FOO',
      ),
      shape(
        'namespace' => 'NS',
        'return type text' => '\Nested\Bar::FOO',
        'expected return type text' => 'Nested\Bar::FOO',
      ),
    ];
  }

  /**
   * @dataProvider namespacedReturns
   */
  public function testNamespacedTypeconstantAsParameterType(
    string $namespace,
    string $returnText,
    string $expectedTypehintText,
  ): void {
    $data = sprintf(
    '<?hh %s class Foo { public function bar(): %s {} }',
      $namespace === '' ? '' : "namespace $namespace;",
      $returnText
    );
    $className = $namespace . '\Foo'
      |> ltrim($$, '\\');
    $parser = FileParser::FromData($data);
    $methods = $parser->getClass($className)->getMethods();
    $this->assertSame(1, $methods->count());
    $method = $methods->at(0);

    $this->assertSame(
      $expectedTypehintText,
      $method->getReturnType()?->getTypeText()
    );
  }
}
