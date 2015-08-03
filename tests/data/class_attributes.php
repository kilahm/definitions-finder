<?hh // strict

namespace FredEmmott\DefinitionFinder\Test;

<<Foo>>
class ClassWithSimpleAttribute {}

<<Foo,Bar>>
class ClassWithSimpleAttributes {}

<<Herp('derp')>>
class ClassWithStringAttribute {}

<<Herp(123)>>
class ClassWithIntAttribute {}

<<Foo('bar','baz')>>
class ClassWithMultipleAttributeValues {}
