(function ($) {
    let number_of_days = 0;
    let today_price = 0;
    $('.daily_fields').on('input', function () {
        let name = $(this).data("name");
        let employee_id = $(this).data("id");
        if(name == 'number_of_days') {
            number_of_days = $(this).val();
        }
        if(name == 'today_price') {
            today_price = $(this).val();
        }
        let total = number_of_days * today_price;
        $('input#'+ employee_id).val(total);
    });
})(jQuery);
