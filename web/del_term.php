<?php
// $Id: del.php 1157 2009-07-16 15:56:07Z jberanek $

require_once "defaultincludes.inc";

// Get form variables

$start_date = get_form_var('start_date', 'int');
$confirm = get_form_var('confirm', 'string');

$required_level = (isset($max_level) ? $max_level : 2);
if (!getAuthorised($required_level))
{
  showAccessDenied($day, $month, $year, $area, "");
  exit();
}


// This is gonna blast away something. We want them to be really
// really sure that this is what they want to do.

  if (isset($confirm))
  {
    // They have confirmed it already, so go blast!
    sql_begin();
    // First take out all appointments for this room
    sql_command("delete from terms where start_date=$start_date");
    sql_commit();
   
    // Go back to the admin page
    Header("Location: admin.php");
  }
  else
  {
    print_header("", "", "", "", "");
    echo "<div id=\"del_room_confirm\">\n";
    echo "<p>" .  get_vocab("sure") . "</p>\n";
    echo "<div id=\"del_room_confirm_links\">\n";
    echo "<a href=\"del_term.php?start_date=$start_date&amp;confirm=Y\"><span id=\"del_yes\">" . get_vocab("YES") . "!</span></a>\n";
    echo "<a href=\"admin.php\"><span id=\"del_no\">" . get_vocab("NO") . "!</span></a>\n";
    echo "</div>\n";
    echo "</div>\n";
    require_once "trailer.inc";
  }

?>
