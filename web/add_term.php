<?php


require_once "defaultincludes.inc";

// Get form variables
$start_date_day = get_form_var('day', 'int');
$start_date_month = get_form_var('month', 'int');
$start_date_year = get_form_var('year', 'int');

$required_level = (isset($max_level) ? $max_level : 2);
if (!getAuthorised($required_level))
{
  showAccessDenied($day, $month, $year, $area, "");
  exit();
}

// This file is for adding new terms

$starttime = mktime(0, 0, 0,
                        $start_date_month, $start_date_day  , $start_date_year,
                        is_dst($start_date_month, $start_date_day  , $start_date_year));
			
// Acquire a mutex to lock out others who might be editing the area
  if (!sql_mutex_lock("terms"))
  {
    fatal_error(TRUE, get_vocab("failed_to_acquire"));
  }		

$sql = "INSERT INTO terms 
            (start_date)
            VALUES ('$starttime')";
    if (sql_command($sql) < 0)
    {
      fatal_error(1, sql_error());
    }
    
    sql_mutex_unlock("terms");

$returl = "admin.php";
header("Location: $returl");
