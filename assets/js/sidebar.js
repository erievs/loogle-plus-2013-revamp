// This handles the sidebar for most pages, this isn't used by photos.

$(document).ready(function() {
    const sidebar = $('.sidebar');
    const openSidebarButton = $('#open-sidebar');
    let sidebarOpen = false;

    openSidebarButton.on('click', function() {
        if (!sidebarOpen) {
            sidebar.css('transform', 'translateX(0)');
            sidebarOpen = true;
        } else {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });

    $(document).on('click', function(event) {
        if (sidebarOpen && !$(event.target).closest('.sidebar').length && event.target !== openSidebarButton[0]) {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });
});

$(document).ready(function() {
    $(document).keydown(function(e) {
        if (e.key === "Escape") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });

    $(document).on("click dblclick", function(e) {
        if (!$(e.target).closest(".sidebar").length || e.type === "dblclick") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });
});

$(document).ready(function() {
    const sidebar = $('.sidebar');
    const openSidebarButton = $('#open-sidebar-1');
    let sidebarOpen = false;

    openSidebarButton.on('click', function() {
        if (!sidebarOpen) {
            sidebar.css('transform', 'translateX(0)');
            sidebarOpen = true;
        } else {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });

    $(document).on('click', function(event) {
        if (sidebarOpen && !$(event.target).closest('.sidebar').length && event.target !== openSidebarButton[0]) {
            sidebar.css('transform', 'translateX(-100%)');
            sidebarOpen = false;
        }
    });
});

$(document).ready(function() {
    $(document).keydown(function(e) {
        if (e.key === "Escape") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });

    $(document).on("click dblclick", function(e) {
        if (!$(e.target).closest(".sidebar").length || e.type === "dblclick") {
            $(".sidebar").css("transform", "translateX(-100%)");
        }
    });
});

$(document).ready(function() {
    $(".dropdown-toggle").click(function(e) {
        e.preventDefault();
        var $dropdownMenu = $(this).next(".dropdown-menu");
        $dropdownMenu.toggleClass("show");
    });

    $(document).click(function(e) {
        if (!$(e.target).closest(".dropdown-toggle").length && $(".dropdown-menu").hasClass("show")) {
            $(".dropdown-menu").removeClass("show");
        }
    });
});

$(document).ready(function() {
    $('#al1').on('input', function() {
        var linkInput = $(this).val().trim();
        if (!linkInput.startsWith('http://')) {
            linkInput = 'http://' + linkInput;
            $(this).val(linkInput);
        }
    });
});

