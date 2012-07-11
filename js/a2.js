$(function() {
	//html5 badge!
	$("html").append('<div id="html5"><img src="img/html5.png" alt="HTML5" /></div>');
	$('#searchSubmit').click(function(e) {                       e.preventDefault(); 
		var searchTerm = $('#searchTerm').val();
		if (searchTerm){
			//if the error message is displayed, hide it
			$('#error').hide();            
			$('#showThumbs').show();
			
			//clear out the show photo div
			$("#showPhoto").hide();
			$('#showPhoto').html('');			
			
			//$('#showPhoto').hide(); //photo div should be hidden any time you make a new search
			$.ajax({
				url: 'getThumbs.php?searchTerm=' + searchTerm,
				dataType: 'html',	
				success: function(data) {
					$('#showThumbs').html(data);
					$('.thumb').click(function () {                                          
						var photoId = $(this).attr('id');//get id of the thumbnail that was just clicked	
						
						//unhide the photo div                    
						$("#showPhoto").show();  				
						
						$.ajax({
							url: 'getPhoto.php?photoId=' + photoId,
							dataType: 'html',
							success: function(data) { 
								$('#showPhoto').html(data);
							}
						});	
					});
				}
			});			}
		else{
			if ($('#error').val() == "")
			{
				//display a fancy error message if there's no search term
				$("#error").fadeIn('slow');	
				
				//if any images are showing, hide them
				$('#showThumbs').hide();
				$("#showPhoto").hide();  
				
				var errorMsg = '<p id="errorImg"><img src="img/mondays.jpg" alt="Office Space image" /></p> <p id="errorMsg">You forgot to enter a search term. Looks like someone has a case of the Mondays!</p>';
				$('#error').html(errorMsg);
			}
		}
	});
});   

