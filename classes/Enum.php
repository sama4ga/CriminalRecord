<?php
abstract class Status
{
  const NEW = "New";
  const CLOSED = "Closed";
  const INVALID = "Invalid";
  const VERIFCATION = "Verification";
  const INPROGRESS = "In Progress";
}

abstract class Priority
{
  const HIGH = "High";
  const MEDIUM = "Medium";
  const LOW = "Low";
}

abstract class Category
{
  const THEFT = "Theft";
  const VANDALISM = "Vandalism";
  const MURDER = "Murder";
}

abstract class CourtType
{
  const JUDICIARY = "Judiciary Court";
  const MAGISTRATE = "Magistrate Court";
  const HIGH = "High Court";
  const SUPREME = "Supreme Court";
  const APPEAL = "Appeal Court";
  const CUSTOMARY = "Customary Court";
  const NIC = "National Industrial Court";
  const SHARIA = "Sharia Court";
}

// enum Category: string
// {
//   case THEFT = "Theft";
//   case VANDALISM = "Vandalism"; 
// }

?>