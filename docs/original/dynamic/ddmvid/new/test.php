<?php 
	// Uses simplepie - http://simplepie.org/
	// Code modified from - http://www.fleetwith.co.uk/radiorss/howto.shtml
	
    //  Series title is used to write top of XML file title
    $series_title = "ACE Podcast"; 

    //  Write header is a function call to write the top of the XML file
    writeheader($series_title);

    // Now some very standard setup stuff, copied from SimplePie demonstration code. Includes
    // the source XML file for the re-write.
    include_once('simplepie.inc');
    $feed = new SimplePie(); // Create a new instance of SimplePie
    $feed->set_feed_url('http://ace-podcast.ace.ed.ac.uk/groups/digitalsstaff/blog/index.rss');
    $feed->set_cache_duration (3600); //The cache duration
    $feed->enable_xml_dump(isset($_GET['xmldump']) ? true : false);
    $success = $feed->init(); // Initialize SimplePie
    $feed->handle_content_type(); // Take care of the character encoding
    ?>
    
    <?php 
	if ($success): 
		// initialise $itemlimit, which limits the maximum length of the resulting XML file
		$itemlimit=0;
		foreach($feed->get_items() as $item): 
			// set the maximum length to 150 items
			if ($itemlimit==150) { break; } 
			// we proceed around the loop to write an <item> section
			
			//check to see if flv video exists:
			$looksee = "";
			/*if(strpos( $item->get_description(), $looksee) == false){
				echo "SPAM";
				echo $item->get_description();
				echo "END SPAM";

			};*/
			
			?>
<item>
<title><?
			// Start by removing "Naked Scientists " from the title string
		    $temp_title = $item->get_title();
			// with the titles, need to replace erroneous & characters with the full form
		    $temp_title = str_replace("&", "&amp;", $temp_title) ;
		    $temp_title = str_replace("&amp;amp;", "&amp;", $temp_title) ;
			// Finally split the title into two parts, the actual title and the transmission date
			//list($trans_date, $prog_title) = split(" - ", $temp_title, 2);
			// Reassemble the title with the date after the title string
			//$new_title = $prog_title . " - ". $trans_date ;
			echo $temp_title ;
?></title>
<link><? echo $item->get_permalink(); ?></link>
<description><? 
			echo str_replace("&", "&amp;", $item->get_description() ); ?>
</description><? 
		    $the_enclosure = $item->get_enclosure(); 
			$new_link = $the_enclosure->get_link() ;
			$new_link = str_replace("-ipod.m4v", "-flash.flv", $new_link) ;
		    echo '<enclosure url="' . $new_link .'" ';
		    echo ' length="'. $the_enclosure->get_length() .'" ';
		    echo ' type="video/x-flv" />';
?>
</item>


<? $itemlimit++ ?>
<?php 	endforeach; ?>
<?php endif; ?>
<?php 
    writefooter(); 

function writeheader($title) {
	    echo '<?xml version="1.0" encoding="UTF-8"?> ' ;
	    echo '<rss version="2.0"> ' ;
	    echo '<channel> ' ;
	    echo '<title>' . $title .'</title> ' ;
	    echo '<description>Vid-castable?</description> ';
	    echo '<link>http://ace-podcast.ace.ed.ac.uk/groups/digitalsstaff/weblog/</link>' ;
    }
function writefooter() {
    echo '</channel></rss> ';
    }
	
?>