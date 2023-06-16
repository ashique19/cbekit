let page_loader_placeholder = "";

let page_loader_placeholder_fn = function() {
    page_loader_placeholder =
        '<span id="page-loader-placeholder">' +
        $("#page-loader-placeholder").html() +
        "</span>";
    $("#page-loader-placeholder")
        .fadeOut()
        .remove();
    $(window).bind("beforeunload", function() {
        $("body").html(page_loader_placeholder);
    });
};

let loadLiveChat = function() {
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();

    var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = "https://embed.tawk.to/5d27d9fd9b94cd38bbe6ea97/default";
    s1.charset = "UTF-8";
    s1.setAttribute("crossorigin", "*");
    s0.parentNode.insertBefore(s1, s0);
};

$(document).ready(function() {
    page_loader_placeholder_fn();

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    $(".load-live-chat").click(function(e) {
        e.preventDefault();
        loadLiveChat();
    });

    // $(".nicescroll").niceScroll({
    //     cursorwidth: "10px"
    // });

    $(".toggle-user-modal").click(function(e) {
        e.preventDefault();
        $("#user-modal").toggleClass("is-active");
    });

    $(document).on(
        {
            click: function(e) {
                e.preventDefault();

                var toggler = $(this),
                    handles = $(this).data("toggler");

                $(handles).each(function(i, v) {
                    if (
                        toggler
                            .parent()
                            .find('[expand-handle="' + v + '"]')
                            .hasClass("hidden")
                    ) {
                        toggler
                            .parent()
                            .find('[expand-handle="' + v + '"]')
                            .removeClass("hidden");

                        toggler
                            .parent()
                            .find('[data-toggler*="' + v + '"] i')
                            .addClass("fa-minus")
                            .removeClass("fa-plus");
                    } else {
                        toggler
                            .parent()
                            .find('[expand-handle="' + v + '"]')
                            .addClass("hidden");

                        toggler
                            .parent()
                            .find('[data-toggler*="' + v + '"] i')
                            .removeClass("fa-minus")
                            .addClass("fa-plus");
                    }
                });
            }
        },
        "[data-toggler]"
    );
});
