<?php

// $Id: admin.php 1231 2009-10-27 16:52:17Z cimorrison $

require_once "defaultincludes.inc";

// Get form variables
$day = get_form_var('day', 'int');
$month = get_form_var('month', 'int');
$year = get_form_var('year', 'int');
$area = get_form_var('area', 'int');
$room = get_form_var('room', 'int');
$area_name = get_form_var('area_name', 'string');
$error = get_form_var('error', 'string');

// If we dont know the right date then make it up 
if (!isset($day) or !isset($month) or !isset($year))
{
  $day   = date("d");
  $month = date("m");
  $year  = date("Y");
}

if (empty($area))
{
  $area = get_default_area();
}

$required_level = (isset($max_level) ? $max_level : 2);
if (!getAuthorised($required_level))
{
  showAccessDenied($day, $month, $year, $area, "");
  exit();
}

print_header($day, $month, $year, isset($area) ? $area : "", isset($room) ? $room : "");

// If area is set but area name is not known, get the name.
if (isset($area))
{
  if (empty($area_name))
  {
    $res = sql_query("select area_name from $tbl_area where id=$area");
    if (! $res) fatal_error(0, sql_error());
    if (sql_count($res) == 1)
    {
      $row = sql_row_keyed($res, 0);
      $area_name = $row['area_name'];
    }
    sql_free($res);
  }
}


echo "<h2>" . get_vocab("administration") . "</h2>\n";
if (!empty($error))
{
  echo "<p class=\"error\">" . get_vocab($error) . "</p>\n";
}

?>
<table id="admin" class="admin_table">
  <thead>
    <tr>
      <th><?php echo get_vocab("areas") ?></th>
      <th>
        <?php 
        echo get_vocab("rooms");
        if(isset($area_name))
        { 
          echo " " . get_vocab("in") . " " . htmlspecialchars($area_name);
        }
        ?>
      </th>
    </tr>
  </thead>

  <tbody>
  <tr>
    <td>
<?php 
// This cell has the areas
$res = sql_query("select id, area_name from $tbl_area order by area_name");
if (! $res) fatal_error(0, sql_error());

if (sql_count($res) == 0)
{
  echo get_vocab("noareas");
}
else
{
  echo "      <ul>\n";
  for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
  {
    $area_name_q = urlencode($row['area_name']);
    echo "        <li><a href=\"admin.php?area=".$row['id']."&amp;area_name=$area_name_q\">"
      . htmlspecialchars($row['area_name']) . "</a> (<a href=\"edit_area_room.php?area=".$row['id']."\">" . get_vocab("edit") . "</a>) (<a href=\"del.php?type=area&amp;area=".$row['id']."\">" .  get_vocab("delete") . "</a>)</li>\n";
  }
  echo "      </ul>\n";
}
?>
    </td>
    <td>
<?php
// This one has the rooms
if(isset($area))
{
  $res = sql_query("select id, room_name, description, capacity from $tbl_room where area_id=$area order by sort_key");
  if (! $res)
  {
    fatal_error(0, sql_error());
  }
  if (sql_count($res) == 0)
  {
    echo get_vocab("norooms");
  }
  else
  {
    echo "      <ul>";
    for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
    {
      echo "        <li>" . htmlspecialchars($row['room_name']) . "(" . htmlspecialchars($row['description'])
        . ", ".$row['capacity'].") (<a href=\"edit_area_room.php?room=".$row['id']."\">" . get_vocab("edit") . "</a>) (<a href=\"del.php?type=room&amp;room=".$row['id']."\">" . get_vocab("delete") . "</a>)</li>\n";
    }
    echo "      </ul>";
  }
}
else
{
  echo get_vocab("noarea");
}

?>
    </td>
  </tr>
  <tr>
    <td>
      <form class="form_admin" action="add.php" method="post">
        <fieldset>
        <legend><?php echo get_vocab("addarea") ?></legend>
        
          <input type="hidden" name="type" value="area">

          <div>
            <label for="area_name"><?php echo get_vocab("name") ?>:</label>
            <input type="text" id="area_name" name="name" maxlength="<?php echo $maxlength['area.area_name'] ?>">
          </div>
          
          <div>
            <input type="submit" class="submit" value="<?php echo get_vocab("addarea") ?>">
          </div>

        </fieldset>
      </form>
    </td>

    <td>
<?php
if (0 != $area)
{
?>
      <form class="form_admin" action="add.php" method="post">
        <fieldset>
        <legend><?php echo get_vocab("addroom") ?></legend>
        
        <input type="hidden" name="type" value="room">
        <input type="hidden" name="area" value="<?php echo $area; ?>">
        
        <div>
          <label for="room_name"><?php echo get_vocab("name") ?>:</label>
          <input type="text" id="room_name" name="name" maxlength="<?php echo $maxlength['room.room_name'] ?>">
        </div>
        
        <div>
          <label for="room_description"><?php echo get_vocab("description") ?>:</label>
          <input type="text" id="room_description" name="description" maxlength="<?php echo $maxlength['room.description'] ?>">
        </div>
        
        <div>
          <label for="room_capacity"><?php echo get_vocab("capacity") ?>:</label>
          <input type="text" id="room_capacity" name="capacity">
        </div>
       
        <div>
          <input type="submit" class="submit" value="<?php echo get_vocab("addroom") ?>">
        </div>
        
        </fieldset>
      </form>
<?php
}
else
{
  echo "&nbsp;";
}
?>
    </td>
  </tr>
  
  </tbody>
</table>

<table id="admin" class="admin_table">
  <thead>
    <tr>
      <th>Terms</th>
    </tr>
  </thead>

  <tbody>
  <tr>
  <td>
  <?php 
  $res = sql_query("select start_date from terms order by start_date");
  if (! $res)
  {
    fatal_error(0, sql_error());
  }
  if (sql_count($res) == 0)
  {
    echo 'No terms have been defined';
  }
  else
  {
    echo "      <ul>";
    for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
    {
    	$y = date("Y",$row['start_date']);
	$m = date("m",$row['start_date']);
	$d = date("d",$row['start_date']);
	
	
	$term_date = utf8_strftime("%A %d %B %Y",$row['start_date']);
	
	if($m>=1 && $m<4)
	{
		$term_date="HT".$y." - ".$term_date;
	}
	else
	if($m>=4 && $m<10 && ($m!=9 || $d<28))
	{
		$term_date="TT".$y." - ".$term_date;
	}
	else
	{
		$term_date="MT".$y." - ".$term_date;
	}
	
      echo "        <li>" . htmlspecialchars($term_date) . "&#160;(<a href=\"del_term.php?start_date=".$row['start_date']."\">" . get_vocab("delete") . "</a>)</li>\n";
    }
    echo "      </ul>";
  }
  ?>
  </td>
  </tr>
  <tr>
  <td>
  <form class="form_admin" action="add_term.php" method="post">
        <fieldset style="width: 25em">
        <legend><?php echo 'Add Term - Sunday of Week 0' ?></legend>
        
        <div nowrap="nowrap"><nowrap><label for="term_start_date"><?php echo 'Start date' ?>:</label>&#160;<?php gendateselector("", $day, $month, $year) ?></nowrap></div>
        <div>
          <input type="submit" class="submit" value="Add Term">
        </div>
        
        </fieldset>
      </form>
    </td>
  </tr>
  </tbody>
 </table>


<?php

echo "<p>\n" . get_vocab("browserlang") .":\n";

echo implode(", ", array_keys($langs));

echo "\n</p>\n";

require_once "trailer.inc"
?>
