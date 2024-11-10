
$('.w-tip').tipsy();
$('.b-autoheight').autoheight({minimum: 60});
setTimeout(function(){
    $('#header-notifications a').text(1).addClass('active');
}, 3000);