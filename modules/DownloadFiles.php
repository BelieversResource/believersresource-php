<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

	global $datDownloadFiles;

	$datDownloadFiles = array();
	
	function loadFiles($intCatID) {
		global $datDownloadFiles;
		
		if (!array_key_exists($intCatID,$datDownloadFiles)) {
			$datDownloadFiles[$intCatID] = readDBcache('SELECT `id`,`title`,`url`,`votes`,`short_description` FROM `~PREFIX~downloads` WHERE `status`="active" AND `category_id`='.$intCatID.' ORDER BY `disp_order` ASC',TRUE);
		}
	}
	
	

	function returnDownloadFiles($aryParams = FALSE) {
		global $datDownloadFiles;
		
		loadFiles($aryParams['ParentID']);

		$evenOdd = array('',' class="grey"');
		$eo = 0;

ob_start(); ?>

<?php if(count($datDownloadFiles[$aryParams['ParentID']])>0): ?>
	<div class="block">
		<h3>Downloads</h3>
		<ul class="post">
			<?php $eo = 0; foreach($datDownloadFiles[$aryParams['ParentID']] as $intFileID=>$fileData): ?>
				<li <?php echo $evenOdd[$eo]; ?> >
					<div id="v_download_<?php echo $intFileID; ?>" class="voteHolder info"><?php echo $fileData['votes']; ?></div>
					<div class="description">
						<p>
							<a href="<?php echo $aryParams['BaseLink'].$fileData['url'].'_'.$intFileID; ?>"><?php echoHSC($fileData['title']); ?></a> - <?php echoHSC($fileData['short_description']); ?>
						</p>
					</div>
				</li>
			<?php $eo = abs($eo-1); endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<?php 

		return ob_get_clean();
	}