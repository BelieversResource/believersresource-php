<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


function returnRelatedTopics($aryParams = FALSE) {

ob_start(); ?>	

<div class="block" id="relatedTopics">
	<div class="block-holder">
		<div class="block-frame">
			<div class="heading">
				<h2><img src="/img/ico4.gif" width="20" height="23" alt="image description" />Related Topics</h2>
			</div>
			<ul class="related-list">
				<li><div id="v_relatedtopic_359310" class="voteHolder info">2</div><a href="/topics/bible.html">bible</a></li>
			</ul>
			<br/><a href="javascript:submitRelatedTopic('download',8);" class="submit">SUBMIT</a>
		</div>
	</div>
</div>

<?php 

		return ob_get_clean();

	}