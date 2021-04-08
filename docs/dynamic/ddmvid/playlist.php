<?
# get the rss from here:
# http://ace-podcast.ace.ed.ac.uk/groups/digitalsstaff/blog/index.rss

include("exportrss.php");?>

<?

// <strong class="highlight">Parse</strong> XML/RSS 2.0 feed
$feed = new ExportRSS("http://ace-podcast.ace.ed.ac.uk/groups/digitalsstaff/blog/index.rss", "2.0");
$channel = $feed->get_channel_data();
echo "<h3>Channel</h3>
<p>
<b>Title:</b> {$channel['title']}<br/>
<b>Date:</b> {$channel['date']}<br/>
<b>Description:</b> {$channel['description']}<br/>
<b>Editor:</b> {$channel['editor']}<br/>
<b>Webmaster:</b> {$channel['webmaster']}<br/>
<b>Language:</b> {$channel['language']}<br/>
<b>Generator:</b> {$channel['generator']}<br/>
<b>Link:</b> {$channel['link']}
</p>";

echo "<h3>Feed Items</h3>";
foreach ($feed->get_data() as $item)
{
	echo "<p>
	<b>Title</b>: {$item['title']}<br/>
	<b>Date Published</b>: {$item['date']}<br/>
	<b>Description</b>: {$item['description']}<br/>
	<b>Link</b>: {$item['link']}</p>";
}
?>

# build the playlist
#header("content-type:text/xml;charset=utf-8");
#echo "<playlist version='1' xmlns='http://xspf.org/ns/0/'>\n";
#echo "<trackList>\n";
#while($row < 1) {
#  echo "\t<track>\n";
#  echo "\t\t<title>".$row['title']."</title>\n";
#  echo "\t\t<location>".$row['file']."</location>\n";
#  echo "\t\t<info>".$row['link']."</info>\n";
#  echo "\t</track>\n";
#}
#echo "</trackList>\n";
#echo "</playlist>\n";

?>