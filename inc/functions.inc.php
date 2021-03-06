<?php

if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

function outputModule($strModule,$aryParams = FALSE) {
	echo getModule($strModule,$aryParams);
}

function getModule($strModule,$aryParams = FALSE) {

	if (file_exists(MODULES_PATH.$strModule.'.php')) {
		require_once(MODULES_PATH.$strModule.'.php');
		$strModule = 'return'.$strModule;
		return $strModule($aryParams);
	}
	else {
		return '[ERR:Missing Module Control('.$strModule.')]';
	}
}

function getSlugID($strModule,$strSlug) {
	global $arySlug;
	if (file_exists(MODULES_PATH.$strModule.'.php')) {
		require_once(MODULES_PATH.$strModule.'.php');
		return (array_key_exists($strSlug,$arySlug) && $arySlug[$strSlug]['module']==$strModule) ? $arySlug[$strSlug]['pk'] : FALSE;
	}	
	else {
		return '[ERR:Missing Module Control('.$strModule.')]';
	}
}

function getBreadTrail($strModule,$intID) {
	require_once(MODULES_PATH.'Categories.php');
	$aryBT =  getBreadTrailArray($strModule,$intID);
	$strBT = '';
	if ($aryBT) {
		$bFirst = TRUE;
		foreach($aryBT as $bt) {
			if (!$bFirst) {
				$strBT .= ' &gt; ';
			}
			$strBT .= '<a href="'.$bt['link'].'">'.getHSC($bt['text']).'</a>';
			$bFirst = FALSE;
		}
	}
	return $strBT;
}

/**
 * Convert integer PK over to a non-numeric key for use in public view
 *
 * @param integer $intNum The unsigned integer to convert to a key
 * @param integer $intPad Number of padding sections at end (default=0)
 * @return string Non-numeric key
 */
function int2key($intNum,$intPad=0) {
	$intRandomKey = mt_rand(KEY_CALC_1,KEY_CALC_2);
	$intNum = $intNum * KEY_CALC_1 + KEY_CALC_2 + $intRandomKey;
	$intFlipper = ($intRandomKey%26)+65;
	$strKey = trim(base64_encode(strrev(dechex($intRandomKey).'O'.dechex($intNum))),'=');
	$strKey = chr($intFlipper).(($intFlipper % 2) ? $strKey : strrev($strKey));
	if ($intPad>0) { $strKey .= '-'.int2key($intRandomKey,$intPad-1); }
	return $strKey;
}

/**
 * Convert a non-numeric key used in public view over to integer PK value
 *
 * @param string $strKey the key already generated by int2key()
 * @return mixed Either the integer PK value or FALSE if it doesn't process
 */
function key2int($strKey) {
	if (!preg_match('/^([a-z0-9]+)(-[a-z0-9]+)*$/i', $strKey,$regs)) { return FALSE; }
	$strFlipper = substr($regs[1],0,1);
	if ($strFlipper < 'A' || $strFlipper > 'Z') { return FALSE; }
	$strKey = substr($regs[1],1);
	if (ord($strFlipper)%2==0) { $strKey = strrev($strKey); }
	$strKey = strrev(base64_decode($strKey));
	if (!preg_match('/^([0-9a-z]+)O([0-9a-z]+)$/',$strKey,$parts)) { return FALSE; }
	$intNum = (hexdec($parts[2]) - hexdec($parts[1]) - KEY_CALC_2) / KEY_CALC_1;
	if ((int)$intNum != $intNum) { return FALSE; }
	return (int)$intNum;
}

/**
 * Echos out given text wrapped with htmlspecialchars() mainly for variable outputs in middle of HTML
 *
 * @param string $strText The text to output
 */
function echoHSC($strText) {
	echo htmlspecialchars($strText,ENT_QUOTES);
}

/**
 * Returns given text wrapped with htmlspecialchars() and trim() mainly for variable outputs in middle of HTML
 *
 * @param string $strText The text to output
 * @return string
 */
function getHSC($s) {
	return trim(htmlspecialchars($s,ENT_QUOTES));
}


// EOF: ~/inc/functions.inc.php
