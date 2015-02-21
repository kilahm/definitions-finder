<?hh // strict

class GenericClass<Tk, Tv> {
}

abstract final class AbstractFinalClass {
}

class :foo {
}

class :foo:bar {
}

function generic_function<Tk, Tv>(): void {
}

const int MY_CONST = 123;

type MyType = int;
type MyGenericType<T> = string;
newtype MyNewtype = string;
newtype MyGenericNewtype<T> = string;

enum MyEnum: string {
}
