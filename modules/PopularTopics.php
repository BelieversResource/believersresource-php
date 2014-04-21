<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


global $datPopularTopics;

// This will be replaced by code to load in from database. Using sample data for now
$datPopularTopics = array( /*  Slug => Topic  */
	'miracle'=>'miracle',
	'israel'=>'Israel',
	'women'=>'women',
	'faith'=>'faith',
	'david'=>'David',
	'prayer'=>'prayer',
	'god'=>'God',
	'temple'=>'temple',
	'ruler'=>'ruler',
	'priest'=>'priest'
);


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