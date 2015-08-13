<?hh // strict
namespace FredEmmott\DefinitionFinder;

interface HasScannedGenerics {
  require extends ScannedBase;
  public function getGenericTypes(): \ConstVector<ScannedGeneric>;
}
