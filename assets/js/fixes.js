$(document).ready(function() {

    function isV8Engine() {
      return /Chrome|Chromium|Edg/.test(navigator.userAgent);
    }
  
    if (isV8Engine()) {
      setInterval(function() {
        $('img[src="null"]').hide();
      }, 5); 
    }
  });