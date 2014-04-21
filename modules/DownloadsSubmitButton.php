<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }


function returnDownloadsSubmitButton($aryParams = FALSE) {
	return '<a class="submitDownload" href="/downloads/editdownload.aspx" onclick="return verifyLoggedIn();">Submit a New Download</a>';
}