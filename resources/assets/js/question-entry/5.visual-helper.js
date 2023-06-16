$(document).ready(function() {
    window.ans = typeof old_ans != "undefined" ? old_ans : [];

    setTimeout(() => {
        ans.forEach((v, i) => {
            // var answers =
            //     v.name.search(/\[/) > -1
            //         ? JSON.parse(v.name).filter(b => {
            //               return b;
            //           })
            //         : [v.name];

            var answers = v.name;

            $(
                'ul.option-block[qref="' +
                    v.qref +
                    '"], ol.option-block[qref="' +
                    v.qref +
                    '"]'
            )
                .first()
                .find("input")
                .each(function(index, value) {
                    var q = $(value)
                        .parents("li")
                        .text()
                        .trim()
                        .replace(/\s+/g, " ");

                    if (answers.indexOf(q) > -1) {
                        $(value).prop("checked", true);
                        $(value).attr("data-mark", v.marks);
                    }
                });

            $('select.option-block[qref="' + v.qref + '"]')
                .first()
                .find("option")
                .each(function(index, value) {
                    var q = $(value).attr("value");

                    answers.indexOf(q) > -1
                        ? $(value).prop("selected", true)
                        : false;
                });

            $('select.select-anywhere-option-block[qref="' + v.qref + '"]')
                .first()
                .find("option")
                .each(function(index, value) {
                    var q = $(value).attr("value");

                    answers.indexOf(q) > -1
                        ? $(value).prop("selected", true)
                        : false;
                });

            $('tr.option-block[qref="' + v.qref + '"]')
                .first()
                .each(function(index, value) {
                    var ind = $(value)
                        .parent()
                        .find('tr:first-child td:contains("' + v.name + '")')
                        .index();

                    $(value)
                        .find("td:eq(" + ind + ") input")
                        .prop("checked", true);
                });

            $('input.input-block[qref="' + v.qref + '"]').val(v.name);
        });
    }, 1000);
});
