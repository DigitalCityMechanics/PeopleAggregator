<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php
include_once dirname(__FILE__)."/../../config.inc";
require_once "api/Logger/Logger.php";
require_once "Zend/Gdata/YouTube.php";

/**
 * A YoutTube video content object
 * @extends Content
 * @author Jon Knapp (www.coffeeandcode.com)
 */
class YouTube extends Zend_Gdata_YouTube {

	/**
	 * class YouTube::__construct
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Finds the URL for the flash representation of the specified video
	 *
	 * @param  Zend_Gdata_YouTube_VideoEntry $entry The video entry
	 * @return string|null The URL or null, if the URL is not found
	 */
	private function findFlashUrl($entry) {
		Logger::log("Enter: YouTube::findFlashUrl | Arg: \$entry = $entry");

		foreach ($entry->mediaGroup->content as $content) {
			if ($content->type === 'application/x-shockwave-flash') {
				Logger::log("Exit: YouTube::findFlashUrl");
				return $content->url;
			}
		}

		Logger::log("Exit: YouTube::findFlashUrl");
		return null;
	}

	/**
	 * Create the HTML to embed the video and return it.
	 *
	 * @param  string $url The YouTube url belonging to the video you want to show
	 * @return string The HTML to embed the video or an empty string if the url is not found
	 */
	public static function getEmbedHTML($url) {
		Logger::log("Enter: YouTube::getEmbedHTML | Arg: \$url = $url");
		$html = '';

		$youtube = new YouTube();
		$videoID = $youtube->parseVideoID($url);
		if ($videoID !== null) {
			$entry = $youtube->getVideoEntry($videoID);
			if ($entry !== null) {
				$videoTitle = $entry->mediaGroup->title;
				$videoUrl = $youtube->findFlashUrl($entry);

				if ($videoUrl !== null) {
					if ($videoTitle !== null && $videoTitle !== '') {
						$html .= '<p class="video-title">'.$videoTitle.'</p>'."\n";
					}
					$html .= '<object width="425" height="350">';
					$html .= "\t".'<param name="movie" value="'.$videoUrl.'"></param>'."\n";
					$html .= "\t".'<param name="allowFullScreen" value="true"></param>'."\n";
					$html .= "\t".'<param name="allowscriptaccess" value="always"></param>'."\n";
					$html .= "\t".'<embed src="'.$videoUrl.'" type="application/x-shockwave-flash"'."\n";
					$html .= "\t\t".'allowscriptaccess="always" allowfullscreen="true" width=425" height="350"></embed>'."\n";
					$html .= '</object>'."\n";
				}
			}			
		}

		Logger::log("Exit: YouTube::getEmbedHTML");
		return $html;
	}

	/**
	 * Parse a YouTube url and return the video ID
	 *
	 * @param  string $url The YouTube video url
	 * @return string|null The video ID string or null, if the url cannot parse a YouTube ID
	 */
	private function parseVideoID($url) {
		Logger::log("Enter: YouTube::parseVideoID | Arg: \$url = $url");
		$videoID = null;

		if (strpos($url, 'http://www.youtube.com/') !== false) {
			if (preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=[0-9]/)[^&\n]+|(?<=v=)[^&\n]+|(?<=/v/)[a-zA-Z0-9-]+#', $url, $matches)) {
				$videoID = isset($matches[0]) ? $matches[0] : null;
			}
		}

		Logger::log("Exit: YouTube::parseVideoID");
		return $videoID;
	}
}
?>