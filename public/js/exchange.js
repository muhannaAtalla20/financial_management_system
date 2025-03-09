(function ($) {
    $(".employee_fields_search").on("input", function (e) {
        let employeeId = $('#employee_id_search').val();
        let employeeName = $('#employee_name_search').val();
        $.ajax({
            url: app_link + "employees/getEmployee", //data-id
            method: "get",
            data: {
                employeeId: employeeId,
                employeeName: employeeName,
                _token: csrf_token,
            },
            success: function (response) {
                $("#table_employee").empty();
                if (response.length != 0) {
                    for (let index = 0; index < response.length; index++) {
                        $("#table_employee").append(
                            "<tr class='employee_select' data-id=" +response[index]["id"] +"><th scope='row'>" +
                                response[index]["id"] +
                                "</th><td>" +
                                response[index]["employee_id"] +
                                "</td><td>" +
                                response[index]["name"] +
                                "</td><td>" +
                                response[index]["date_of_birth"] +
                                "</td></tr>"
                        );
                    }
                }else{
                    $("#table_employee").append(
                        "<tr><td colspan='3'>يرجى التأكد من صحة البيانات</td></tr>"
                    );
                }
            },
        });
    });
    $(".table-hover").delegate("tr.employee_select", "click", function () {
        let employee_id_select = $(this).data("id");
        $("input[name=employee_id]").val(employee_id_select);
        $("#searchEmployee .close").click();
        $.ajax({
            url: app_link + "exchanges/getTotals", //data-id
            method: "post",
            data: {
                employeeId: employee_id_select,
                _token: csrf_token,
            },
            success: function (response) {
                $("#name").empty();
                $("#name").text(response['name']);
                $(".totals").empty();
                $("#receivables_total").text(response['total_receivables']);
                $("#savings_total").text(response['total_savings']);
            },
        });
    });

    $("#exchange_type").on('change',function () {
        let type = $(this).val();
        if(type == "receivables_discount"){
            $("div.exchanges").slideUp();
            $("div#receivables").slideDown();
        }
        if(type == "savings_discount"){
            $("div.exchanges").slideUp();
            $("div#savings").slideDown();
        }
        if(type == "receivables_savings_discount"){
            $("div.exchanges").slideUp();
            $("div#receivables").slideDown();
            $("div#savings").slideDown();
        }
        if(type == "reward"){
            $("div.exchanges").slideUp();
            $("div#reward").slideDown();
        }
        if(type == "association_loan"){
            $("div.exchanges").slideUp();
            $("div#association_loan").slideDown();
        }
        if(type == "savings_loan"){
            $("div.exchanges").slideUp();
            $("div#savings_loan").slideDown();
        }
        if(type == "shekel_loan"){
            $("div.exchanges").slideUp();
            $("div#shekel_loan").slideDown();
        }
        if(type == ""){
            $("div.exchanges").slideUp();
        }
    });

})(jQuery);
