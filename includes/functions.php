<?php

/**
*
* Retrieve the HTML of a URL with cURL
*
* @param (string) URL to pull HTML from.
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @return (string) HTML of URL.
*
*/
function getHTML($url, $options = false) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	if($options) {
		foreach($options as $key => $value) {
			curl_setopt($curl, $key, $value);
		}
	} else {
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
	}
	return curl_exec($curl);
}

/**
*
* Retrieve the XML of a URL with cURL
*
* @param (string) URL to pull XML from.
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @return (string) XML of URL.
*/
function getXML($url, $options = false) {
	$html = getHTML($url, $options);
	$xml = simplexml_load_string($html);
	return $xml;
}

/**
*
* Retrieve RSS Feed Data from Wordpress
*
* @param (string) Feed URL to pull info from.
* @param (int) Total.
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @param (array) Optional. Existing array to add information to. Existing items could be rewritten! Must use with next @param!
* @param (int) Optional. Number to start existing array from.
* @return (array) Feed Info.
* 
*/
function getWordpressRSSFeed($url, $total = 999, $options = false, $array = array(), $i = 0) {
	$xml = getXML('http://pepsicoblogs.com/feed/');
	if($xml->channel->item) {
		foreach($xml->channel->item as $item) {
			if($i < $total) {
				$dc = $item->children('http://purl.org/dc/elements/1.1/');
				$slash = $item->children('http://purl.org/rss/1.0/modules/slash/');

				$array[$i]['title'] = (string) $item->title;
				$array[$i]['url'] = (string) $item->link;
				$array[$i]['author'] = (string) $dc->creator;
				$array[$i]['content'] = removeCDATA($item->description);
				$array[$i]['comments'] = (int) $slash->comments;
				$array[$i]['datetime'] = date('Y-m-d H:i:s', strtotime($item->pubDate));
				$i++;
			}
		}
	}
	return $array;
}

/**
*
* Retrieve single FlickR photo Information (FLICKR_API_KEY MUST BE DEFINED!)
*
* @param (string) URL to pull photo info from. Must be in this form: http://www.flickr.com/photos/username/1234567890/
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @param (array) Optional. Existing array to add information to. Existing items could be rewritten!
* @return (array) Photo Info.
*/
function getSingleFlickrPhotoInfo($url, $options = false, $array = array()) {
	preg_match_all('/http:\/\/www.flickr.com\/photos\/.*?\/(.*?)\//', $url, $matches);
	$xml = getXML('http://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key='.FLICKR_API_KEY.'&photo_id='.$matches[1][0], $options);
	if($xml->attributes()->stat == 'ok') {
		$attrs = $xml->photo->attributes();
		$author = $xml->photo->owner->attributes();
		$dates = $xml->photo->dates->attributes();
		
		$array['title'] = (string) $xml->photo->title;
		$array['author'] = (string) $author->username;
		$array['content'] = (string) $xml->photo->description;
		$array['image'] = 'http://farm'.$attrs->farm.'.static.flickr.com/'.$attrs->server.'/'.$attrs->id.'_'.$attrs->secret.'.jpg';
		$array['datetime'] = date('Y-m-d H:i:s', (string) $dates->posted);
		$array['datetaken'] = date('Y-m-d H:i:s', strtotime($dates->taken));
		$array['authorid'] = (string) $author->nsid;
		$array['comments'] = (string) $xml->photo->comments;
		$array['views'] = (string) $attrs->views;
	}
	return $array;
}

/**
*
* Retrieve FlickR Photo Information from FlickR Feed
*
* @param (string) Feed URL to pull info from.
* @param (int) Total.
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @param (array) Optional. Existing array to add information to. Existing items could be rewritten! Must use with next @param!
* @param (int) Optional. Number to start existing array from.
* @return (array) Photos Info.
* 
*/
function getFlickrFeedResults($url, $total = 999, $options = false, $array = array(), $i = 0) {
	$xml = getXML($url, $options);
	if($xml->channel->item) {
		foreach($xml->channel->item as $item) {
			if($i < $total) {
				$media = $item->children('http://search.yahoo.com/mrss/');

				$array[$i]['title'] = (string) $item->title;
				$array[$i]['url'] = (string) $item->link;
				$array[$i]['description'] = (string) $item->description;
				$array[$i]['datetime'] = date('Y-m-d H:i:s', strtotime($item->pubDate));
				$array[$i]['author'] = (string) $media->credit;
				$array[$i]['image'] = (string) $media->content->attributes()->url;
				$array[$i]['thumb'] = (string) $media->thumbnail->attributes()->url;
				$i++;
			}
		}
	}
	return $array;
}

