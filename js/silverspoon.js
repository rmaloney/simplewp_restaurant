$(document).ready(function(){  
    $('#image_nav').hide(); 
    $('#menu_link').click(function(){
        $('#image_nav').fadeToggle();
        return false;
    }); 

    $('#about_nav').hide(); 
    $('#about_link').click(function(){
        $('#about_nav').fadeToggle();
        return false;
    }); 

      $('#catering_nav').hide(); 
    $('#catering_link').click(function(){
        $('#catering_nav').fadeToggle();
        return false;
    }); 
  
});  