<?hh // strict
namespace FredEmmott\DefinitionFinder;

interface HasScannedVisibility {
  public function isPublic(): bool;
  public function isPrivate(): bool;
  public function isProtected(): bool;
}
