<?php

// THIS IS A SAMPLE FILE. Need to set values and save to init.inc.php
// This file will most likely get streamlined as the project goes on...

if (!defined('CURRENT_TS')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

session_start();

date_default_timezone_set('America/New_York');
if (!isset($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST'] =='') { $_SERVER['HTTP_HOST'] = 'localrun.cli'; }

define ('SYSTEM_NAME_RAW',        'Believers Resource'); // THIS WILL BE THE NAME OF THE SYSTEM TO DISPLAY EVERYWHERE AS IS
define ('SYSTEM_NAME_HTML',       'Believers Resource'); // THIS WILL BE THE NAME OF THE SYSTEM TO DISPLAY WITH ENTITIES (ie. &reg;)
define ('EMAIL_GENERAL',          'some@email.add'); // THIS WILL GET USED FOR MOST RETURN ADDRESSES
define ('EMAIL_SUPPORT',          'some@email.add'); // AS INDICATED

// These need to be the same between LIVE/DEV so that data can be pulled back to dev to test.
define ('STORE_KEY',              'v30vj03v0evn85812045vqf4'); // Used as Key for DB encrypt
define ('SITE_SALT',              'gf3jf4549jutrmtf03f4ut3f'); // Used as Salt for PW's
define ('KEY_CALC_1',             27); // Multiplier & low rand for int2key/key2int (suggest between 2 and 40)
define ('KEY_CALC_2',             10001); // Adder & high rand for int2key/key2int  (anything higher that KEY_CALC_1)

define ('GOOGLE_ANALYTICS_ID',    'UA-#######-#');

define ('REL_API_URL',            '/api/');
define ('REL_MEDIA_URL',          '/media/');
define ('REL_ACT_ADMIN_URL',      '/account/');
define ('REL_SITE_ADMIN_URL',     '/manage/');

$aryDB = array();
define('DEV_SITE',($_SERVER['HTTP_HOST']=='dev.believersresource.com')); // triggers dev site based upon host
if (!DEV_SITE) {
  define ('SSL_SITE_URL',    'https://'.$_SERVER['HTTP_HOST']);  // May not be needed for this project
  define ('DEBUG_MODE',      FALSE); // Does more error dumping
  error_reporting(-1);
  $aryDB['DB_SERVER'] =      'localhost'; // mysql server location
  $aryDB['DB_DATABASE'] =    'db_name'; // mysql database
  $aryDB['DB_USER'] =        'db_user'; // mysql user name
  $aryDB['DB_PASS'] =        'db_path'; // mySQL user password
  define ('CACHE_DIR', realpath($_SERVER['DOCUMENT_ROOT'].'/../live_cache').'/');  // location of writable directory for caching
} else {
  define ('SSL_SITE_URL',    'http://'.$_SERVER['HTTP_HOST']); // May not be needed for this project
  define ('DEBUG_MODE',      TRUE); // Does more error dumping
  error_reporting(-1);
  $aryDB['DB_SERVER'] =      'localhost'; // mysql server location
  $aryDB['DB_DATABASE'] =    'db_name'; // mysql database
  $aryDB['DB_USER'] =        'db_user'; // mysql user name
  $aryDB['DB_PASS'] =        'db_path'; // mySQL user password
  define ('CACHE_DIR', realpath($_SERVER['DOCUMENT_ROOT'].'/../dev_cache').'/');   // location of writable directory for caching
}
define ('DB_MODE',        'mysqli'); // ONLY mysqli is supported at this time for this project
define ('DB_PREFIX',      ''); // Optional prefix for database

// SOme of these may not be needed for this project and may be removed in future updates
define ('ROOT_PATH',        $_SERVER['DOCUMENT_ROOT'].'/');
define ('API_PATH',         $_SERVER['DOCUMENT_ROOT'].REL_API_URL);
define ('MEDIA_PATH',       $_SERVER['DOCUMENT_ROOT'].REL_MEDIA_URL);
define ('INC_PATH',         $_SERVER['DOCUMENT_ROOT'].'/inc/');
define ('PAGES_PATH',       $_SERVER['DOCUMENT_ROOT'].'/pages/');
define ('MODULES_PATH',     $_SERVER['DOCUMENT_ROOT'].'/modules/');
define ('TEMPLATES_PATH',   $_SERVER['DOCUMENT_ROOT'].'/templates/');
define ('ACT_ADMIN_PATH',   $_SERVER['DOCUMENT_ROOT'].REL_ACT_ADMIN_URL);
define ('SITE_ADMIN_PATH',  $_SERVER['DOCUMENT_ROOT'].REL_SITE_ADMIN_URL);

// DEV SITE BANNER OUTPUT
function debugOutput() {
  if (DEV_SITE) {
    echo '<div style="position: fixed; top: 0px; right: 0px; padding 0 20px: height: 18px; background-color:#f00; color: #ff0; text-align: center">DEV SITE</div>';
    
    // Add any other debug output you want here
  }
}


// Some of these may not be needed for this project and may be removed in future updates

// BEGIN: USER LEVELS
  define('UL_SITE_MASTER',     255); // VERY TOP
  define('UL_SITE_ADMIN',      250); // MOST AT COMPANY
  define('UL_SITE_REPORTS',    200); // JUST FOR VIEWING REPORTS
  define('UL_ACCT_MASTER',     150); // VERY TOP FOR A CLIET - ONLY ONE, THE PERSON WHO CONTROLS
  define('UL_ACCT_ADMIN',      100); // CAN MANAGE EVERYONE UNDER
  define('UL_ACCT_REPORTS',     75); // JUST FOR VIEWING CLIENT REPORTS
  define('UL_ACCT_USER',        50); // REGULAR CLIENT USER (ie. Service Tech)
  define('UL_ACCT_DISABLED',    20); // This account not set to access system
  define('UL_GUEST_USER',       10); // A SUBSCRIBER (NOT CLIENT), IE END CUSTOMER
  define('UL_GUEST_DISABLED',    5);  // DISABLED SUBSCRIBER
  define('UL_ANYBODY',           0); // DEFAULT VALUE

  $aryUserLevelNames = array(0=>'Guest',
                             5=>'Disabled Subscriber',
                             10=>'Subscriber',
                             20=>'Disabled Account',
                             50=>'Regular Account',
                             75=>'Reports Account',
                             100=>'Account Manager',
                             150=>'Acount Owner',
                             200=>'System Reports Account',
                             250=>'System Regular Account',
                             255=>'System Master Account');

// END: USER LEVELS

$aryData = array();
$aryErr = array();
$aryList = array();
$aryUser = array();
$aryTPL = array('title'=>SYSTEM_NAME_RAW,'header'=>'','content'=>'page error','footer'=>'');
$arySlug = array();


if (!defined('NO_LOAD_FUNCTIONS'))  { require_once(INC_PATH.'functions.inc.php'); }
if (!defined('NO_LOAD_CACHE'))      { require_once(INC_PATH.'cache.inc.php'); }
if (!defined('NO_LOAD_DATABASE'))   { require_once(INC_PATH.'database_'.DB_MODE.'.inc.php'); }
unset($aryDB);

// EOF: ~/inc/init.inc.php