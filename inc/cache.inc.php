<?php

/**
*
*	 CACHING FUNCTIONS
*
*  This file contains the functions for handling caching of data and information that will
*  be called often to reduce load on database lookups
*
*/

if (!defined('CURRENT_TS')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

define ('NO_CACHE','[~~NO~~CACHE~~]');
define ('CACHE_LIFETIME',	86400); // 24 Hours ( 24 * 60 * 60 )

/**
 * Checks to see if Cache exists, if so, returns is, otherwise, returns NO_CACHE constant
 *
 * @param string $strName The name of the cache info (usually the SQL statement)
 * @param string $strSuffix Optional suffix to add to cache filename
 * @return mixed  Either the data from the cache file or the NO_CACHE constant
 */
function cacheCheck($strName,$strSuffix='') {
	$strCacheFile = md5($strName).'_'.md5(base64_encode($strName)).preg_replace('/[^-_0-9a-z]/i','',$strSuffix);
	if (!DEBUG_MODE && file_exists(CACHE_DIR.$strCacheFile) && filemtime(CACHE_DIR.$strCacheFile)+CACHE_LIFETIME >= time()) {
		$aryCache = file(CACHE_DIR.$strCacheFile);
		if ($aryCache && $strName."\n" == $aryCache[0]) {
			// It found a file and a matched query
			array_shift($aryCache); // Gets rid of CacheName
			array_shift($aryCache); // Gets rid of blank separator line
			return unserialize(implode('',$aryCache));
		}
	}
	return NO_CACHE;
}

/**
 * Writes data out to cache file.
 *
 * @param array $aryData The data to write
 * @param string $strName The name of the cache info (usually the SQL statement)
 * @param string $strSuffix Optional suffix to add to cache filename
 */
function cacheWrite($aryData,$strName,$strSuffix='') {
	$strCacheFile = '_'.md5($strName).'_'.md5(base64_encode($strName)).preg_replace('/[^-_0-9a-z]/i','',$strSuffix);
	$fp = fopen(CACHE_DIR.$strCacheFile,'w');
	fwrite($fp,$strName."\n\n");
	fwrite($fp,serialize($aryData));
	fclose($fp);
	unset($fp);
}

// FUNCTION clearCache($strExtra=NULL)  IS LOCATED WITHIN FUNCTIONS.PHP

// EOF: ~/inc/cache.inc.php