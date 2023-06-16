$(document).ready(function() {
    $(".air").summernote({
        airMode: true,
        hint: {
            match: /\b(\w{1,})$/,
            search: function(keyword, callback) {
                callback(
                    $.grep(search_hints, function(item) {
                        return item.indexOf(keyword) >= 0;
                    })
                );
            },
            content: function(item) {
                $(document.getSelection().anchorNode.parentNode).append(
                    $(search_source[search_hints.indexOf(item)])[0]
                );

                if (item == "word editor") {
                    tinymce.init({
                        selector: ".note-editable textarea.word-element",
                        plugins: ["table"],
                        menubar: false,
                        toolbar: ["table"],
                        height: 400
                    });
                }

                return "";
            }
        },
        callbacks: {
            onChange: function(contents, $editable) {
                $(".image-map-group .draggable").each(function(i, v) {
                    $(v).css({ top: i + 1 + 25 + "px" });

                    $(v).draggable({
                        containment: "parent",
                        stop: function(e, ui) {
                            $(v)
                                .find("input")
                                .val(
                                    ui.position.left +
                                        "-" +
                                        $(v).width() +
                                        ":" +
                                        ui.position.top +
                                        "-" +
                                        $(v).height()
                                );
                        }
                    });
                });
            }
        }
    });

    $(".summernote").summernote({
        minHeight: 200
    });

    $(document).on(
        {
            "keyup change": function() {
                $(this).focus();
            },

            click: function() {
                var button = $(this),
                    max = button.parents(".click-to-select").data("max") * 1;

                if (button.hasClass("selected")) {
                    button.removeClass("selected");
                } else {
                    if (
                        button
                            .parents(".click-to-select")
                            .find(".button.selected").length < max
                    ) {
                        button.addClass("selected");
                    }
                }
            }
        },
        ".click-to-select .button"
    );

    // Drag and Drop
    $(document).on(
        {
            keyup: function() {
                $(this)
                    .attr(
                        "value",
                        $(this)
                            .parents(".drag-and-drop-group")
                            .find(".draggable")
                            .eq($(this).val() * 1 - 1)
                            .text()
                            .trim()
                    )
                    .val(
                        $(this)
                            .parents(".drag-and-drop-group")
                            .find(".draggable")
                            .eq($(this).val() * 1 - 1)
                            .text()
                            .trim()
                    );
            }
        },
        ".droppable input"
    );

    $(document).on(
        {
            mouseenter: function() {
                $(this).append(
                    `<button type="button" class="add-draggable">add draggable</button>`
                );
            },

            mouseleave: function() {
                $(this)
                    .find(".add-draggable")
                    .remove();
            }
        },
        ".draggable-holder"
    );

    $(document).on(
        {
            click: function() {
                $(this)
                    .parent()
                    .append(`<li class="draggable"><span></span></li>`);
            }
        },
        ".add-draggable"
    );

    $(document).on(
        {
            mouseenter: function() {
                $(this).append(
                    `<button type="button" class="add-box">add box</button><button type="button" class="add-droppable">add droppable</button><button type="button" class="add-draggable">add section</button>`
                );
            },

            mouseleave: function() {
                $(this)
                    .find(".add-box, .add-droppable, .add-draggable")
                    .remove();
            }
        },
        ".drag-or-droppable-holder"
    );

    $(document).on(
        {
            click: function() {
                $(this)
                    .parent()
                    .append(`<li><span></span></li>`);
            }
        },
        ".drag-or-droppable-holder .add-box"
    );

    $(document).on(
        {
            click: function() {
                $(this)
                    .parent()
                    .append(
                        `<li class="droppable"><input type="text" data-mark /></li>`
                    );
            }
        },
        ".drag-or-droppable-holder .add-droppable"
    );
    // END: Drag and Drop

    // Click to select
    $(document).on(
        {
            click: function() {
                if ($(this).hasClass("selected")) {
                    $(this).removeClass("selected");
                    $(this)
                        .find('input[type="checkbox"]')
                        .prop("checked", false);
                } else {
                    $(this).addClass("selected");
                    $(this)
                        .find('input[type="checkbox"]')
                        .prop("checked", true);
                }
            },
            DOMSubtreeModified: function() {
                $(this)
                    .find("input")
                    .val(
                        $(this)
                            .text()
                            .trim()
                    );
            }
        },
        ".click-to-select-input"
    );
    // END: click to select

    // Multi part
    $(".add-editor-to-group").click(function() {
        new Promise((resolve, reject) => {
            $("#editor-group").append(`
                <div class="column is-6 editor-container offwhite-bg black-text padding-bottom-40 padding-10 white-border-right-5">
                    <button type="button" class="del-parent tag is-danger"><i class="fa fa-trash"></i></button>
                    <textarea name="detail[]" class="textarea air" placeholder="Question block" rows="10" ></textarea>
                </div>
            `);
            resolve();
        }).then(_ => {
            setTimeout(_ => {
                $("#editor-group .editor-container:last-child .air").summernote(
                    {
                        airMode: true,
                        hint: {
                            match: /\b(\w{1,})$/,
                            search: function(keyword, callback) {
                                callback(
                                    $.grep(search_hints, function(item) {
                                        return item.indexOf(keyword) >= 0;
                                    })
                                );
                            },
                            content: function(item) {
                                // console.log(item);
                                $(
                                    document.getSelection().anchorNode
                                        .parentNode
                                ).append(
                                    $(
                                        search_source[
                                            search_hints.indexOf(item)
                                        ]
                                    )[0]
                                );

                                if (item == "word editor") {
                                    tinymce.init({
                                        selector:
                                            ".note-editable textarea.word-element",
                                        plugins: ["table"],
                                        menubar: false,
                                        toolbar: ["table"],
                                        height: 400
                                    });
                                }

                                return "";

                                // return $( search_source[search_hints.indexOf(item)] )[0];
                            }
                        },
                        callbacks: {
                            onChange: function(contents, $editable) {
                                // console.log(contents);
                                var marks_each_ans =
                                        $("[name=marks]").val() * 1,
                                    total_ans = 0,
                                    total_marks = 0;

                                $(".option-block").each(function(i, v) {
                                    $(v)
                                        .find("input")
                                        .attr({ name: i + "input" });

                                    total_ans +=
                                        $(v).find("input:checked").length * 1;

                                    total_ans +=
                                        $(v).find("option:selected").length * 1;
                                });

                                total_marks = total_ans * marks_each_ans;

                                $(".total-marks").text(
                                    "Total Mark: " + total_marks
                                );
                            }
                        }
                    }
                );
            }, 300);
        });
    });

    $(document).on(
        {
            click: function() {
                $(this)
                    .parent()
                    .remove();
            }
        },
        ".del-parent"
    );
    // END: Multi part

    // Marking
    $(document).on(
        "contextmenu",
        "[data-mark], .click-to-select-input, .draggable, textarea[data-mark], .mce-tinymce.mce-container.mce-panel",
        function(e) {
            e.preventDefault();

            let that = $(this);

            let identifier =
                $(this).hasClass("click-to-select-input") ||
                $(this).hasClass("draggable")
                    ? $(this).children("input")
                    : $(this);

            identifier = that.hasClass("mce-container")
                ? that.next("textarea")
                : identifier;

            let code = Math.round(Math.random() * 100000),
                mark = identifier.attr("data-mark"),
                tag = identifier[0].localName,
                marker_modal_html = ``;
            identifier.attr("identifier", code);

            if (tag == "input" || tag == "textarea") {
                if (identifier.attr("type") == "text") {
                    // if input box
                    marker_modal_html = `
            <div class="field has-addons" data-toggle="tooltip" data-title="Enter digits only">
                <p class="button" id="mark-target">
                    Mark
                </p>
                <p class="control">
                    <input class="input width-100" type="text" value="${mark}" placeholder="Mark" id="mark-input" target="${code}">
                </p>
            </div>
            <div class="field has-addons" data-toggle="tooltip" data-title="Enter digits only">
                <p class="button" id="mark-target">
                    Input
                </p>
                <p class="control">
                    <input class="input width-100" type="text" value="${$(
                        identifier
                    ).val()}" placeholder="enter value for input box" id="text-input">
                </p>
            </div>
            <div class="field has-addons" data-toggle="tooltip" data-title="Enter digits only">
                <p class="control">
                    <button type="button" class="button" id="update-mark">
                    Update
                    </button>
                </p>
            </div>
            `;
                } else {
                    marker_modal_html = `
            <div class="field has-addons" data-toggle="tooltip" data-title="Enter digits only">
                <p class="button" id="mark-target">
                    Mark
                </p>
                <p class="control">
                    <input class="input width-100" type="text" value="${mark}" placeholder="Mark" id="mark-input" target="${code}">
                </p>
                <p class="control">
                    <button type="button" class="button" id="update-mark">
                    Update
                    </button>
                </p>
            </div>
            `;
                }
            }

            if (tag == "select") {
                marker_modal_html = `
            <div class="field has-addons" data-toggle="tooltip" data-title="Enter digits only">
                <p class="button" id="mark-target">
                    Mark
                </p>
                <p class="control">
                    <input class="input width-150" type="text" value="${mark}" placeholder="Mark" id="mark-input" target="${code}">
                </p>
            </div>
            <hr>
            <p class="font-size-12 margin-0 red-text">Everytime you open this window, you will find 2 extra options.</p>
            <hr>
            `;

                $(identifier)
                    .find("option")
                    .each(function(i, v) {
                        marker_modal_html += `
                <div class="field has-addons">
                    <p class="button padding-right-10">
                        <input class="radio" type="radio" name="correct_" ${
                            $(v).attr("selected") ? "checked" : ""
                        } >
                    </p>
                    <p class="control" data-toggle="tooltip" data-title="Leave empty to remove">
                        <input class="input width-150" type="text" value="${$(
                            v
                        ).text()}" option >
                    </p>
                </div>
                `;
                    });

                marker_modal_html += `
                <div class="field has-addons"><p class="button padding-right-10"><input class="radio" name="correct_" type="radio" ></p><p class="control"><input class="input width-150" type="text" option ></p></div>
                <div class="field has-addons"><p class="button padding-right-10"><input class="radio" name="correct_" type="radio" ></p><p class="control"><input class="input width-150" type="text" option ></p></div>
            `;

                marker_modal_html += `
            <div class="field has-addons">
                <p class="control">
                    <button type="button" class="button" id="update-mark">
                    Update
                    </button>
                </p>
            </div>
            `;
            }

            $("#marker-container")
                .html(marker_modal_html)
                .find('[data-toggle="tooltip"]')
                .tooltip();

            $("#q-options").modal("show");
        }
    );

    $(document).on("click", "#update-mark", function(e) {
        e.preventDefault();
        let target = $(document)
                .find('[identifier="' + $("#mark-input").attr("target") + '"]')
                .first(),
            mark = $("#mark-input").val(),
            tag = target[0].localName;

        if (tag == "select") {
            let options = ``;
            $(document)
                .find("[option]")
                .each(function(i, v) {
                    if ($(v).val().length > 0)
                        options += `<option value="${$(v).val()}" ${
                            $(v)
                                .parent()
                                .prev()
                                .children('input[type="radio"]')
                                .first()
                                .is(":checked")
                                ? "selected"
                                : ""
                        } >${$(v).val()}</option>`;
                });
            target.html(options);
        }

        if (target.attr("type") == "text") {
            target.val($("#text-input").val());
        }

        target.attr("data-mark", mark);

        let total_mark = 0;
        $("[data-mark]").each(function(i, v) {
            total_mark += $(v).attr("data-mark") * 1 || 0;
        });
        $(".total-marks").html("Total Mark: " + total_mark);

        $("#q-options").modal("hide");
    });
    // End: Marking
});
