(function($){
    $("#type_appointment").on('change',function () {
        let type = $(this).val();
        if(type == "مثبت"){
            $("div#proven").slideDown();
            $("div#notProven").slideUp();
            $("div#daily").slideUp();
        }
        if(type == "نسبة"){
            $("div#proven").slideUp();
            $("div#notProven").slideUp();
            $("div#daily").slideUp();
        }
        if(type == "يومي"){
            $("div#proven").slideUp();
            $("div#notProven").slideUp();
            $("div#daily").slideDown();
        }
        if(type != "مثبت" && type != "نسبة" && type != "يومي"){
            $("div#proven").slideUp();
            $("div#notProven").slideDown();
            $("div#daily").slideUp();
        }
    });
})(jQuery);

