<?hh

namespace FredEmmott\DefinitionFinder\DocCommentTest;

/** class doc */
class ClassWithDocComment {}

class ClassWithoutDocComment {}

/** function doc */
function function_with_doc_comment() {}

function function_without_doc_comment() {}

/** type doc */
type TypeWithDocComment = string;

/** newtype doc */
newtype NewtypeWithDocComment = string;

/** enum doc */
enum EnumWithDocComment: string {}
