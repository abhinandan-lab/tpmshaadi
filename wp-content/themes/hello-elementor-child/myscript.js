jQuery(document).ready(function($) {
                
    var data = {
         'action': 'my_action',
         'content': "Hi I am WordPress Ajax Responce",      // We pass php values differently! id pass kiya hai
     };
     // We can also pass the url value
     //separately from ajaxurl for front end AJAX implementations
     jQuery.post(ajax_object.ajaxurl, data, function(response) {
        // alert(response);
         console.log(response);
     });









     
     
 });
