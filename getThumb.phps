<?php	
    $searchTerm = $_GET['searchTerm'];
	$apiKey = "1fae7abeb22ecc71ee56c6e2cdab2a93"; 
	
    //url request stuff!
	$url = "http://api.flickr.com/services/rest/?method=flickr.photos.search";
	$url .= "&api_key=". $apiKey;
	$url .= "&tags=". urlencode($searchTerm);
	$url .= "&per_page=40";
    $url .= "&extras=date_taken";
	$url .= "&format=rest"; 
	
	//initialize curl session
    $ch = curl_init();	
	
	//set curl options
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    curl_setopt($ch, CURLOPT_URL, $url);
	
	//get the response back for the request
    $curlResponse = curl_exec($ch);
    curl_close($ch);    
	
	//make the curl response an xml object
    $xmlObject = simplexml_load_string($curlResponse);   
    
	print '<ul>';      
	//loop through the xml ojbect and parse the stuff needed for the image urls
	foreach($xmlObject->photos->photo as $photo){            
		$farmId = $photo['farm'];
        $serverId = $photo['server'];
        $id = $photo['id'];
        $secret = $photo['secret'];
        $title = $photo['title'];	
        $dateTaken = $photo['datetaken'];
        
        //format the date        
        $date = date("l, F j Y", strtotime($dateTaken));
        
        //make sure the photo was taken on a Monday
        if(strstr($date, "Monday"))
        {
            print '<li>';
                print '<img id="'.$id.'" class="thumb" src="http://farm'.$farmId.'.static.flickr.com/'.$serverId.'/'.$id.'_'.$secret.'_s.jpg" alt="'.$title.'" />';
            print '</li>';
        }
	}
	print '</ul>';
?>