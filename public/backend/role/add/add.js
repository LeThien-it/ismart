$(document).ready(function () {
    $(".checkbox_wrapper").on("click", function () {
        $(this)
            .parents(".card.mb-3")
            .find(".checkbox_children")
            .prop("checked", $(this).prop("checked"));
        // console.log($(this).parents('.card.mb-3').find(".checkbox_children"));
    });

    $("#check_all").on("click", function () {
        $("input:checkbox").prop("checked", this.checked);
    });
});
