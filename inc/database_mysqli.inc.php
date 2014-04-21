<?php

/**
*
*  DATABASE FUNCTIONS - mysqli
*
*  These are the functions for dealing with the database calls
*
*/

if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

$GLOBALS['SqlCount'] = 0;

$DB = new mysqli($aryDB['DB_SERVER'],$aryDB['DB_USER'],$aryDB['DB_PASS'],$aryDB['DB_DATABASE']);
if ($DB->connect_errno) {
	if (DEBUG_MODE) {
		die ('ERR['.__LINE__.'] Failed to connect to MySQL: ('.$DB->connect_errno.') '.$DB->connect_error."\n");
	}	else {
		die('ERR['.__LINE__."] Could not establish connection with database server\n");
	}
}

unset($aryDB); // Clear so nothing else can use it

/**
 * Executes a SQL statement to either INSERT or UPDATE the database.
 * The statement can use ~PREFIX~ to represent table prefix and
 * ~ID~ for the Client Service ID and they will be auto converted
 *
 * @param string $strSQL The SQL String to execute
 * @return mixed Upon success, either Last Insert ID or the Number Updated rows. False on failure
 */
function writeDbSQL($strSQL) {
	global $DB;

	$SQL = str_replace('~PREFIX~',DB_PREFIX,trim($strSQL));
	//mail('greg@twinedev.net','Debug Info',__LINE__." IN FILE: ".__FILE__."\n\nSQL: \n\n $SQL \n\n".print_r($_SERVER,TRUE)."\nDEBUG BACKTRACE:\n".print_r(debug_backtrace(),TRUE));
	$rs = $DB->query($SQL)
					or die('ERR['.__LINE__.'] Invalid Query Called.'.((DEBUG_MODE)?' SQL: '.htmlspecialchars($SQL,ENT_QUOTES) : ''));
	if (strtolower(substr($SQL,0,7))=='insert ') {
		return $DB->insert_id;
	}
	else {
		return $DB->affected_rows;
	}
}

/**
* Returns a matched SQL Insert Field/Values code from a given array. handles Escaping and NULL values
*
* @param string $strTable Name of tabel to write to WITHOUT ~PREFIX~
* @param array $aryData The data to use to make the set
* @param int $intKey If doing an update, the Primary Key of existing data
* @return mixed Upon success, either Last Insert ID or the Number Updated rows. False on failure
*/
function writeDbArray($strTable,$aryData,$intKey=0,$strPKname=FALSE) {
	if ($intKey==0) {
		// Doing an insert
		$SQL1 = 'INSERT INTO `~PREFIX~'.$strTable.'` (';
		$SQL2 = ') VALUES (';
		foreach($aryData as $key=>$val) {
			$SQL1 .= '`'.$key.'`,';
			if (is_null($val) || $val===FALSE) {
				switch ($key) {
					case 'tsCreate':
					case 'tsEdit':
					case 'tsLast':
						$SQL2 .= 'NOW(),';
						break;
					case 'ipCreate':
					case 'ipEdit':
					case 'ipLast':
						$SQL2 .= '"'.(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'CLI').'",';
						break;
					default:
						$SQL2 .= 'NULL,';
				}
			}
			else {
				$SQL2 .= escapeString($val).',';
			}
		}
		$SQL = substr($SQL1,0,-1).substr($SQL2,0,-1).')';

	}
	else {
		// Doing an update

		$SQL = 'UPDATE `~PREFIX~'.$strTable.'` SET ';
		foreach($aryData as $key=>$val) {
			if (is_null($val) || $val===FALSE) {
				switch ($key) {
					case 'tsEdit':
					case 'tsLast':
						$SQL .= '`'.$key.'`=NOW(),';
						break;
					case 'ipEdit':
					case 'ipLast':
						$SQL .= '`'.$key.'`="'.(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'CLI').'",';
						break;
					case 'tsCreate':
					case 'ipCreate':
						// These do not get touched on an update, so don't even add them to SQL
						break;
					default:
						$SQL .= '`'.$key.'`=NULL,';
				}
			}
			else {
				$SQL .= '`'.$key.'`=' . escapeString($val).',';
			}
		}
		if ($strPKname) {
			$SQL = substr($SQL,0,-1) . ' WHERE `'.$strPKname.'` = '.(int)$intKey;
		}
		else {
			$SQL = substr($SQL,0,-1) . ' WHERE `'.table2pk($strTable).'` = '.(int)$intKey;
		}
	}
	//mail('greg@twinedev.net','Debug Info',__LINE__." IN FILE: ".__FILE__."\n\nWriting PK: $intKey TO $strTable \n\n$SQL");

	return writeDbSQL($SQL);
}

