<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


global $datPopularDownloads;


// This will be replaced by code to load in from database. Using sample data for now

// Keep in mind, possible update to the site will be to allow this list based upon "current" category

$datPopularDownloads = array(  /* Slug => Name */
	'youngs-literal-translation-pdf-bible-7'=>'Young\'s Literal Translation PDF Bible',
	'king-james-audio-bible-8'=>'King James Audio Bible',
	'books-of-the-bible-flash-cards-and-games-39'=>'Books of the Bible Flash Cards and Games',
	'bible-sql-scripts-10'=>'Bible SQL Scripts',
	'world-english-audio-bible-9'=>'World English Audio Bible',
	'darby-pdf-bible-4'=>'Darby PDF Bible',
	'world-english-bible-pdf-5'=>'World English Bible PDF',
	'xml-bible-55'=>'XML Bible',
	'king-james-version-104'=>'King james version',
	'king-james-pdf-bible-1'=>'King James PDF Bible'
);


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