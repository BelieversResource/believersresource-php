<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

function returnHeader($aryParams = FALSE) {
ob_start(); ?>
<div id="header">
	<div class="header-frame">
		<div class="header-holder">
			<div class="panel">
				<form class="register-form" action="#" id="register-form" onsubmit="return login();">
					<fieldset>
						<label for="email-field">Login:</label>
						<input class="text" id="email-field" type="text" value="email" />
						<input class="text password-field" id="password-field" type="password" value="password" />
						<input class="btn-sign" type="submit" value="SIGN IN" />
						<a href="javascript:showRegister();">Not a member?</a><br />
					</fieldset>
				</form>
				<a href="https://www.facebook.com/dialog/oauth?client_id=196495897095367&redirect_uri=http%3a%2f%2fwww.believersresource.com%2flogin.aspx%3faction%3dfbAuth%26returnUrl%3d%252Fdefault.aspx"><img src="/img/facebook.gif" width="169" height="21" alt="facebook" /></a>
			</div>
		</div>
		<div class="nav-holder">
			<form class="search-form" action="#" onsubmit="return search();">
				<fieldset>
					<div class="text">
						<input class="search-field" id="search-field" type="text" value="Enter Keyword" />
					</div>
					<input class="btn-search" type="submit" value="Submit" />
				</fieldset>
			</form>
			<ul id="nav">
				<li><a href="/downloads/"><span>DOWNLOADS</span></a></li>
				<li><a href="/bible/"><span>BIBLE</span></a></li>
				<li><a href="/topics/"><span>TOPICS</span></a></li>
				<li><a href="/forum/"><span>FORUM</span></a></li>
			</ul>
		</div>
		<div class="socialHolder">
			<g:plusone size="medium" annotation="inline" width="120" href="http://www.believersresource.com/"></g:plusone>
			<script type="text/javascript">
				(function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			</script>
			<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.believersresource.com%2F&amp;send=false&amp;layout=button_count&amp;width=150&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=196495897095367" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
		</div>
	</div>
	<h1 class="logo"><a href="/">Believers Resource</a></h1>
</div>
<?php return ob_get_clean();
}