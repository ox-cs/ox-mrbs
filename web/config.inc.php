<?php

// $Id: config.inc.php 1240 2009-11-04 16:01:21Z cimorrison $

/**************************************************************************
 *   MRBS Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file
 *   (except for the lang.* files, eg lang.en for English, if
 *   you want to change text strings such as "Meeting Room
 *   Booking System", "room" and "area").
 **************************************************************************/

// The timezone your meeting rooms run in. It is especially important
// to set this if you're using PHP 5 on Linux. In this configuration
// if you don't, meetings in a different DST than you are currently
// in are offset by the DST offset incorrectly.
//
// When upgrading an existing installation, this should be set to the
// timezone the web server runs in.
//
//$timezone = "Europe/London";
$timezone = "GMT";

/*******************
 * Database settings
 ******************/
// Which database system: "pgsql"=PostgreSQL, "mysql"=MySQL,
// "mysqli"=MySQL via the mysqli PHP extension
$dbsys = "mysql";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP.
$db_host = "localhost";
// Database name:
$db_database = "mrbs";
// Database login user name:
$db_login = "mrbs";
// Database login password:
$db_password = '';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "mrbs_";
// Uncomment this to NOT use PHP persistent (pooled) database connections:
//$db_nopersist = 1;


/* Add lines from systemdefaults.inc.php here to change the default
   configuration. Do _NOT_ modify systemdefaults.inc.php. */

/*********************************
 * Site identification information
 *********************************/
$mrbs_admin = "CS ";
$mrbs_admin_email = "website@your.place";  // NOTE:  there are more email addresses in $mail_settings below

// The company name is mandatory.   It is used in the header and also for email notifications.
// The company logo, additional information and URL are all optional.

$mrbs_company = "Department, Organisation";   // This line must always be uncommented ($mrbs_company is used in various places)

// Uncomment this next line to use a logo instead of text for your organisation in the header
//$mrbs_company_logo = "your_logo.gif";    // name of your logo file.   This example assumes it is in the MRBS directory

// Uncomment this next line for supplementary information after your company name or logo
//$mrbs_company_more_info = "You can put additional information here";  // e.g. "XYZ Department"

// Uncomment this next line to have a link to your organisation in the header
$mrbs_company_url = "http://www.your.site/";

// This is to fix URL problems when using a proxy in the environment.
// If links inside MRBS appear broken, then specify here the URL of
// your MRBS root directory, as seen by the users. For example:
// $url_base =  "http://webtools.uab.ericsson.se/oam";
// It is also recommended that you set this if you intend to use email
// notifications, to ensure that the correct URL is displayed in the
// notification.
$url_base = "";

// This next section must come at the end of the config file - ie after any
// language and mail settings, as the definitions are used in the included file
require_once "language.inc";   // DO NOT DELETE THIS LINE


/***********************************************
 * Authentication settings - read AUTHENTICATION
 ***********************************************/

$auth["session"] = "remote_user"; //= "php"; // How to get and keep the user ID. One of
           // "http" "php" "cookie" "ip" "host" "nt" "omni"
           // "remote_user"

$auth["type"] = "webauth";//"config"; // How to validate the user/password. One of "none"
                          // "config" "db" "db_ext" "pop3" "imap" "ldap" "nis"
                          // "nw" "ext".

// The list of administrators (can modify other peoples settings)


// Webauth admin user can read/write/overwrite bookings and add rooms
// these are lists of administrators who can made room bookings
// they are sso usernames

$auth["admin"][] = "ssousername1"; 
$auth["admin"][] = "ssousername2";
$auth["admin"][] = "addsupportusername3";


// If required for three access levels
// 'auth_webauth' level 1 user database
//$auth["mortal"][] = "abcd2345"; // Webauth user can read/write their own bookings
//$auth["mortal"][] = "abcd3456"; // Another Webauth user

// Everyone else has view access


// 'session_remote_user' configuration settings
$auth['remote_user']['logout_link'] = './logout/index.html';


/*************
 * Entry Types
 *************/

// This array maps entry type codes (letters A through J) into descriptions.
//
// Each type has a color which is defined in the array $color_types in the Themes
// directory - just edit whichever include file corresponds to the theme you
// have chosen in the config settings. (The default is default.inc, unsurprisingly!)
//
// The value for each type is a short (one word is best) description of the
// type. The values must be escaped for HTML output ("R&amp;D").
// Please leave I and E alone for compatibility.
// If a type's entry is unset or empty, that type is not defined; it will not
// be shown in the day view color-key, and not offered in the type selector
// for new or edited entries.

$typel["A"] = "Seminar";
$typel["B"] = "Lecture";
$typel["C"] = "Practical";
$typel["D"] = "Class";
$typel["E"] = get_vocab("external");
$typel["F"] = "Open Day";
$typel["G"] = "Other";
$typel["H"] = "Committee";
$typel["I"] = get_vocab("internal");
$typel["J"] = "Examiners";
$typel["K"] = "Viva";

?>
