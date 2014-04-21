<?php

	define('CURRENT_TS',time());
	require_once('inc/init.inc.php');
	
	echo "<pre><tt>\n";
	
	
	$in = readDBlive('SELECT id,url FROM downloads ORDER BY id',true);
	foreach($in as $k=>$d) {
		echo "\n\nSTART: ",$d['url'];
		if (preg_match('/^([a-z0-9-]+)(-'.$k.')$/',$d['url'],$parts)) {
			$d['url'] = $parts[1];
		}
		
		if (substr($d['url'],-5)=='.html') { $d['url'] = trim(substr($d['url'],0,-5)); }
		echo "\n  MID: ",$d['url'];
		$slug = trim(preg_replace('/[^a-z0-9]+/','-',$d['url']),'-');
		if ($slug=='') { $slug = 'file'; }
		echo "\n  END: ",$slug;
//		writeDbArray('downloads',array('url'=>$slug),$k,'id');		
	}
  
?>
