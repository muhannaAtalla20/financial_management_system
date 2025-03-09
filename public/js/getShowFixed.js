(function ($) {
    $("#monthInputSearch").on("input", function () {
        let month = $(this).val();
        $.ajax({
            url: app_link + "fixed_entries", // Replace with your Laravel route URL
            method: "GET",
            data: {
                monthChange: true,
                month: month, // Replace with the current month you want to show
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("#fixed_entries_table").empty();
                if (response.length != 0) {
                    for (let index = 0; index < response.length; index++) {
                        $("#fixed_entries_table").append(`
                                    <tr class="fixed_select" data-id="`+response[index]['id']+`">
                                        <td>`+ response[index]['employee']['id'] +`</td>
                                        <td>`+ response[index]['employee']['name'] +`</td>
                                        <td>`+ response[index]['administrative_allowance'] +`</td>
                                        <td>`+ response[index]['scientific_qualification_allowance'] +`</td>
                                        <td>`+ response[index]['transport'] +`</td>
                                        <td>`+ response[index]['extra_allowance'] +`</td>
                                        <td>`+ response[index]['salary_allowance'] +`</td>
                                        <td>`+ response[index]['ex_addition'] +`</td>
                                        <td>`+ response[index]['mobile_allowance'] +`</td>
                                        <td>`+ response[index]['health_insurance'] +`</td>
                                        <td>`+ response[index]['f_Oredo'] +`</td>
                                        <td>`+ response[index]['association_loan'] +`</td>
                                        <td>`+ response[index]['tuition_fees'] +`</td>
                                        <td>`+ response[index]['voluntary_contributions'] +`</td>
                                    </tr>`);
                    }
                }else{
                    $("#fixed_entries_table").append(
                        '<tr><td colspan="14" class="text-center text-danger">لا يوجد بيانات لعرضها"></td></tr>'
                    );
                }
            },
            error: function (error) {
                console.error("Error :", error);
            },
        });
    });

    let fixed_entrie;
    $(".table-hover").delegate("tr.fixed_select", "click", function () {
        fixed_entrie = $(this).data("id");
        let monthNow = $("#monthInputSearch").val();
        $.ajax({
            url: app_link + "fixed_entries/" + fixed_entrie, // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                month: monthNow, // Replace with the current month you want to show
                fixed_entrie: fixed_entrie,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("#tableShowFixed").remove();
                $("div.modal-footer a").remove();
                $("div.modal-footer form").remove();
                $("#monthModalSearch").val(monthNow);
                let modalDiv =`
                                <table  class="table table-striped table-bordered" id="tableShowFixed">
                                <tr>
                                    <th scope="row">اسم الموظف</th>
                                    <th  scope="row">`+ response['employee']['name'] +`</th>
                                </tr>
                                <tr>
                                    <td>علاوة إدارية</td>
                                    <td>`+ response['administrative_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة مؤهل علمي</td>
                                    <td>`+ response['scientific_qualification_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>مواصلات</td>
                                    <td>`+ response['transport'] +`</td>
                                </tr>
                                <tr>
                                    <td>بدل إضافي</td>
                                    <td>`+ response['extra_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة أغراض راتب</td>
                                    <td>`+ response['salary_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة إضافة بأثر رجعي</td>
                                    <td>`+ response['ex_addition'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة جوال</td>
                                    <td>`+ response['mobile_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>تأمين صحي</td>
                                    <td>`+ response['health_insurance'] +`</td>
                                </tr>
                                <tr>
                                    <td>ف. أوريدو</td>
                                    <td>`+ response['f_Oredo'] +`</td>
                                </tr>
                                <tr>
                                    <td>قرض جمعية</td>
                                    <td>`+ response['association_loan'] +`</td>
                                </tr>
                                <tr>
                                    <td>رسوم دراسية</td>
                                    <td>`+ response['tuition_fees'] +`</td>
                                </tr>
                                <tr>
                                    <td>تبرعات</td>
                                    <td>`+ response['voluntary_contributions'] +`</td>
                                </tr>
                                <tr>
                                    <td>قرض إدخار</td>
                                    <td>`+ response['savings_loan'] +`</td>
                                </tr>
                                <tr>
                                    <td>قرض شيكل</td>
                                    <td>`+ response['shekel_loan'] +`</td>
                                </tr>
                                <tr>
                                    <td>خصم اللجنة</td>
                                    <td>`+ response['paradise_discount'] +`</td>
                                </tr>
                                <tr>
                                    <td>خصومات أخرى</td>
                                    <td>`+ response['other_discounts'] +`</td>
                                </tr>
                                <tr>
                                    <td>تبرعات للحركة</td>
                                    <td>`+ response['proportion_voluntary'] +`</td>
                                </tr>
                                <tr>
                                    <td>إدخار 5%</td>
                                    <td>`+ response['savings_rate'] +`</td>
                                </tr>
                                </table>
                            `;
                $("div#showFixed").append(modalDiv);
                $("div.modal-footer").append(`
                    <form action="`+app_link+`fixed_entries/`+ response['employee_id'] +`" method="post" class="mr-3">
                        <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin: 0.5rem -0.75rem; text-align: right;"
                        href="#">حذف</button>
                    </form>
                `);
                $("div.modal-footer").append(`<a href="`+app_link+`fixed_entries/`+ response['employee_id'] +`/edit" target="_blank" class="btn btn-primary mr-3">تعديل</a>`);
                $("#openModalShow").click();
            },
            error: function (error) {
                console.error("Error: ", error);
            },
        });
    });
    $("#monthModalSearch").on("input", function () {
        let monthNow = $(this).val();
        $.ajax({
            url: app_link + "fixed_entries/" + fixed_entrie, // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                monthT: monthNow, // Replace with the current month you want to show
                fixed_entrie: fixed_entrie,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("#tableShowFixed").remove();
                $("div.modal-footer a").remove();
                $("div.modal-footer form").remove();
                if(response != '') {
                    let modalDiv =`
                                <table class="table table-striped table-bordered" id="tableShowFixed">
                                <tr>
                                    <th scope="row">اسم الموظف</th>
                                    <th  scope="row">`+ response['employee']['name'] +`</th>
                                </tr>
                                <tr>
                                    <td>علاوة إدارية</td>
                                    <td>`+ response['administrative_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة مؤهل علمي</td>
                                    <td>`+ response['scientific_qualification_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>مواصلات</td>
                                    <td>`+ response['transport'] +`</td>
                                </tr>
                                <tr>
                                    <td>بدل إضافي</td>
                                    <td>`+ response['extra_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة أغراض راتب</td>
                                    <td>`+ response['salary_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة إضافة بأثر رجعي</td>
                                    <td>`+ response['ex_addition'] +`</td>
                                </tr>
                                <tr>
                                    <td>علاوة جوال</td>
                                    <td>`+ response['mobile_allowance'] +`</td>
                                </tr>
                                <tr>
                                    <td>تأمين صحي</td>
                                    <td>`+ response['health_insurance'] +`</td>
                                </tr>
                                <tr>
                                    <td>ف. أوريدو</td>
                                    <td>`+ response['f_Oredo'] +`</td>
                                </tr>
                                <tr>
                                    <td>قرض جمعية</td>
                                    <td>`+ response['association_loan'] +`</td>
                                </tr>
                                <tr>
                                    <td>رسوم دراسية</td>
                                    <td>`+ response['tuition_fees'] +`</td>
                                </tr>
                                <tr>
                                    <td>تبرعات</td>
                                    <td>`+ response['voluntary_contributions'] +`</td>
                                </tr>
                                <tr>
                                    <td>قرض إدخار</td>
                                    <td>`+ response['savings_loan'] +`</td>
                                </tr>
                                <tr>
                                    <td>قرض شيكل</td>
                                    <td>`+ response['shekel_loan'] +`</td>
                                </tr>
                                <tr>
                                    <td>خصم اللجنة</td>
                                    <td>`+ response['paradise_discount'] +`</td>
                                </tr>
                                <tr>
                                    <td>خصومات أخرى</td>
                                    <td>`+ response['other_discounts'] +`</td>
                                </tr>
                                <tr>
                                    <td>تبرعات للحركة</td>
                                    <td>`+ response['proportion_voluntary'] +`</td>
                                </tr>
                                <tr>
                                    <td>إدخار 5%</td>
                                    <td>`+ response['savings_rate'] +`</td>
                                </tr>
                                </table>
                            `;
                $("div#showFixed").append(modalDiv);
                $("div.modal-footer").append(`
                    <form action="`+app_link+`fixed_entries/`+ response['employee_id'] +`" method="post" class="mr-3">
                        <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin: 0.5rem -0.75rem; text-align: right;"
                        href="#">حذف</button>
                    </form>
                `);
                $("div.modal-footer").append(`<a href="`+app_link+`fixed_entries/`+ response['employee_id'] +`/edit" target="_blank" class="btn btn-primary mr-3">تعديل</a>`);
                }else{
                    $("#tableShowFixed").remove();
                    $("div#showFixed").append('<h3 class="text-center" id="tableShowFixed">لا يوجد بيانات للموظف في هذاالشهر</h3>');
                }

            },
            error: function (error) {
                console.error("Error :", error);
            },
        });
    });

})(jQuery);
