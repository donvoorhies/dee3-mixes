<?php
header('Content-Type: application/rss+xml; charset=UTF-8');

// suck in the query string variables
$feed_name = htmlspecialchars($_GET['fname']);
$list_name = htmlspecialchars($_GET['lname']);

// compose the api urls + other stuff depending on presence of playlist
if(isset($_GET['lname'])) {
	$json_url = 'http://api.mixcloud.com/'.$feed_name.'/playlists/'.$list_name;
	$mcloud_url = 'https://www.mixcloud.com/'.$feed_name.'/playlists/'.$list_name.'/';
	$feed_title = $feed_name.': '.$list_name;
} else {
	$json_url = 'http://api.mixcloud.com/'.$feed_name.'/cloudcasts/';
	$mcloud_url = 'https://www.mixcloud.com/'.$feed_name.'/';
	$feed_title = $feed_name;
}

// suck in json from mixcloud and turn into an array
$json = file_get_contents($json_url);
$feed_array = json_decode($json, true);

?>

<rss version='2.0'>

<channel>
	<title><?php echo $feed_array[name]; ?></title>
	<link><?php echo $mcloud_url; ?></link>
	<description><?php echo 'RSS feed for '.$feed_title.' on mixcloud.com'; ?></description>
	<image><?php echo $feed_array[data][0][user][pictures][large]; ?></image>

<?php
// item loop stuff goes here
foreach ($feed_array[data] as $feed_item) {
	echo "<item>\n";
		echo "<title>";
		echo $feed_item[name];
		echo "</title>\n";
	
		echo "<link>";
		echo $feed_item[url];
		echo "</link>\n";
	
		echo "<description>";
		echo '<![CDATA[<img src="'.$feed_item[pictures][extra_large].'">]]>';
		echo "</description>\n";
	
		echo "<pubDate>";
		echo $feed_item[created_time];
		echo "</pubDate>\n";
	echo "</item>\n";
}

?>

</channel>
</rss>