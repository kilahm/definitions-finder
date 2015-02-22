<?hh // strict

namespace FredEmmott\DefinitionFinder;

interface TreeDefinitions {
  public function getClasses(): \ConstMap<string, Set<string>>;
  public function getInterfaces(): \ConstMap<string, Set<string>>;
  public function getTraits(): \ConstMap<string, Set<string>>;
  public function getEnums(): \ConstMap<string, Set<string>>;
  public function getTypes(): \ConstMap<string, Set<string>>;
  public function getNewtypes(): \ConstMap<string, Set<string>>;
  public function getFunctions(): \ConstMap<string, Set<string>>;
  public function getConstants(): \ConstMap<string, Set<string>>;
}