/**
* Converts a table name (my_table) over to a PrimaryKey Field for it (MyTableID)
*
* @param string $strTable The name of table working on withOUT ~PREFIX~
* @return string The PrimaryKey Field
*/
function table2pk($strTable) {
	$strPK = '';
	$aryParts = explode('_',$strTable);
	foreach($aryParts as $val) { $strPK .= ucfirst($val); }
	return $strPK . 'ID';
}


/**
 * Live execute a SQL statement to retrieve data from database.
 * The statement can use ~PREFIX~ to represent table prefix and
 * ~ID~ for the Client Service ID and they will be auto converted
 *
 * @param string $strSQL The SQL statement
 * @param boolean $bKeyFirstField If TRUE, use first field in each row as array index value
 * @param integer $intMaxRows Maximun number of rows to retrieve in the loop, 0 = unlimited
 * @return array The data from the $SQL statement.
 */
function readDBlive($strSQL,$bKeyFirstField=FALSE,$intMaxRows=0){
	global $DB;
	
	$SQL = str_replace('~PREFIX~',DB_PREFIX,$strSQL);
	$rs = $DB->query($SQL)
		or die('ERR['.__LINE__.'] Invalid Query Called.'.((DEBUG_MODE)?' SQL: '.htmlspecialchars($SQL,ENT_QUOTES) : ''));
	$aryReturn = array();
	$intRowCount = 0;
	if ($rs->num_rows > 0) {
		while (($intMaxRows==0 || $intRowCount<$intMaxRows) && $aryTemp = $rs->fetch_assoc()) {
			if ($bKeyFirstField) {
				// We want to use the first field as the key for the array...
				$key = array_shift($aryTemp);
				$aryReturn[$key] = $aryTemp;
			}
			else {
				$aryReturn[] = $aryTemp;
			}
			$intRowCount++;
		}
		unset($aryTemp,$key);
		$rs->free();
	}
	unset($rs);
	if (!$bKeyFirstField && $intMaxRows==1 && count($aryReturn)>0) {
		return $aryReturn[0];
	}
	return $aryReturn;
}

/**
 * Loads up data for SQL statement from cached copy if exists, if not, builds fresh
 * cache by calling readDBlive() passing all parameters.
 *
 * @param string $strSQL The SQL statement
 * @param boolean $bKeyFirstField If TRUE, use first field in each row as array index value
 * @param integer $intMaxRows Maximun number of rows to retrieve in the loop, 0 = unlimited
 * @return array The data from the $SQL statement.
 */
function readDBcache($strSQL,$bKeyFirstField=FALSE,$intMaxRows=0){

	require_once(INC_PATH.'cache.inc.php');

	$strSQL = trim(preg_replace('/[\n\r]+/',' ',$strSQL)); // Makes sure that when writen to cache file, it is only one line.
	$aryReturn = cacheCheck($strSQL,(($bKeyFirstField)?'_I_':'_U_').$intMaxRows);

	if (DEV_SITE || $aryReturn==NO_CACHE) {
		$aryReturn = readDBlive($strSQL,$bKeyFirstField,$intMaxRows);
		cacheWrite($aryReturn,$strSQL,(($bKeyFirstField)?'_I_':'_U_').$intMaxRows);
	}
	return $aryReturn;
}

/**
 * Escapes out the value from $aryData for use in SQL  or NULL is value is NULL
 *
 * @param string $strValue The key for $aryData
 * @return string escaped string for SQL use (or NULL)
 */
function escapeData($strField) {
	global $aryData,$DB;
	return (is_null($aryData[$strField]) || $aryData[$strField]===FALSE) ? 'NULL' : '"'.$DB->real_escape_string($aryData[$strField]).'"';
}

/**
 * Escapes out the value of the string passed use in SQL or NULL is value is NULL
 *
 * @param string $strData The data to escape
 * @return string escaped string for SQL use (or NULL)
 */
function escapeString($strData) {
	global $aryData,$DB;
	return (is_null($strData) || $strData===FALSE) ? 'NULL' : '"'.$DB->real_escape_string($strData).'"';
}

// EOF: ~/inc/database_mysqli.inc.php