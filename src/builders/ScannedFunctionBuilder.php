<?hh // strict

namespace FredEmmott\DefinitionFinder;

final class ScannedFunctionBuilder
  extends ScannedSingleTypeBuilder<ScannedFunction> {

  private ?bool $byRefReturn;


  public function setByRefReturn(bool $v): this {
    $this->byRefReturn = $v;
    return $this;
  }

  public function build(): ScannedFunction {
    return new ScannedFunction(
      nullthrows($this->position),
      nullthrows($this->namespace).$this->name,
      nullthrows($this->attributes),
    );
  }
}
