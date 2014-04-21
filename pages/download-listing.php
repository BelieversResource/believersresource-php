<?php

	/**
	*  Download listing page handler, this is the handler for listing a file for download
	*/

  if (!defined('CURRENT_TS')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

  
$strBreadTrail = getBreadTrail('download',$aryFile['category_id']);
$aryLinks = readDBcache('SELECT `id`,`link_type`,`name`,`url`,`votes` FROM `~PREFIX~links` WHERE `content_type`="download" AND `content_id`='.$intFileID.' AND `status`="active" ORDER BY `disp_order` ASC',TRUE);

// ==== START VIEW ====

$strParentTemplate = 'TwoColumn';

$aryTPL['Title'] = $aryFile['title'].' - Downloads from Believers Resource';


ob_start(); // ================================== BEGIN: LeftColumn ?>

<div class="heading">
	<div class="heading-holder">
		<?php echo $strBreadTrail; ?>
		<h2><?php echoHSC($aryFile['title']); ?></h2>
		<p><?php echoHSC($aryFile['short_description']); ?></p>
		<br />
	</div>
</div>
<div id="content">
	<div class="content-holder">
    <div class="block">
      <div class="downloadRight" style="float:right;width:130px;">
        <table><tr><td><b>Votes:</b></td><td><div id="v_download_8" class="voteHolder info">24</div></tr></table>
      </div>
      <h3>Additional Details</h3>
      <p><?php echoHSC($aryFile['description']); ?></p>
      <div class="disclaimer">In general the resources we list are free for both individuals and churches to use, but always check the source for any specific restrictions.</div>
    </div>
    <?php outputModule('DisplayComments',array('ParentID'=>$intFileID)); ?>
	</div>
</div>

<?php $aryTPL['LeftColumn'] = ob_get_clean(); // === END: LeftColumn


ob_start(); // ================================== BEGIN: RightColumn ?>

	<div class="block-context">
		<div class="holder">
			<div class="frame">
				<div class="heading">
					<h2><img src="/img/ico5.gif" width="21" height="24" alt="downloads" />Links</h2>
				</div>
				<ul class="related-list">
					<?php foreach($aryLinks as $id => $data): ?>
						<?php if ($data['link_type']=='download'): ?>
							<li><a href="/tracklink/<?php echo int2key($id); ?>" ><?php echoHSC($data['name']); ?></a></li>
						<?php else: ?>
							<li><a href="<?php echo $data['url']; ?>" onclick="recordOutboundClick(this,'source');" target="_blank" ><?php echoHSC($data['name']); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<span class="arrow">arrow</span>
	</div>
	<?php outputModule('RelatedPhotos'); ?>
	<?php outputModule('RelatedTopics'); ?>

<?php $aryTPL['RightColumn'] = ob_get_clean(); // === END: RightColumn

// EOF: ~/pages/download-listings.php