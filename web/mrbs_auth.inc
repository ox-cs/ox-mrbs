<?php
// $Id: mrbs_auth.inc 1218 2009-10-18 15:25:13Z jberanek $

// include the authentification wrappers
require_once "auth_$auth[type].inc";

if (isset($auth['session']))
{
  require_once "session_$auth[session].inc";
}


/* getAuthorised($level)
 * 
 * Check to see if the current user has a certain level of rights
 * 
 * $level - The access level required
 * 
 * Returns:
 *   0        - The user does not have the required access
 *   non-zero - The user has the required access
 */
function getAuthorised($level)
{
  global $auth;

  $user = getUserName();
  if(isset($user) == FALSE)
  {
    authGet();
    return 0;
  }

  if (isset($auth['only_admin_can_book']) && $auth['only_admin_can_book'])
  {
    $level = 2;
  }

  //return authGetUserLevel($user) >= $level;
  return authGetUserLevel($user, $auth["admin"], $auth["mortal"]) >= $level;
}

function getAuthLevelName()
{
  global $auth;

  $user = getUserName();
  if(isset($user) == FALSE)
  {
    return "Read only";
  }

  if (isset($auth['only_admin_can_book']) && $auth['only_admin_can_book'])
  {
    $level = 2;
  }

  $level=authGetUserLevel($user, $auth["admin"], $auth["mortal"]);
  
  if($level == 1)
  {
  	return "";
  }

  if($level == 2)
  {
  	return "Administrator";
  }

  return "Read only";
}

/* getWritable($creator, $user)
 * 
 * Determines if a user is able to modify an entry
 *
 * $creator - The creator of the entry
 * $user    - Who wants to modify it
 *
 * Returns:
 *   0        - The user does not have the required access
 *   non-zero - The user has the required access
 */
function getWritable($creator, $user)
{
  global $auth;
  
  // Always allowed to modify your own stuff
  if(strcasecmp($creator, $user) == 0)
  {
    return 1;
  }

// if(authGetUserLevel($user) >= 2)

  if(authGetUserLevel($user, $auth["admin"], $auth["mortal"])>= 2)
  {
    return 1;
  }

  // Unathorised access
  return 0;
}

/* showAccessDenied()
 * 
 * Displays an appropriate message when access has been denied
 * 
 * Returns: Nothing
 */
function showAccessDenied($day, $month, $year, $area, $room)
{
  global $HTTP_REFERER;

  print_header($day, $month, $year, $area, isset($room) ? $room : "");
?>
  <h1><?php echo get_vocab("accessdenied")?></h1>
  <p>
   <?php echo get_vocab("norights")?>
  </p>
  <p>
  If you would like to make room bookings then you should contact <a href="mailto:rooms@your.place">rooms@your.place</a>.</p>
  <p>
    <a href="<?php echo htmlspecialchars($HTTP_REFERER); ?>">
      <?php echo get_vocab("returnprev"); ?>
    </a>
  </p>
<?php
  // Print footer and exit
  print_footer(TRUE);
}
?>
