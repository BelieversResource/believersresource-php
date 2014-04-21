<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


function returnRelatedPhotos($aryParams = FALSE) {

ob_start(); ?>	

<div class="block block-gallery">
	<div class="block-holder">
		<div class="block-frame">
			<div class="heading">
				<h2><img src="/img/ico3.gif" width="22" height="19" alt="image description" />Related Photos</h2>
			</div>
			<div class="carousel">
				<div class="frame">
					<ul>
						<li id="relatedPhoto"><div class="photo"><a href="/gallery/image.aspx?id=501"><img src="http://www.believersresource.com/content/images/501.jpg" width="250" /></a></div></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="relatedImagedHolder"></div>

<?php 

		return ob_get_clean();

	}