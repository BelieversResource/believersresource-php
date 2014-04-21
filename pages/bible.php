<?php

	/**
	*  Home module, this is the module for the home page
	*/

  if (!defined('CURRENT_TS')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


// ==== START VIEW ====

$strParentTemplate = 'TwoColumn';

$aryTPL['Title'] = 'Believers Resource - Free Christian Resources';


ob_start(); // ================================== BEGIN: LeftColumn ?>

	<div class="heading">
		<div class="heading-holder">
			<h2>Welcome to Believers Resource</h2>
			<p>
				This is a community driven site where visitors control the content.  Every Bible verse is
				indexed with related topics, passages and commentary voted on by the community. All
				downloads are free for churches and individuals to use and are also submitted by our
				members. As you use the site please take a moment to make it better for others by voting on
				the best content.
			</p>
			<br />
		</div>
	</div>
	<div id="content">
		<div class="content-holder">
			<?php outputModule('PopularPassages'); ?>
		</div>
	</div>

<?php $aryTPL['LeftColumn'] = ob_get_clean(); // === END: LeftColumn


ob_start(); // ================================== BEGIN: RightColumn ?>

	<?php outputModule('PopularDownloads'); ?>
	<?php outputModule('PopularTopics'); ?>
	<?php outputModule('Mobile'); ?>

<?php $aryTPL['RightColumn'] = ob_get_clean(); // === END: RightColumn

// EOF: ~/pages/bible.html