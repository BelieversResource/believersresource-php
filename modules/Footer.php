<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

function returnFooter($aryParams = FALSE) {
ob_start(); ?>
<div id="footer">
	<div class="footer-holder">
		<div class="footer-frame1">
			<div class="footer-frame">
				<div class="info-holder">
					<ul class="footer-nav">
						<li><a href="/downloads/"><span>DOWNLOADS</span></a></li>
						<li><a href="/bible/"><span>BIBLE</span></a></li>
						<li><a href="/forum/"><span>FORUM</span></a></li>
						<li><a href="/pages/about-us.html"><span>ABOUT</span></a></li>
					</ul>
				</div>
				<ul class="social-networks">
					<li><a href="https://www.facebook.com/believersresource" target="_blank"><img src="/img/ico-facebook_39.png" alt="Visit us on Facebook" height="39" width="39" border="0"></a></li>
					<li><a href="http://www.christiantop1000.com/" target="_blank"><img src="http://www.christiantop1000.com/cgi-bin/1000/counter.cgi?id=believersresource" border="0"></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php return ob_get_clean();
}