<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


global $datPopularTopics;


function loadPopularTopics() {	
	$datPopularTopics = array(  /* Slug => Name */);
	$aryTopics = readDBcache('SELECT t.`id`, t.`url`, t.`name` FROM `temp_popular_topics` tpt INNER JOIN `topics` t on t.id=tpt.`topic_id` ORDER BY tpt.`votes` DESC LIMIT 10',TRUE);
	if (count($aryTopics) > 0) {
		foreach($aryTopics as $pk => $data) {
      $datPopularTopics[$data['url']] = $data['name'];
		}
	}
  return $datPopularTopics;
}
 
 $datPopularTopics = loadPopularTopics();


function returnPopularTopics($aryParams = FALSE) {
	global $datPopularTopics;
ob_start(); ?>
<div class="block block1">
	<div class="block-holder">
		<div class="block-frame">
			<div class="heading">
				<h2><img src="/img/ico4.gif" width="20" height="23" alt="image description" />Popular Topics</h2>
			</div>
			<ul class="related-list">
				<?php foreach($datPopularTopics as $strLink=>$strText): ?>
					<li><a href="/topics/<?php echo $strLink; ?>.html"><?php echoHSC($strText); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php return ob_get_clean();
}