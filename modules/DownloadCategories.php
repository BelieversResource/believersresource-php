<?php
	if (!defined('STORE_KEY')) { die ('[ERR:'.__LINE__.'] Invalid direct call to file'); }

	global $arySlug,$datCategories;

	require_once(MODULES_PATH.'Categories.php');
	loadCategories('download');

	function returnDownloadCategories($aryParams = FALSE) {
		global $datCategories;
		
		$aryDlCats = &$datCategories['download'];
		
		if($aryParams['ParentID']==0) {
			$strH3 = 'Categories';
		}
		else {
			$strH3  = 'Subcategories';
		}
		                                                                           
		$evenOdd = array('',' class="grey"');
		$eo = 0;

ob_start(); ?>

<?php if($aryDlCats[$aryParams['ParentID']]['children']): ?>
	<div class="block">
		<h3><?php echo $strH3; ?></h3>
		<ul class="post">
			<?php $eo = 0; foreach($aryDlCats[$aryParams['ParentID']]['children'] as $catID): $catData = &$datCategories['download'][$catID]; ?>
				<li <?php echo $evenOdd[$eo]; ?> >
					<a href="<?php echo $aryParams['BaseLink'].$catData['slug']; ?>"> <?php echoHSC($catData['name']); ?></a> - <?php echoHSC($catData['description']); ?>
      		<?php if ($catData['children']): ?>
      			<ul class="horizontal">
          		<?php foreach($catData['children'] as $childID): ?>
          			<li><a href="<?php echo $aryParams['BaseLink'].$catData['slug'].'/'.$aryDlCats[$childID]['slug']; ?>"><?php echoHSC($aryDlCats[$childID]['name']); ?></a></li>
          		<?php endforeach; ?>
      			</ul>
      		<?php endif; ?>
				</li>
			<?php $eo = abs($eo-1); endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<?php 

		return ob_get_clean();

	}