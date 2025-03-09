(function($){
    $("#report_type").on('change',function () {
        let type = $(this).val();
        if(type == "bank"){
            $("div#bankDiv").slideDown();
        }
        else{
            $("div#bankDiv").slideUp();
        }
    });
    $("#exchange_type").on('change',function () {
        let type = $(this).val();
        if(type == "bank"){
            $("div#bank_select").slideDown();
        }
        else{
            $("div#bank_select").slideUp();
        }
    });
})(jQuery);
