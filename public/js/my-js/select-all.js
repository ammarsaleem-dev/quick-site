$(".check_all").on('click', function() {
    if ($(this).is(":checked")) {
        $(".custom_name").each(function() {
            $(this).prop("checked", true);
        });
    } else {
        $(".custom_name").each(function() {
            $(this).prop("checked", false);
        });
    }
})