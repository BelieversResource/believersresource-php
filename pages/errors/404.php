<?php

	/**
	*  404 Error Page Handler, this is the handler for the 404 error page
	*/

  if (!defined('CURRENT_TS')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


// ==== START VIEW ====

$strParentTemplate = 'TwoColumn';

$aryTPL['Title'] = 'Resource Not Found - Believers Resource';


ob_start(); // ================================== BEGIN: LeftColumn ?>

	<div class="heading">
		<div class="heading-holder">
			<h2>404 - Page/Resource Not Found</h2>
			<p>
				The page or resource you asked for was not found. Please try navigating to it from the links
				in the menu above, or browse some of the popular content listed below and to the right.
			</p>
			<br />
			<p>
				If you were following a link from within this site, there is no need to notify us, as this 
				was logged and we will update any bad/expired links during our regular site review.
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

// EOF: ~/pages/error/404.php