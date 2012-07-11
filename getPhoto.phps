<?php    
	$photoId = $_GET['photoId'];   
    $apiKey = "1fae7abeb22ecc71ee56c6e2cdab2a93";    
       
    //url request stuff!
	$url = "http://api.flickr.com/services/rest/?method=flickr.photos.getInfo";
	$url .= "&api_key=". $apiKey;
	$url .= "&photo_id=". urlencode($photoId);	
	$url .= "&format=rest";    
     
	//initialize curl session
    $ch = curl_init();	

	//set curl options
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);	

	//get the response back for the request
    $curlResponse = curl_exec($ch);
    
    curl_close($ch);    	

	//make the curl response an xml object
    $xmlObject = simplexml_load_string($curlResponse);   
    
    //print the xml for debugging
    print "<pre>".htmlentities($xmlObject->asXML())."</pre>";
    
	foreach($xmlObject->photo as $photo){
		$author = $photo->owner['username'];
        $title = $photo->title;
        $dateTaken = $photo->dates['taken'];	
        
        //format the date        
        $date = date("l, F j Y", strtotime($dateTaken));
        
        //loop through the sizes to get the image url 
		foreach($photo->sizes->size as $size){            
			if($size['label'] == "Small 320"){	//lets go with the small image, so it doesnt't take up too much space 
				$largeImg = $size['source'];
			}
		}        

        print '<div id="photoDisplay">';
            print '<p><img src="'. $largeImg .'" alt="'.$title.'" />';
            if($title == ''){
                print '<h2>Untitled</h2>';
            }else{          
                print '<h2>"'. $title .'"</h2>';
            }
            print '<p>Taken by: '. $author .'</p>';
            print '<p>Date taken: '. $date .'</p>';
        print '</div>';                
	}	
?>