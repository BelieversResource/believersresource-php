<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

	global $arySlug,$datCategories;

	$datCategories = array();

	function loadCatLevel($strRootModule,$intParentID=0,$aryTree=array()) {	
		global $arySlug,$datCategories;
		
		$aryTree[] = $intParentID;
		$aryCategories = readDBcache('SELECT * FROM `~PREFIX~categories` WHERE `category_type`="'.$strRootModule.'" AND `parent_id`='.$intParentID.' ORDER BY `disp_order` ASC',TRUE);
		if (count($aryCategories) > 0) {
			foreach($aryCategories as $pk => $data) {
				$arySlug[$data['url']] = array('module'=>'DownloadCategories','pk'=>$pk);
				$datCategories[$strRootModule][$pk] = array('name'=>$data['name'],'description'=>$data['description'],'slug'=>$data['url'],'tree'=>$aryTree,'children'=>loadCatLevel($strRootModule,$pk,$aryTree));
				if (count($datCategories[$strRootModule][$pk]['children'])==0) { $datCategories[$strRootModule][$pk]['children'] = FALSE; }
			}
		}
		return array_keys($aryCategories);
	}

	function loadCategories($strModule,$strSlug='',$strName='') {
		global $datCategories;
		if ($strSlug=='') { $strSlug = $strModule.'s'; }
		if ($strName=='') { $strName = $strModule.'s'; }
		if (!array_key_exists($strModule,$datCategories)) {
			$datCategories[$strModule][0] = array('name'=>ucfirst($strName),'slug'=>$strSlug,'children'=>loadCatLevel('download',0));
			ksort($datCategories[$strModule]);
		}
		
	}
	
	function getBreadTrailArray($strModule,$intID) {
		global $datCategories;
		
		loadCategories($strModule);
		
		$strBaseLink = '/';
		$aryBT = array();
		foreach($datCategories[$strModule][$intID]['tree'] as $id) {
			$strBaseLink .= $datCategories[$strModule][$id]['slug'].'/';
			$aryBT[] = array('link'=>$strBaseLink,'text'=>$datCategories[$strModule][$id]['name']);
		}
		return $aryBT;
	}
	
