<?php
// $Id: day.php 1231 2009-10-27 16:52:17Z cimorrison $

require_once "defaultincludes.inc";

require_once "mincals.inc";
require_once "theme.inc";

// Get form variables
$dayofweek = get_form_var('DayOfWeek', 'string');
$weekofterm = get_form_var('WeekOfTerm', 'string');
$date = get_form_var('Term', 'int');

// calculate the date from the term

if($$dayofweek!="+0")
{
$date=strtotime("$dayofweek day", $date);
}

if($weekofterm!="+0")
{
$date=strtotime("$weekofterm week", $date);
}

  $y = date("Y",$date);
  $m = date("m",$date);
  $d = date("d",$date);

header("Location: day.php?year=$y&month=$m&day=$d");
?>
