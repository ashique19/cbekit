let x = [],
    err = 0;

function extract_data() {
    x = [];
    err = 0;

    $("[identifier]").each(function(i, v) {
        $(v).removeAttr("identifier");
    });

    $(".word-editor .mce-tinymce").remove();

    $("ul.option-block, ol.option-block").each(function(i, v) {
        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = { correct: [] };
        $(v)
            .find("input")
            .each(function(a, b) {
                y[a] = $(b)
                    .parents("li")
                    .text()
                    .trim()
                    .replace(/\s+/g, " ");

                if ($(this).is(":checked")) {
                    y.correct.push({
                        ans: $(b)
                            .parents("li")
                            .text()
                            .trim()
                            .replace(/\s+/g, " "),
                        mark: $(b).attr("data-mark")
                    });
                    y.qref = qref;
                }
            });
        x.push(y);
    });

    $("select.option-block").each(function(i, v) {
        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = { correct: [] };
        $(v)
            .find("option")
            .each(function(a, b) {
                y[a] = $(b)
                    .text()
                    .trim()
                    .replace(/\s+/g, " ");

                if ($(this).attr("selected")) {
                    y.correct.push({
                        ans: $(b)
                            .text()
                            .trim()
                            .replace(/\s+/g, " "),
                        mark: $(b)
                            .parent()
                            .attr("data-mark")
                    });
                    y.qref = qref;
                }
            });

        x.push(y);
    });

    $("select.select-anywhere-option-block").each(function(i, v) {
        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = { correct: [] };
        $(v)
            .find("option")
            .each(function(a, b) {
                y[a] = $(b)
                    .text()
                    .trim()
                    .replace(/\s+/g, " ");

                if ($(this).attr("selected")) {
                    y.correct.push({
                        ans: $(b)
                            .text()
                            .trim()
                            .replace(/\s+/g, " "),
                        mark: $(b)
                            .parent()
                            .attr("data-mark")
                    });
                    y.qref = qref;
                }
            });

        x.push(y);
    });

    $("tr.option-block").each(function(i, v) {
        var list = $(this)
            .parent()
            .find("tr:first-child td:gt(0)");

        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = { correct: [] };
        $(v)
            .find("input")
            .each(function(a, b) {
                y[a] = list
                    .eq(a)
                    .text()
                    .trim()
                    .replace(/\s+/g, " ");

                if ($(this).is(":checked")) {
                    y.correct.push({
                        ans: list
                            .eq(a)
                            .text()
                            .trim()
                            .replace(/\s+/g, " "),

                        mark: $(this).attr("data-mark")
                    });
                    y.qref = qref;
                }
            });

        x.push(y);
    });

    $("input.input-block").each(function(i, v) {
        // var list = $(this).parent().find('tr:first-child td:gt(0)');

        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = {
            "0": $(v).val(),
            correct: [
                {
                    ans: $(v).val(),
                    mark: $(v).attr("data-mark")
                }
            ],
            qref: qref
        };
        x.push(y);
    });

    $(".drag-and-drop-group").each(function(i, v) {
        // var list = $(this).parent().find('tr:first-child td:gt(0)');

        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = { correct: [] };
        $(v)
            .find("input")
            .each(function(a, b) {
                y[a] = $(b)
                    .val()
                    .trim()
                    .replace(/\s+/g, " ");

                y.correct.push({
                    ans: $(b)
                        .val()
                        .trim()
                        .replace(/\s+/g, " "),

                    mark: $(b).attr("data-mark") || 0
                });
                y.qref = qref;
            });

        x.push(y);
    });

    $(".click-to-select").each(function(i, v) {
        // var list = $(this).parent().find('tr:first-child td:gt(0)');

        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = { correct: [] };
        $(v)
            .find("input")
            .each(function(a, b) {
                y[a] = $(b)
                    .val()
                    .trim()
                    .replace(/\s+/g, " ");

                if (
                    $(b)
                        .parent()
                        .hasClass("selected")
                ) {
                    y.correct.push({
                        ans: $(b)
                            .val()
                            .trim()
                            .replace(/\s+/g, " "),

                        mark: $(b).attr("data-mark") || 0
                    });
                    y.qref = qref;
                }
            });

        x.push(y);
    });

    $("textarea.word-element").each(function(i, v) {
        $(this).text($(this).val());

        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = {
            correct: [
                {
                    ans: "",
                    mark: $(this).attr("data-mark")
                }
            ]
        };
        y[0] = "word editor";
        y.qref = qref;

        x.push(y);
    });

    $("textarea.excel-element").each(function(i, v) {
        // var list = $(this).parent().find('tr:first-child td:gt(0)');

        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = {
            correct: [
                {
                    ans: "",
                    mark: $(this).attr("data-mark")
                }
            ]
        };
        y[0] = "excel editor";
        y.qref = qref;

        x.push(y);
    });

    $(".image-map-group").each(function(i, v) {
        // var list = $(this).parent().find('tr:first-child td:gt(0)');

        var qref = q_id + "-" + Math.round(Math.random() * 1000000);
        $(this).attr("qref", qref);

        var y = { correct: [] };
        y.correct.push({
            ans: $(v)
                .find(".draggable input")
                .first()
                .val()
                .trim()
                .replace(/\s+/g, " "),
            mark: $(v)
                .find(".draggable input")
                .first()
                .attr("data-mark")
        });
        y[0] = $(v)
            .find(".draggable input")
            .first()
            .val();
        y.qref = qref;

        x.push(y);
    });

    console.log(x);
}