/**
*
* Retrieve FlickR Photoset Information (FLICKR_API_KEY MUST BE DEFINED!)
* More detailed argument information available at http://www.flickr.com/services/api/flickr.photosets.getPhotos.htm
* Optional arguments not implemented into function yet as of June 28, 2010
*
* @param (string) The id of the photo set to return the photos for.
* @param (string) Optional. A comma-delimited list of extra information to fetch for each returned record.
* @param (int) Optional. Existing array to add information to. Existing items could be rewritten!
* @param (int) Optional. Return photos only matching a certain privacy level.
* @param (int) Optional. Number of photos to return per page.
* @param (int) Optional. The page of results to return.
* @param (string) Optional. Filter results by media type.
* @return (array) Photo Info.
*/
function getFlickrSetPhotoInfo($photoset_id, $extras = "date_upload, date_taken, views, url_sq, url_t, url_s, url_m, url_o", $privacy_filter = 1, $per_page = 500, $page = 1, $media = "all") {
	$extras = urlencode( $extras );
	$xml = getXML('http://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . FLICKR_API_KEY . '&photoset_id=' . $photoset_id . '&extras=' . $extras);
	if($xml->attributes()->stat == 'ok') {
		$i = 0;
		$array = array();
		foreach ( $xml->photoset->photo as $photo ) {
			$photo = $photo->attributes();
		
			$array[$i]['id'] = (string) $photo->id;
			$array[$i]['title'] = (string) $photo->title;
			$array[$i]['dateupload'] = date('Y-m-d H:i:s', strtotime( $photo->dateupload));
			$array[$i]['datetaken'] = date('Y-m-d H:i:s', strtotime( $photo->datetaken ));
			$array[$i]['views'] = (string) $photo->views;
			$array[$i]['url_sq'] = (string) $photo->url_sq;
			$array[$i]['url_t'] = (string) $photo->url_t;
			$array[$i]['url_s'] = (string) $photo->url_s;
			$array[$i]['url_m'] = (string) $photo->url_m;
			$array[$i]['url_o'] = (string) $photo->url_o;
			$i++;
		}
	}
	return $array;
}

/**
*
* Retrieve TwitPic Images from User Profile
*
* @param (string) Username account to pull images from
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @param (array) Optional. Existing array to add information to. Existing items could be rewritten! Must use with next @param!
* @param (int) Optional. Number to start existing array from.
* @return (array) Photos Info.
* 
*/
function getTwitPicUserImages($username, $options = false, $array = array(), $i = 0) {
	$xml = getXML("http://api.twitpic.com/2/users/show.xml?username=$username");
	foreach($xml->images->image as $image) {
		$array[$i]['image_id'] = (int) $image->id;
		$array[$i]['user_id'] = (int) $image->user_id;
		$array[$i]['short_id'] = (string) $image->short_id;
		$array[$i]['thumb'] = (string) "http://twitpic.com/show/thumb/$image->short_id";
		$array[$i]['mini'] = (string) "http://twitpic.com/show/mini/$image->short_id";
		$array[$i]['url'] = (string) "http://twitpic.com/$image->short_id";
		$array[$i]['message'] = (string) $image->message;
		$array[$i]['views'] = (int) $image->views;
		$array[$i]['datetime'] = date('Y-m-d H:i:s', strtotime($image->timestamp));
		$i++;
	}
	return $array;
}

/**
*
* Retrieve Twitter Search Results
*
* @param (string) Search query.
* @param (int) Total.
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @param (array) Optional. Existing array to add information to. Existing items could be rewritten! Must use with next @param!
* @param (int) Optional. Number to start existing array from.
* @return (array) Twitter Statuses Info.
*
*/
function getTwitterSearchResults($search, $total, $options = false, $array = array(), $i = 0) {
	$xml = getXML('http://search.twitter.com/search.atom?q='.$search.'&rpp='.$total, $options);
	if(!$xml->error) {
		foreach($xml->entry as $entry) {
			$array[$i]['content'] = (string) $entry->content;
			$array[$i]['author'] = substr($entry->author->uri, 19);
			$array[$i]['datetime'] = date('Y-m-d H:i:s', strtotime($entry->published));
			$array[$i]['url'] = (string) $entry->link[0]->attributes()->href;
			$array[$i]['author_thumb'] = (string) $entry->link[1]->attributes()->href;
			$array[$i]['author_url'] = (string) $entry->author->uri;
			$i++;
		}
	}
	return $array;
}

function getTwitterUserTimeline($total, $i = 0, $array = array()) {
	$xml = getXML('http://api.twitter.com/1/statuses/user_timeline.rss?count='.$total, array(CURLOPT_USERPWD => TWITTER_CREDS, CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5'));
	if(isset($xml->channel->item)) {
		foreach($xml->channel->item as $item) {
			$array[$i]['content'] = $item->description;
			$array[$i]['url'] = $item->link;
			$array[$i]['datetime'] = date('Y-m-d H:i:s', strtotime($item->pubDate));
			$i++;
		}
	}
	return $array;
}

/**
*
* Retrieve single Twitter Status Info
*
* @param (string) URL to pull status info from. 
* @param (array) Optional. Defaults to FF 3.5 UserAgent but can use array of other options.
* @param (array) Optional. Existing array to add information to. Existing items could be rewritten!
* @return (array) Twitter Status Info.
*
*/
function getSingleTwitterStatusInfo($url, $options = false, $array = array()) {
	preg_match_all('/\/statuses\/(.*?)$/', $url, $matches);
	$xml = getXML('http://api.twitter.com/1/statuses/show/'.$matches[1][0].'.xml', $options);
	if(!$xml->error) {
		$array['content'] = (string) $xml->text;
		$array['author'] = (string) $xml->user->screen_name;
		$array['datetime'] = date('Y-m-d H:i:s', strtotime($xml->created_at));
		$array['tweetid'] = $matches[1][0];
		$array['authorid'] = (string) $xml->user->id;
		$array['author_thumb'] = (string) $xml->user->profile_image_url;
		$array['author_description'] = (string) $xml->user->description;
		$array['followers'] = (string) $xml->user->followers_count;
		$array['friends'] = (string) $xml->user->friends_count;
		$array['following'] = (string) $xml->user->following;
		$array['statuses'] = (string) $xml->user->statuses;
	}
	return $array;
}

/**
*
* PARAMETERS ARE DEFINED HERE: http://code.google.com/apis/youtube/2.0/developers_guide_protocol_api_query_parameters.html
*
*/
function getYoutubeVideosByQuery($parameters, $array = array(), $i = 0) {
	$xml = getXML('http://gdata.youtube.com/feeds/api/videos/?'.$parameters);
	foreach($xml->entry as $entry) {
		$media = $entry->children('http://search.yahoo.com/mrss/');
		$yt = $media->group->children('http://gdata.youtube.com/schemas/2007');
		
		$array[$i]['title'] = (string) $entry->title;
		$array[$i]['content'] = (string) $media->group->description;
		$array[$i]['author'] = (string) $entry->author->name;
		$array[$i]['datetime'] = date('Y-m-d H:i:s', strtotime($entry->published));
		$array[$i]['videoid'] = (string) $yt->videoid;
		$array[$i]['duration'] = secondsToMinutes($yt->duration->attributes()->seconds);
		
		$t = 0;
		$thumbs = array();
		foreach($media->group->thumbnail as $thumb) {
			if(count($thumbs) != 2) {
				if(count($thumbs) == 0 || (count($thumbs) == 1 && $thumbs[0]['width'] != (string) $thumb->attributes()->width)) {
					$thumbs[$t]['url'] = (string) $thumb->attributes()->url;
					$thumbs[$t]['width'] = (int) $thumb->attributes()->width;
					$t++;
				}
			}
		}
		if($thumbs[0]['width'] > $thumbs[1]['width']) {
			$array[$i]['thumb_sm'] = $thumbs[1]['url'];
			$array[$i]['thumb_lg'] = $thumbs[0]['url'];
		} else {
			$array[$i]['thumb_sm'] = $thumbs[0]['url'];
			$array[$i]['thumb_lg'] = $thumbs[1]['url'];
		}
		$i++;
	}
	return $array;
}

function getSingleYoutubeVideoInfo($url, $array = array()) {
	$v = getVarFromUrl($url, 'v');
	$xml = getXML('http://gdata.youtube.com/feeds/api/videos/'.$v);
	$author = getXML('http://gdata.youtube.com/feeds/api/users/'.$xml->author->name.'?v=2');
	$media = $xml->children('http://search.yahoo.com/mrss/');
	$yt = $media->group->children('http://gdata.youtube.com/schemas/2007');
	
	$array['title'] = (string) $xml->title;
	$array['content'] = (string) $xml->content;
	$array['author'] = (string) $xml->author->name;
	$array['datetime'] = date('Y-m-d H:i:s', strtotime($xml->published));
	$array['videoid'] = $v;
	$array['author_thumb'] = (string) $author->children('http://search.yahoo.com/mrss/')->thumbnail[0]->attributes()->url;
	$array['duration'] = secondsToMinutes($yt->duration->attributes()->seconds);
	$array['thumb_sm'] = (string) $media->group->thumbnail[0]->attributes()->url;
	$array['thumb_lg'] = (string) $media->group->thumbnail[3]->attributes()->url;
	
	return $array;
}

function insertArrayIntoDB($array, $table, $dupeCheckColumn = '') {
	global $db;
	if(!empty($array)) {
		if(is_array($array[0])) {
			foreach($array as $item) {
				if(!empty($dupeCheckColumn)) {
					$dupeCheck = $item[$dupeCheckColumn];
					$inDB = $db->query_first("SELECT id FROM $table WHERE $dupeCheckColumn = '$dupeCheck'");
				}
				if(!$inDB) $db->query_insert($table, $item);
			}
		} else {
			if(!empty($dupeCheckColumn)) {
				$dupeCheck = $array[$dupeCheckColumn];
				$inDB = $db->query_first("SELECT id FROM $table WHERE $dupeCheckColumn = '$dupeCheck'");
			}
			if(!$inDB) $db->query_insert($table, $item);
		}
	}
}

function getPageTitle($url) {
	$html = getHTML($url);
	preg_match_all('/<title>(.*?)<\/title>/', $html, $matches);
	return $matches[1][0];
}

function checkDomainsInUrl($url, $domains = array()) {
	$domain = getDomainFromUrl($url);
	if($domains) {
		foreach($domains as $item) {
			if($item == $domain) return true;
		}
	}
	return false;
}

function getDomainFromUrl($url) {
	$parsedURL = parse_url($url);
	return str_replace('www.', '', $parsedURL['host']);
}

function getVarFromUrl($url, $var = null) {
	$parsedURL = parse_url($url);
	parse_str($parsedURL['query'], $urlVars);
	if($var) return $urlVars[$var];
	else return $urlVars;
}

function secondsToMinutes($seconds) {
	$minutes = floor($seconds/60);
	$secondsleft = $seconds%60;
	if($minutes<10)
	    $minutes = "0" . $minutes;
	if($secondsleft<10)
	    $secondsleft = "0" . $secondsleft;
	return $minutes.':'.$secondsleft;
}

function monthArray() {
	return array('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December');
}

function dayArray() {
	return array('01'=>'1', '02'=>'2', '03'=>'3', '04'=>'4', '05'=>'5', '06'=>'6', '07'=>'7', '08'=>'8', '09'=>'9', '10'=>'10', '11'=>'11', '12'=>'12','13'=>'13','14'=>'14', '15'=>'15', '16'=>'16', '17'=>'17', '18'=>'18', '19'=>'19', '20'=>'20', '21'=>'21', '22'=>'22','23'=>'23','24'=>'24', '25'=>'25', '26'=>'26', '27'=>'27', '28'=>'28', '29'=>'29', '30'=>'30', '31'=>'31');
}

function yearArray($yearhigh = 2050, $yearlow = 1900) {
	$choices = array();
	for($i = $yearhigh; $i >= $yearlow; $i--) {
		$choices[$i] = $i;
	}
	return $choices;
}

function stateArray() {
	return array('AL'=>"Alabama", 'AK'=>"Alaska", 'AZ'=>"Arizona", 'AR'=>"Arkansas", 'CA'=>"California", 'CO'=>"Colorado", 'CT'=>"Connecticut", 'DE'=>"Delaware", 'DC'=>"District Of Columbia", 'FL'=>"Florida", 'GA'=>"Georgia", 'HI'=>"Hawaii", 'ID'=>"Idaho", 'IL'=>"Illinois", 'IN'=>"Indiana", 'IA'=>"Iowa", 'KS'=>"Kansas", 'KY'=>"Kentucky", 'LA'=>"Louisiana", 'ME'=>"Maine", 'MD'=>"Maryland",  'MA'=>"Massachusetts", 'MI'=>"Michigan",  'MN'=>"Minnesota", 'MS'=>"Mississippi", 'MO'=>"Missouri", 'MT'=>"Montana", 'NE'=>"Nebraska", 'NV'=>"Nevada", 'NH'=>"New Hampshire", 'NJ'=>"New Jersey", 'NM'=>"New Mexico", 'NY'=>"New York", 'NC'=>"North Carolina", 'ND'=>"North Dakota", 'OH'=>"Ohio", 'OK'=>"Oklahoma", 'OR'=>"Oregon", 'PA'=>"Pennsylvania", 'RI'=>"Rhode Island", 'SC'=>"South Carolina", 'SD'=>"South Dakota", 'TN'=>"Tennessee", 'TX'=>"Texas", 'UT'=>"Utah", 'VT'=>"Vermont", 'VA'=>"Virginia", 'WA'=>"Washington", 'WV'=>"West Virginia", 'WI'=>"Wisconsin", 'WY'=>"Wyoming");
}

function printSelect($options, $current = '') {
	foreach($options as $key => $value) {
		if($key == $current) {
			echo '<option value="'.$key.'" selected>'.$value.'</option>';
		}
		else {
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	}
}

function printNav($items, $total = null, $i = null) {
	if(!$total) $total = count($items);
	if(!$i) $i = 1;
	foreach($items as $item) {
		$classes = '';
		$a_class = '';
		$onclick = '';
		$page = urlSafe($item[0]);
		
		if($i == 1) $classes .= ' first';
		if($i == $total) $classes .= ' last';
		if(CURRENT_PAGE == $page) $classes .= ' selected';
		if(empty($item[1])) $item[1] = HTTP_URL.$page.'/';
		if(!empty($item[2])) $a_class = ' class="'.$item[2].'"';
		if(!empty($item[3])) $onclick = ' onclick="'.$item[3].'"';
		
		echo '<li class="'.$page.$classes.'"><a href="'.$item[1].'"'.$a_class.$onclick.'>'.$item[0].'</a></li>';
		$i++;
	}
}

function validateEmail($email) {
	if(eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) return true;
	else return false;
}

function removeNonAlphaNumerics($string) {
	return trim(preg_replace('/[^A-Za-z0-9 ]/', '', $string));
}

function removeExtraSpaces($string) {
	return trim(preg_replace('/\s+/', ' ', $string));
}

function countWords($string) {
	return str_word_count($string);
}

function removeCDATA($string) { 
    preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $string, $matches);
    return str_replace('\n', ' ', strip_tags(str_replace($matches[0], $matches[1], $string))); 
}

function substrLength($string, $length) {
	if(strlen($string) > $length) {
		$string = trim(substr($string, 0, $length)).'&#8230;';
	}
	return $string;
}

function substrWords($string, $length, $delimiter = '&hellip;') {
	if(strlen($string) > $length) {
		preg_match('/(.{' . $length . '}.*?)\b/', $string, $matches);  
	    $string = preg_replace("'(&[a-zA-Z0-9#]+)$'", '$1;', $matches[1]) . $delimiter;
	}
    return $string; 
}

function trimByWords($string, $num) {
	preg_match("/([\S]+\s*){0,$num}/", $string, $regs);
	return trim($regs[0]);
}

function urlSafe($string) {
	return str_replace(' ', '-', strtolower(removeExtraSpaces(removeNonAlphaNumerics($string))));
}

function getAge($DOB) {
	list($year, $month, $day) = explode("-", $DOB);
	$year_diff = date('Y') - $year;
	$month_diff = date('m') - $month;
	$day_diff = date('d') - $day;
	if($day_diff < 0 || $month_diff < 0) $year_diff--;
	return $year_diff;
}

function validate5DigitZip($zip) {
	if(preg_match('/^[0-9]{5}$/', $zip)) return true;
	else return false;
}

function validatePhone($number) {
  $pattern = '/^[\(]?[0-9]{3}[\)]?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/';
  return preg_match($pattern, $number);
}

function postify($fields) {
	$post = '';
	foreach($fields as $key => $value)
	{
		$post .= $key . '=' . $value . '&amp;';
	}
	return rtrim($post, '&amp;');
}

function nl2p($string, $line_breaks = true, $xml = true) {
	$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
	if($line_breaks) return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '<br'.($xml == true ? ' /' : '').'>'), trim($string)).'</p>';
	else return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($string)).'</p>';
}

function correctDateFormat($date, $format = 'MM/DD/YYYY') {
	switch($format) {
		case 'MM-DD-YYYY':
		case 'MM/DD/YYYY':
			list($m, $d, $y) = preg_split('/[-\.\/ ]/', $date);
			break;
	}
	return checkdate($m, $d, $y);
}

function changePage($page) {
	global $build, $meta;
	$build->page = $page;
	$meta['body_class'] = $page;
}