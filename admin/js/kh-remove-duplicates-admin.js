(function( $ ) {
	//'use strict';

$( window ).load(function() {
	//$(document).ready(function($) {
	event.preventDefault();
    event.stopPropagation();
    // We'll pass this variable to the PHP function example_ajax_request
    $('.remove_duplicate_posts').click(function(){
		
	//var fruit = 'Banana';
	//console.log('what');
    // This does the ajax request
    //return false;
    $('#saysomething').html('<br><span id="infobox">We are searching and deleting posts in the background. Feel free to navigate to other pages.</span>');
    $.ajax({
        url: ajaxurl,
        data: {
            'action':'do_remove_duplicate_posts','test':'ok'
        },
        success:function(data) {
            // This outputs the result of the ajax request
            console.log(data);
			$('#saysomething').html('<br><span id="infobox">Completed! Refresh this page.</span>');
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
		
    });
		
	})
       
});

})( jQuery );
