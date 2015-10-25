<?php
class pisca {

	public function GetPicsaVideo($vid) {
		$parsedURL = array();
		//Get the Stream Links
		// https://picasaweb.google.com/113150046846900158109/Moviefy
		$urlCodedLinks = $this -> curl_download('https://picasaweb.google.com/113150046846900158109/Moviefy');
		
		$urlEncodedLinks;
		$urlCodedLinks = preg_match_all("/\s{(.*)\s/", $urlCodedLinks, $urlEncodedLinks);
		
		//$test = $urlEncodedLinks[0][0][0];
		//print_r($urlEncodedLinks);
		$urls = $urlEncodedLinks[0][33];
		//print_r($urlEncodedLinks[0][33]);
		$urls = substr($urls,0,-3);
		//print($urls);
		print_r(($urls));
		
		
		//Filter out urlEncodedString
		
		/*$filteredStreams = stripslashes($this -> jsonRemoveUnicodeSequences(urldecode($urlEncodedLinks[0][0])));

		$filteredStreams = explode("&url=", $filteredStreams);

		for ($i = 1; $i < sizeof($filteredStreams); $i++) {
			$url = substr($filteredStreams[$i], 0, strripos($filteredStreams[$i], ",itag="));
			$videoType;

			switch($this->getVideoType($url)) {
				case "22" :
					$videoType = "video/mp4";

					break;
				case "34" :
				case "35" :
					$videoType = "video/x-flv";
					break;
				default :
					$videoType = "";
					break;
			}
			if ($videoType !== "") {
				$strucUrl = array(
					'videoType' => $videoType,
					'url' => $url
				);
				array_push($parsedURL, $strucUrl);
			}
		}*/

		//return $urlEncodedLinks[1];
	}
	
	public function getVideoType($string) {
		if (preg_match("/(&itag=)(.{2})/", $string, $m))
			return $m[2];
	}

	public function jsonRemoveUnicodeSequences($struct) {
		return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
	}

	public function curl_download($Url) {

		// is cURL installed yet?
		if (!function_exists('curl_init')) {
			die('Sorry cURL is not installed!');
		}

		// OK cool - then let's create a new cURL resource handle
		$ch = curl_init();

		// Now set some options (most are optional)

		// Set URL to download
		curl_setopt($ch, CURLOPT_URL, $Url);

		// Set a referer
		//curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");

		// User agent
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

		// Include header in result? (0 = yes, 1 = no)
		curl_setopt($ch, CURLOPT_HEADER, 0);

		// Should cURL return or print out the data? (true = return, false = print)
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Timeout in seconds
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		// Download the given URL, and return output
		$output = curl_exec($ch);

		// Close the cURL resource, and free system resources
		curl_close($ch);

		return $output;
	}
}
?>