<?php

class Foo {
  function defaultVisibility() {}
  private function privateVisibility() {}
  function alsoDefaultVisibility() {}

  /** FooDoc */
  const FOO = 'bar';

  private $untypedProperty;
}
