$(document).ready(function() {

$("img").each(function() {
    console.log('Your mom');
    if ($(this).attr("src") === "http://kspc.serv00.net/null") {
        $(this).hide();
    }
});

$("img").each(function() {
    console.log('Your mom');
    if ($(this).attr("src") === "https://kspc.serv00.net/null") {
        $(this).hide();
    }
});

$("img").each(function() {
    console.log('Your mom');
    if ($(this).attr("src") === "null") {
        $(this).hide();
    }
});

});