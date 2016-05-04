

$(function () {
    console.log("a intrat");
    $(".question_menu").on("click", ".add_button", function () {
        $("form.questions_list").show();
        console.log("add");
    });

    $(".quiz_table").on("click", ".delete_button", function () {

        if (confirm("Do you really wan't to delete?")) {
            $.post($(this).attr('href') + '&confirm=yes', function () {
            });
        }

    });
    $("input.quiz_name").on("blur", function () {
            console.log("test2" + $(this).val());
            var quiz_name = $(this).val();
            $.post(window.location.href+'&save_name='+quiz_name, function () {
            });
    });
    $(".quiz_name").on("keyup paste", "input", function () {
        console.log("test2" + this.val());

    });

});

