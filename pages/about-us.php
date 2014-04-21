<?php

	/**
	*  Home module, this is the module for the home page
	*/

  if (!defined('CURRENT_TS')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


// ==== START VIEW ====

$strParentTemplate = 'TwoColumn';

$aryTPL['Title'] = 'About Us - Believers Resource - Free Christian Resources';


ob_start(); // ================================== BEGIN: LeftColumn ?>

	<div class="heading">
		<div class="heading-holder">
			<h2>About Us</h2>
			<br />
		</div>
	</div>
	<div id="content">
		<div class="content-holder">
			<div style="padding:0px 20px;">
				<p>
					Believers Resource was started in 2007 and relaunched in 2011 with the goal of making 
					quality Christian resources freely available for anyone. We do this by creating original 
					content and highlighting quality free content that others have made.
				</p>
				<p>
					This site is largely community driven. Any visitor to the site may submit a link to our 
					downloads directory and it is the votes of other visitors to the site that determines how 
					promenently each submission is displayed. The same is true with our Bible research tool. 
					Anyone can suggest related topics, verses and websites for any passage in the Bible and 
					the votes of others determine the relevancy of each submission.
				</p>
				<p>
					The related passages in our Bible research tool were originally populated by crawling over 
					15 million web pages and looking for passage combinations that are regularly mentioned 
					together. The related topics were populated using a combination of the same crawling 
					technique and data from the <a href="http://www.openbible.info/topics/" target="_blank">Topical Bible</a> 
					at OpenBible.info. Both the related passages and topics continue to improve over time as 
					visitors vote on the most relevant options.
				</p>
				<p>
					We offer a <a href="/forum/">forum</a> where most issues can be discussed, but if you would 
					like to contact me privately you can do so with our <a href="/contact-us">contact form</a>.
				</p>
			</div>
		</div>
	</div>

<?php $aryTPL['LeftColumn'] = ob_get_clean(); // === END: LeftColumn


ob_start(); // ================================== BEGIN: RightColumn ?>

	<?php outputModule('PopularDownloads'); ?>
	<?php outputModule('PopularTopics'); ?>
	<?php outputModule('Mobile'); ?>

<?php $aryTPL['RightColumn'] = ob_get_clean(); // === END: RightColumn

// EOF: ~/page/home.php