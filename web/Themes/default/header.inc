<?php

// $Id: header.inc 1209 2009-10-01 22:46:01Z cimorrison $

// Print the page header
function print_theme_header($day, $month, $year, $area, $room)
{
  global $mrbs_company, $mrbs_company_logo, $mrbs_company_url, $mrbs_company_more_info,
    $search_str, $locale_warning;
  global $PHP_SELF;

  // If we dont know the right date then make it up 
  if (!$day)
  {
    $day   = date("d");
  }
  if (!$month)
  {
    $month = date("m");
  }
  if (!$year)
  {
    $year  = date("Y");
  }
  if (empty($search_str))
  {
    $search_str = "";
  }
  
  header("Content-Type: text/html; charset=" . get_charset());
  header("Pragma: no-cache");                          // HTTP 1.0
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
<?php
  require_once "style.inc";
?>
    <title><?php echo get_vocab("mrbs") ?></title>
    <script type="text/javascript">

//<![CDATA[

/*   Script inspired by "True Date Selector"
     Created by: Lee Hinder, lee.hinder@ntlworld.com 
     
     Tested with Windows IE 6.0
     Tested with Linux Opera 7.21, Mozilla 1.3, Konqueror 3.1.0
     
*/

function daysInFebruary (year)
{
  // February has 28 days unless the year is divisible by four,
  // and if it is the turn of the century then the century year
  // must also be divisible by 400 when it has 29 days
  return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}

//function for returning how many days there are in a month including leap years
function DaysInMonth(WhichMonth, WhichYear)
{
  var DaysInMonth = 31;
  if (WhichMonth == "4" || WhichMonth == "6" || WhichMonth == "9" || WhichMonth == "11")
  {
    DaysInMonth = 30;
  }
  if (WhichMonth == "2")
  {
    DaysInMonth = daysInFebruary( WhichYear );
  }
  return DaysInMonth;
}

//function to change the available days in a months
function ChangeOptionDays(formObj, prefix)
{
  var DaysObject = eval("formObj." + prefix + "day");
  var MonthObject = eval("formObj." + prefix + "month");
  var YearObject = eval("formObj." + prefix + "year");

  if (typeof DaysObject.selectedIndex == 'number' && DaysObject.options)
  { // The DOM2 standard way
    // alert("The DOM2 standard way");
    var DaySelIdx = DaysObject.selectedIndex;
    var Month = parseInt(MonthObject.options[MonthObject.selectedIndex].value);
    var Year = parseInt(YearObject.options[YearObject.selectedIndex].value);
  }
  else if (DaysObject.selectedIndex && DaysObject[DaysObject.selectedIndex])
  { // The legacy MRBS way
    // alert("The legacy MRBS way");
    var DaySelIdx = DaysObject.selectedIndex;
    var Month = parseInt(MonthObject[MonthObject.selectedIndex].value);
    var Year = parseInt(YearObject[YearObject.selectedIndex].value);
  }
  else if (DaysObject.value)
  { // Opera 6 stores the selectedIndex in property 'value'.
    // alert("The Opera 6 way");
    var DaySelIdx = parseInt(DaysObject.value);
    var Month = parseInt(MonthObject.options[MonthObject.value].value);
    var Year = parseInt(YearObject.options[YearObject.value].value);
  }

  // alert("Day="+(DaySelIdx+1)+" Month="+Month+" Year="+Year);

  var DaysForThisSelection = DaysInMonth(Month, Year);
  var CurrentDaysInSelection = DaysObject.length;
  if (CurrentDaysInSelection > DaysForThisSelection)
  {
    for (i=0; i<(CurrentDaysInSelection-DaysForThisSelection); i++)
    {
      DaysObject.options[DaysObject.options.length - 1] = null
    }
  }
  if (DaysForThisSelection > CurrentDaysInSelection)
  {
    for (i=0; i<DaysForThisSelection; i++)
    {
      DaysObject.options[i] = new Option(eval(i + 1));
    }
  }
  if (DaysObject.selectedIndex < 0)
  {
    DaysObject.selectedIndex = 0;
  }
  if (DaySelIdx >= DaysForThisSelection)
  {
    DaysObject.selectedIndex = DaysForThisSelection-1;
  }
  else
  {
    DaysObject.selectedIndex = DaySelIdx;
  }
}

//]]>
    </script>
  </head>
  <?php
  // Put the filename in as a class to aid styling.   
  // (Use a class rather than id to avoid specificity problems)
  echo "<body class=\"" . basename($PHP_SELF,".php" ) . "\">\n";
  ?>
    <div class="screenonly">

<?php // show a warning if this is using a low version of php
  if (substr(phpversion(), 0, 1) == 3)
  {
    echo "<h1>" . get_vocab("not_php3") . "</h1>\n";
  }
  if (!empty($locale_warning))
  {
    echo "[Warning: ".$locale_warning."]";
  }
?>

  <table id="banner">
    <tr>
      <td id="company">
        <div>
          <?php
          echo "<div id=\"logo\">\n";
          if (!empty($mrbs_company_url))
          {
            echo "<a href=\"$mrbs_company_url\">\n";
          }
          if (empty($mrbs_company_logo))
          {
            echo "<span>$mrbs_company</span>\n";
          }
          else
          {
            $logo_size = getimagesize($mrbs_company_logo);
            echo "<img src=\"$mrbs_company_logo\" " . $logo_size[3] . " alt=\"logo\">\n";
          }
          if (!empty($mrbs_company_url))
          {
            echo "</a>\n";
          }
          echo "</div>\n";
          if (!empty($mrbs_company_more_info))
          {
            echo "<div id=\"more_info\">$mrbs_company_more_info</div>\n";
          }
          ?>
          <div id="mrbs">
            <a href="index.php"><?php echo get_vocab("mrbs") ?></a>
          </div>
        </div>
      </td>
      <td>
        <form action="day.php" method="get" id="Form1">
          <div>
            <?php
            genDateSelector("", $day, $month, $year); // Note: The 1st arg must match the last arg in the call to ChangeOptionDays below.
            if (!empty($area))
            {
              echo "<input type=\"hidden\" name=\"area\" value=\"$area\">\n";
            }
            if (!empty($room))
            {
              echo "<input type=\"hidden\" name=\"room\" value=\"$room\">\n";
            }
  
            ?>
            <script type="text/javascript">
              //<![CDATA[
              // fix number of days for the $month/$year that you start with
              ChangeOptionDays(document.getElementById('Form1'), ''); // Note: The 2nd arg must match the first in the call to genDateSelector above.
              //]]>
            </script>
            <input type="submit" value="<?php echo get_vocab("goto") ?>">
          </div>
        </form>
	<br/>
	<?php
	
	$todays_date=mktime(0, 0, 0, $month, $day, $year);
	$todays_date_minus=strtotime("-32 week", $todays_date);
  
	$sql="SELECT start_date FROM terms WHERE start_date>='$todays_date_minus' AND start_date<='$todays_date' ORDER BY start_date DESC LIMIT 1";
  
	$term_res=sql_query($sql);

	$start_date_row = sql_row_keyed($term_res, 0);
	$start_date=$start_date_row['start_date'];
	
	$term_week=intval(($todays_date-$start_date)/(7*24*60*60));
	?>
	<form action="termday.php" method="get">
	<select name="DayOfWeek">
	<option value="+1" <?php if(date("w",$todays_date)==1){echo " selected=\"selected\"";} ?> >Monday</option>
	<option value="+2" <?php if(date("w",$todays_date)==2){echo " selected=\"selected\"";} ?> >Tuesday</option>
	<option value="+3" <?php if(date("w",$todays_date)==3){echo " selected=\"selected\"";} ?> >Wednesday</option>
	<option value="+4" <?php if(date("w",$todays_date)==4){echo " selected=\"selected\"";} ?> >Thursday</option>
	<option value="+5" <?php if(date("w",$todays_date)==5){echo " selected=\"selected\"";} ?> >Friday</option>
	<option value="+6" <?php if(date("w",$todays_date)==6){echo " selected=\"selected\"";} ?> >Saturday</option>
	<option value="+0" <?php if(date("w",$todays_date)==0){echo " selected=\"selected\"";} ?> >Sunday</option>
	</select>
	<select name="WeekOfTerm">
	<option value="-1">-1 week</option>
	<?php
	for($i=0;$i<=10;$i++)
	{
		echo "<option value=\"+".$i."\"";
		if($term_week==$i)
		{
			echo " selected=\"selected\"";
		}
		echo ">week ".$i."</option>";
	}
	
	?>
	</select>
	<select name="Term">
	
	 <?php
	 
	$res = sql_query("select start_date from terms order by start_date");
       
  if (sql_count($res) > 0)
  {
   for ($i = 0; ($row = sql_row_keyed($res, $i)); $i++)
   {
    	$y = date("Y",$row['start_date']);
	$m = date("m",$row['start_date']);
	$d = date("d",$row['start_date']);
	
	if($m>=1 && $m<4)
	{
		$term_date="HT".$y;
	}
	else
	if($m>=4 && $m<10 && ($m!=9 || $d<28))
	{
		$term_date="TT".$y;
	}
	else
	{
		$term_date="MT".$y;
	}
	
	echo "<option value=\"".$row['start_date']."\"";
	if($row['start_date'] == $start_date)
	{
		echo " selected=\"selected\"";
	}
	echo ">".$term_date."</option>";
    }
  }
     ?>
     </select>
     <input type="submit" value="<?php echo get_vocab("goto") ?>">
	</form>
      </td>
      <?php
      $query_str = "day=$day&amp;month=$month&amp;year=$year";
      if (!empty($area))
      {
        $query_str .= "&amp;area=$area";
      }
      if (!empty($room))
      {
        $query_str .= "&amp;room=$room";
      }
      
      echo "<td>\n";
      echo "<a href=\"help.php?$query_str\">" . get_vocab("help") . "</a>\n";
      echo "</td>\n";
      
      echo "<td>\n";
      echo "<a href=\"admin.php?$query_str\">" . get_vocab("admin") . "</a>\n";
      echo "</td>\n";
      
      echo "<td>\n";
      echo "<a href=\"report.php?$query_str\">" . get_vocab("report") . "</a>\n";
      echo "</td>\n";
      ?>
      
      <td>
        <form id="header_search" method="get" action="search.php">
          <div>
            <a href="search.php?advanced=1"><?php echo get_vocab("search") ?>:</a>
            <input type="text"   name="search_str" value="<?php echo $search_str ?>">
            <input type="hidden" name="day"        value="<?php echo $day        ?>">
            <input type="hidden" name="month"      value="<?php echo $month      ?>">
            <input type="hidden" name="year"       value="<?php echo $year       ?>">
            <?php
            if (!empty($area))
            {
              echo "<input type=\"hidden\" name=\"area\" value=\"$area\">\n";
            }
            if (!empty($room))
            {
              echo "<input type=\"hidden\" name=\"room\" value=\"$room\">\n";
            }
            ?>
          </div>
        </form>
      </td>
      <?php
      // For session protocols that define their own logon box...
      if (function_exists('PrintLogonBox'))
      {
        echo "<td>\n";
        echo "<div id=\"logon_box\">\n";
        PrintLogonBox(); 
        echo "</div>\n";
        echo "</td>\n";
      }
      ?>
    </tr>
  </table>
</div>
<?php

} // end of print_theme_header()
?>
