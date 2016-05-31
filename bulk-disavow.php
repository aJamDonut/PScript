<?php
	echo date("d m Y h:i:s");
?>

<div class="container" style='margin:20px;'>
<p>Enter URLS here (new line seperated)</p>
<form method="post" id="sitesForm">
<textarea id="sites" name="sites" style='color: black;width: 200px; height: 200px; border: 1px solid black; padding: 10px;' placeholder='site1.com
site2.com'></textarea>
<input type="submit" value="Go|" />
</form>

</div>
<div id="out">
	
</div>
</div>

<?php
if(isset($_POST['sites'])) {
	$sites = explode("\n", $_POST['sites']);
	foreach($sites as $site) {
		$site = str_replace("%0D", "", urlencode($site));
		if(strlen($site>5)) {
		$url = "http://www.disdit.com/domain/{$site}";
		$html = file_get_contents($url);
		$e = preg_match_all('/<div class=\"postblack\">(.*?)<\/div>/s',$html,$res);
		echo "|".$site."|";
		echo $res[0][0];
		ob_flush();
		flush();
  sleep(0.5);
		}
	}
	
}
?>