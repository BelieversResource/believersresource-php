<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

global $datPopularPassages;

// This will be replaced by code to load in from database. Using sample data for now
$datPopularPassages = array(   /*  VerseIdent => Text  */
	'Acts 17:11'						=> 'Now these were more noble than those in Thessalonica, in that they received the word with all readiness of the mind, examining the Scriptures daily to see whether these things were so.',
	'John 3:16'							=> 'For God so loved the world, that he gave his one and only Son, that whoever believes in him should not perish, but have eternal life.',
	'John 3:16-17'					=> 'For God so loved the world, that he gave his one and only Son, that whoever believes in him should not perish, but have eternal life. For God didn\'t send his Son into the world to judge the world, but that the world should be saved through him.',
	'John 14:6'							=> 'Jesus said to him, "I am the way, the truth, and the life. No one comes to the Father, except through me.',
	'1 Corinthians 6:19'		=> 'Or don\'t you know that your body is a temple of the Holy Spirit which is in you, which you have from God? You are not your own,',
	'Matthew 28:19'					=> 'Go, and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit, teaching them to observe all things that I commanded you. Behold, I am with you always, even to the end of the age." Amen.',
	'John 1:1'							=> 'In the beginning was the Word, and the Word was with God, and the Word was God.',
	'John 3:16-18'					=> 'For God so loved the world, that he gave his one and only Son, that whoever believes in him should not perish, but have eternal life. For God didn\'t send his Son into the world to judge the world, but that the world should be saved through him. He who believes in him is not judged. He who doesn\'t believe has been judged already, because he has not believed in the name of the one and only Son of God.',
	'Acts 1:8'							=> 'But you will receive power when the Holy Spirit has come upon you. You will be witnesses to me in Jerusalem, in all Judea and Samaria, and to the uttermost parts of the earth.',
	'Romans 6:23'						=> 'For the wages of sin is death, but the free gift of God is eternal life in Christ Jesus our Lord.',
	'Luke 12:15'						=> 'He said to them, "Beware! Keep yourselves from covetousness, for a man\'s life doesn\'t consist of the abundance of the things which he possesses."',
	'Isaiah 7:14'						=> 'Therefore the Lord himself will give you a sign. Behold, the virgin will conceive, and bear a son, and shall call his name Immanuel.',
	'Genesis 1:1-3'					=> 'In the beginning, God created the heavens and the earth. Now the earth was formless and empty. Darkness was on the surface of the deep. God\'s Spirit was hovering over the surface of the waters. God said, "Let there be light," and there was light.',
	'John 1:14'							=> 'The Word became flesh, and lived among us. We saw his glory, such glory as of the one and only Son of the Father, full of grace and truth.',
	'Romans 8:28'						=> 'We know that all things work together for good for those who love God, to those who are called according to his purpose.',

);

function verse2link($strVerse) {
	$strVerse = str_replace('-','_',strtolower($strVerse));
	$strVerse = preg_replace('/([0-9a-z]) +([a-z])/i', '\1_\2',$strVerse);
	$strVerse = preg_replace('/[^_0-9a-z]+_[^_0-9a-z]+/','_',$strVerse);
	$strVerse = preg_replace('/[^0-9a-z_]+/','-',$strVerse);
	return $strVerse;
}

function returnPopularPassages($aryParams = FALSE) {
	global $datPopularPassages;

	$evenOdd = array('',' class="grey"');
	$eo = 0;

ob_start(); ?>
<div class="block">
	<h3>Popular Passages</h3>
	<ul class="post">
		<?php foreach ($datPopularPassages as $strVerse=>$strText): ?>
			<li <?php echo $evenOdd[$eo]; ?> >
				<div class="description">
					<p><a href="/bible/<?php echo verse2link($strVerse); ?>.html"><?php echoHSC($strVerse); ?></a> - <?php echoHSC($strText); ?></p>
				</div>
			</li>
		<?php $eo = abs($eo-1); endforeach; ?>
	</ul>
</div>
<?php return ob_get_clean();
}