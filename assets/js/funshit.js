

$(document).ready(function() {
    var replacementText = "regean";
    var conservativeWords = ["fuck", "I", "You", "We", "we", "i", "you", "they", "They", "Them", "them",
        "He", "he", "she", "She", "her", "Her", "Him", "him", "Gay", "gay", "trans", "Trans","Transgender"
        ,"hippie","Hippie","hippies","Hippies"
    ];

    function replaceWordsInElements(selector, words, replacement) {
        $(selector).each(function() {
            var element = $(this);
            var content = element.text();
            words.forEach(function(word) {
                var regex = new RegExp("\\b" + word + "\\b", "gi");
                content = content.replace(regex, replacement);
            });
            element.text(content);
        });
    }

    function replaceAllText(selector, replacement) {
        $(selector).each(function() {
            $(this).text(replacement);
        });
    }

    function applyStyles(styles) {
        $('style[data-custom]').remove();

        var style = $('<style>', {
            'data-custom': 'true',
            type: 'text/css',
            text: styles
        }).appendTo('head');
    }

    function updateText() {
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);

        var reganStyles = `
            p.post-content {
                color: red; 
            }
        `;
        var conservativeStyles = `
            p.post-content {
                color: blue; 
            }
        `;
        var trumpStyles = `
            p.post-content {

            }
        `;

        if (urlParams.has('maga')) {
            replaceWordsInElements("p.post-content", conservativeWords, "trump");
            console.log("Text replaced with 'trump'.");
            applyStyles(trumpStyles);
        } else if (urlParams.has('reagan')) {
            replaceAllText("p.post-content", replacementText);
            console.log("All text replaced with 'reagan'.");
            applyStyles(reganStyles);
        } else if (urlParams.has('conservative')) {
            replaceWordsInElements("p.post-content", conservativeWords, replacementText);
            console.log("Swear words and pronouns replaced with 'reagan'.");
            applyStyles(conservativeStyles);
        } else {
            console.log("No relevant URL parameter found.");
        }
    }

    setTimeout(function() {
        updateText();
        setInterval(updateText, 5000);
    }, 1000);
});

$(document).ready(function() {
    function enableLightbulbMode() {

        var $overlay = $('<div>', { class: 'lightbulb-overlay' }).appendTo('body');
        var $spotlight = $('<div>', { class: 'lightbulb-spot' }).appendTo('body');
        const $content = $('.content'); 

        $content.css({
            background: 'url("https://www.georgiarecycles.org/wp-content/uploads/2023/09/Lightbulbs-960x500.jpg")'
        });
        
        $overlay.css({
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            background: 'rgba(0, 0, 0, 1)', 
            pointerEvents: 'none',
            zIndex: 1000,
            overflow: 'hidden'
        });

        $spotlight.css({
            position: 'absolute',
            borderRadius: '50%',
            background: 'rgba(0, 0, 0, 0)', 
            boxShadow: '0 0 50px rgba(255, 255, 0, 0.6)', 
            width: '150px', 
            height: '150px', 
            zIndex: 1001
        });


        $('body').css({ 
                cursor: 'url(http://www.javascriptkit.com/jkincludes/search.gif), auto'
            });

        $(document).on('mousemove', function(e) {
            var x = e.pageX;
            var y = e.pageY;
            $spotlight.css({
                left: x - $spotlight.width() / 2,
                top: y - $spotlight.height() / 2
            });
        });

        function refreshOverlay() {

            var width = $(window).width();
            var height = $(window).height();

            $spotlight.css({
                left: $spotlight.position().left,
                top: $spotlight.position().top
            });

            var spotlightPosition = $spotlight.position();
            var spotlightRadius = $spotlight.width() / 2;
            var gradient = `
                radial-gradient(circle at ${spotlightPosition.left + spotlightRadius}px ${spotlightPosition.top + spotlightRadius}px, rgba(0, 0, 0, 0) ${spotlightRadius}px, rgba(0, 0, 0, 1) 100%)
            `;
            $overlay.css({
                background: gradient
            });
        }

        $(document).on('mousemove', refreshOverlay);

        $(window).on('resize', refreshOverlay);

        refreshOverlay();
    }

    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

    if (urlParams.has('lightbulb')) {
        enableLightbulbMode();
        console.log("Lightbulb mode activated.");
    }
});