$(document).ready(function() {
    $(document).on(
        {
            submit: function(e) {
                e.preventDefault();

                var form = $(this),
                    url = form.attr("action"),
                    button = form.find('button[type="submit"]'),
                    message = form.find("p.message");
                q_id = form.attr("q_id");

                // button.addClass('is-loading');
                message.text("");

                extract_data();

                x.forEach(y => {
                    if (y.correct.length == 0) {
                        err++;
                    } else {
                        $.each(y.correct, function(r, s) {
                            if (s.mark * 1 == 0) err++;
                            if (isNaN(s.mark * 1)) err++;
                        });
                    }
                });

                if (err > 0) {
                    $("#q-options").modal("show");
                    $("#marker-container").html(
                        `<hr><p class="red-text">Looks like, you missed correct answer or marking somewhere. Please check and retry.</p><hr>`
                    );
                    return;
                }

                data = {
                    name: form.find('[name="name"]').val(),
                    _token: form.find('[name="_token"]').val(),
                    _method: form.find('[name="_method"]').val(),
                    question_id: form.find('[name="question_id"]').val(),
                    section: form.find('[name="section"]:checked').val(),
                    marking_type: form.find('[name="marking"]:checked').val(),
                    detail: form
                        .find(".note-editable")
                        .first()
                        .html(),
                    explanation: form.find('[name="explanation"]').val(),
                    // marks_each_ans: marks_each_ans,
                    options: x
                };

                $.post(url, data, function(result) {
                    button.removeClass("is-loading");

                    if (result * 1 == 1) {
                        message.text("Question has been saved successfully.");

                        setTimeout(function() {
                            window.location.reload();
                            window.location.href = window.location.href;
                        }, 1000);
                    } else {
                        message.text(
                            "Failed to save data. Please reload the page and retry."
                        );
                    }
                });
            }
        },
        ".add-question"
    );

    $(document).on("keyup focusout", "#mark-input", function() {
        if (isNaN($(this).val() * 1)) {
            $(this).val(0);
        } else {
            $(this).val($(this).val() * 1);
        }
    });

    $(document).on(
        {
            submit: function(e) {
                e.preventDefault();

                var form = $(this),
                    url = form.attr("action"),
                    button = form.find('button[type="submit"]'),
                    message = form.find("p.message");

                (q_id = form.attr("action").split("questions/")[1]), (x = []);

                message.text("");

                extract_data();

                x.forEach(y => {
                    if (y.correct.length == 0) {
                        err++;
                    } else {
                        $.each(y.correct, function(r, s) {
                            if (s.mark * 1 == 0) err++;
                        });
                    }
                });

                if (err > 0) {
                    $("#q-options").modal("show");
                    $("#marker-container").html(
                        `<hr><p class="red-text">Looks like, you missed correct answer or marking somewhere. Please check and retry.</p><hr>`
                    );
                    return;
                }

                button.addClass("is-loading");

                var detail = `<div class="column is-12 columns multipart-b padding-5">`;
                form.find(".note-editable").each(function(i, v) {
                    if ($(v).parents(".explanation-container").length == 0)
                        detail +=
                            `<div class="column is-6 white-bg black-text padding-bottom-40 padding-5">` +
                            $(v).html() +
                            `</div>`;
                });
                detail += `</div>`;

                data = {
                    name: form.find('[name="name"]').val(),
                    _token: form.find('[name="_token"]').val(),
                    _method: form.find('[name="_method"]').val(),
                    question_id: form.find('[name="question_id"]').val(),
                    section: form.find('[name="section"]:checked').val(),
                    marking_type: form.find('[name="marking"]:checked').val(),
                    display_helper:
                        form.find('[name="display_helper"]').length > 0
                            ? form.find('[name="display_helper"]').val()
                            : "",
                    detail: detail,
                    explanation: form.find('[name="explanation"]').val(),
                    // marks_each_ans: marks_each_ans,
                    options: x
                };

                $.post(url, data, function(result) {
                    button.removeClass("is-loading");

                    if (result * 1 == 1) {
                        message.text("Question has been saved successfully.");

                        setTimeout(function() {
                            window.location.reload();
                            window.location.href = window.location.href;
                        }, 1000);
                    } else {
                        message.text(
                            "Failed to save data. Please reload the page and retry."
                        );
                    }
                });
            }
        },
        ".add-part-B-question"
    );
});
