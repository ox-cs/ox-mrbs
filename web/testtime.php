<?php


require_once "defaultincludes.inc";

require_once "mincals.inc";
require_once "theme.inc";

echo "27th march 2012 ";
echo is_dst(2,27,2012);
echo date( "I", mktime(12, 0, 0, 1, 27, 2012));
echo date( "I", mktime(12, 0, 0, 2, 27, 2012));
echo date( "I", mktime(12, 0, 0, 3, 27, 2012));
echo "\n";

echo "28th march 2012 ";
echo is_dst(2,28,2012);

echo "\n";

echo "30th oct 2012 ";
echo is_dst(9,30,2012);
echo "\n";

echo "1st nov 2012 ";
echo is_dst(10,1,2012);
echo "\n";

?>

