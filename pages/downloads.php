<?php

	/**
	*  Download page handler, this is the handler download section
	*/

  if (!defined('CURRENT_TS')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

  
if (count($aryQS)>0) {
	
	$strSlug = array_pop($aryQS);
	if (count($aryQS)>0 && preg_match('/^([a-z0-9-]+)_(\d+)$/',$strSlug,$parts)) {
		$strSlug = $parts[1];
		$intFileID = (int)$parts[2];
		
		$aryFile = readDBcache('SELECT * FROM `~PREFIX~downloads` WHERE `url`='.escapeString($strSlug).' AND `id`='.$intFileID.' AND `status`="active" LIMIT 1',FALSE,1);
		if (count($aryFile)==0) {
			header("HTTP/1.0 404 Not Found");
		  if (!is_file(PAGES_PATH.'errors/404.php')) {
				die ('ERROR: File Not Found [Missing 404 Directive]');
			}
			require_once(PAGES_PATH.'errors/404.php');
			return; // Kick back to INDEX.PHP
		}
		
		// We have a good file available, tell it to use the download-listing handler
		require_once(PAGES_PATH.'download-listing.php');
		return; // Kick back to INDEX.PHP
	}
	else {
		$intThisCatID = getSlugID('DownloadCategories',$strSlug);
		$strTitle = $datCategories['download'][$intThisCatID]['name'] . ' Downloads';
		$strH2 = $datCategories['download'][$intThisCatID]['name'];
		$strDescription = getHSC($datCategories['download'][$intThisCatID]['description']);

		$strBaseLink = '/';
		$aryBreadTrail = array();
		
		foreach($datCategories['download'][$intThisCatID]['tree'] as $id) {
			$strBaseLink .= $datCategories['download'][$id]['slug'].'/';
			$aryBreadTrail[] = '<a href="'.$strBaseLink.'">'.getHSC($datCategories['download'][$id]['name']).'</a>';
		}
		$strBaseLink .= $datCategories['download'][$intThisCatID]['slug'].'/';
		$strBreadTrail = implode(' &gt; ',$aryBreadTrail);
	}
                       		
}
else {
	$intThisCatID = 0; 
	$strBreadTrail = '';
	$strBaseLink = '/downloads/';
	$strTitle = 'Christian Downloads';
	$strH2 = 'Downloads';
	$strDescription = 'This section contains Christian resources that are free for both churches and 
			individuals to use. If you know of a quality free Christian resource please take a moment to
			<a href="/downloads/editdownload.aspx" onclick="return verifyLoggedIn();">submit it</a>.';
}




// ==== START VIEW ====

$strParentTemplate = 'TwoColumn';

$aryTPL['Title'] = $strTitle . ' - Believers Resource';


ob_start(); // ================================== BEGIN: LeftColumn ?>

<div class="heading">
	<div class="heading-holder">
		<?php echo $strBreadTrail; ?>
		<h2><?php echoHSC($strH2); ?></h2>
		<p><?php echo $strDescription; ?></p>
		<br />
	</div>
</div>
<div id="content">
	<div class="content-holder">
  	<?php outputModule('DownloadCategories',array('ParentID'=>$intThisCatID,'BaseLink'=>$strBaseLink)); ?>
  	<?php outputModule('DownloadFiles',array('ParentID'=>$intThisCatID,'BaseLink'=>$strBaseLink)); ?>
	</div>
</div>

<?php $aryTPL['LeftColumn'] = ob_get_clean(); // === END: LeftColumn


ob_start(); // ================================== BEGIN: RightColumn ?>

	<?php outputModule('DownloadsSubmitButton'); ?>
	<?php if ($intThisCatID == 0) { outputModule('PopularDownloads'); } ?>

<?php $aryTPL['RightColumn'] = ob_get_clean(); // === END: RightColumn

// EOF: ~/pages/downloads.html