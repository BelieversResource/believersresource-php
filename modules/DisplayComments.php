<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


function returnDisplayComments($aryParams = FALSE) {

ob_start(); ?>	

<div class="block block-comments" id="comments">
	<h3>Comments</h3>
	<ul class="comment">
		<li class="childComment">Be the first to leave a comment</li>
	</ul>
	<br />
	<br />
	<div id="comment_download_8_0"><a href="#" onclick="return loadComment(this);" class="submit">SUBMIT</a></div>
</div>

<?php 

		return ob_get_clean();

	}