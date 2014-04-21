<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


global $datPopularDownloads;


// This will be replaced by code to load in from database. Using sample data for now

// Keep in mind, possible update to the site will be to allow this list based upon "current" category

function loadPopularDownloads() {	
	$datPopularDownloads = array(  /* Slug => Name */);
	$aryDownloads = readDBcache('select * from downloads order by votes desc limit 10',TRUE);
	if (count($aryDownloads) > 0) {
		foreach($aryDownloads as $pk => $data) {
      $datPopularDownloads[$data['url']] = $data['title'];
		}
	}
  return $datPopularDownloads;
}

$datPopularDownloads = loadPopularDownloads();

function returnPopularDownloads($aryParams = FALSE) {
	global $datPopularDownloads;
ob_start(); ?>
<div class="block block1">
	<div class="block-holder">
		<div class="block-frame">
			<div class="heading">
				<h2><img src="/img/ico5.gif" width="21" height="24" alt="DL Links" />Popular Downloads</h2>
			</div>
			<ul class="related-list">
				<?php foreach($datPopularDownloads as $strLink=>$strText): ?>
					<li><a href="/downloads/<?php echo $strLink; ?>.html"><?php echoHSC($strText); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php return ob_get_clean();
}