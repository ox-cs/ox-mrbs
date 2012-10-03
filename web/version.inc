<?php

// $Id: version.inc 1269 2009-11-24 21:21:09Z jberanek $

// This should probably be a class, but you can only have protected
// class members in PHP 5, so we won't bother

function get_mrbs_version()
{
  // MRBS developers, make sure to update this string before each release
  $mrbs_version = "MRBS 1.4.3";

  return $mrbs_version;
}

?>
