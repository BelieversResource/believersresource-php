<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

function returnMobile($aryParams = FALSE) {
ob_start(); ?>
<div class="block block1">
	<div class="block-holder">
		<div class="block-frame">
			<div class="heading">
				<h2><img src="/img/android.gif" width="20" height="23" alt="Mobile App" />Now Available on Android</h2>
			</div>
			<div style="padding:10px;">The Bible research tool found here is now available as a free Android app.  Download <a href="https://play.google.com/store/apps/details?id=com.believersresource.passages">Passages</a> from the Google Play Store.</div>
		</div>
	</div>
</div>
<?php return ob_get_clean();
}