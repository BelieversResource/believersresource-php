<?php

	define('CURRENT_TS',time());

	require_once('inc/init.inc.php');

  $strRoute = strtolower((isset($_GET['route'])) ? $_GET['route'] : 'home');

  $aryRoutes = explode('/',$strRoute);
  $aryQS = array();              

//echo '<pre><tt>';
//var_dump($aryRoutes);

  // KNOWN ROUTES ARE SET UP SO THAT THERE NEED NOT BE A BUNCH OF FILE SYSTEM CALLS
  $aryKnownRoutes = array(
  	'home',
  	'about-us',
  	'downloads',
  );
  $strRoute = FALSE;  
  while (count($aryRoutes)>0) {
  	$strRoute = implode('/',$aryRoutes);
  	if (in_array($strRoute,$aryKnownRoutes)) {
  		break;
  	}
  	$strRoute .= '/default';
  	if (in_array($strRoute,$aryKnownRoutes)) {
  		break;
  	}
  	$thisQS = array_pop($aryRoutes);
  	if ($thisQS != '') {  // Needed for if they have the trailing slash
			array_unshift($aryQS,$thisQS);
		}
  }

//var_dump($strRoute,$aryQS);
//die();

  if ($strRoute===FALSE || !is_file(PAGES_PATH.$strRoute.'.php')) {
		header("HTTP/1.0 404 Not Found");
    if (preg_match('/\.(jpg|gif|png|js|css|ico)$/i',$_GET['route'])) {
			die ('ERROR 404: File Not Found');
    }
		$strRoute = 'errors/404';
  }
  if (!is_file(PAGES_PATH.$strRoute.'.php')) {
		die ('ERROR: File Not Found [Missing 404 Directive]');
  }

  $strParentTemplate = FALSE;
	require_once(PAGES_PATH.$strRoute.'.php');
	$intLooper = 20;
	while ((--$intLooper>0) && $strParentTemplate) {
		require_once(TEMPLATES_PATH.$strParentTemplate.'.phtml');
  }

// EOF: ~/index.php




