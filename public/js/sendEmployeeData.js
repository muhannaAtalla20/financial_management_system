(function ($) {
    // استخدم كائن Date للحصول على التاريخ الحالي
    let currentDate = new Date();
    // احصل على الشهر (بالتنسيق من 0 إلى 11، حيث يكون يناير هو الشهر 0)
    var currentMonth = currentDate.getMonth() +1;

    // send data to server
    let fields = [
        'administrative_allowance',
        'scientific_qualification_allowance',
        'transport',
        'extra_allowance',
        'salary_allowance',
        'ex_addition',
        'mobile_allowance',
        'health_insurance',
        'f_Oredo',
        'tuition_fees',
        'voluntary_contributions',
        'paradise_discount',
        'other_discounts',
        'proportion_voluntary',
        'savings_rate',
        'association_loan',
        'savings_loan',
        'shekel_loan',
    ];
    for (let field of fields) {
        $('#' + field + '_form').on('click', function (event) {
            $.ajax({
                url: app_link + "fixed_entries",
                method: "post",
                data: {
                    employee_id: $('#employee_id').val(),
                    [field + '_months']: $('#' + field + '_months').val(),
                    "01": $('#' + field + '_month-1').val(),
                    "02": $('#' + field + '_month-2').val(),
                    "03": $('#' + field + '_month-3').val(),
                    "04": $('#' + field + '_month-4').val(),
                    "05": $('#' + field + '_month-5').val(),
                    "06": $('#' + field + '_month-6').val(),
                    "07": $('#' + field + '_month-7').val(),
                    "08": $('#' + field + '_month-8').val(),
                    "09": $('#' + field + '_month-9').val(),
                    10: $('#' + field + '_month-10').val(),
                    11: $('#' + field + '_month-11').val(),
                    12: $('#' + field + '_month-12').val(),
                    [field + '_create']: true,
                    ['total_' + field]: $('#total_' + field + "").val(),
                    _token: csrf_token,
                },
                success: function (response) {
                    $('#open_' + field).modal('toggle')
                },
                error: function (response) {
                    console.error(response);
                }
            });
        });
    }

    let total_association_loan = $('#total_association_loan_old').text();
    let total_savings_loan = $('#total_savings_loan_old').text();
    let total_shekel_loan = $('#total_shekel_loan_old').text();
    $(".table-hover").delegate("tr.employee_select", "click", function () {
        let employee_id_select = $(this).data("id");
        $.ajax({
            url: app_link + "fixed_entries/getFixedEntriesData",
            method: "post",
            data: {
                employee_id: employee_id_select,
                _token: csrf_token,
            },
            success: function (response) {
                if(response['link_edit_fixed_entries'] != false){
                    window.location.href = response['link_edit_fixed_entries'];
                }
                $('#employee_name').text(response['employee_name']);
                // قرض الجمعية
                $("#total_association_loan").val(response['total_association_loan']);
                $("#total_association_loan_old").text(response['total_association_loan']);
                total_association_loan = response['total_association_loan'];

                // قرض الإدخار
                $("#total_savings_loan").val(response['total_savings_loan']);
                $("#total_savings_loan_old").text(response['total_savings_loan']);
                total_savings_loan = response['total_savings_loan'];

                // قرض اللجنة (الشيكل)
                $("#total_shekel_loan").val(response['total_shekel_loan']);
                $("#total_shekel_loan_old").text(response['total_shekel_loan']);
                total_shekel_loan = response['total_shekel_loan'];
            },
            error: function (response) {
                console.error(response);
            }
        });
    });

    // حقل قرض الجمعية
    let association_loan_months_total = 0;
    let association_loan_months;
    let total_association_loan_new_val;

    $('.association_loan_fields').on('input',function(e){
        association_loan_months = $('#association_loan_months').val();
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                $("#association_loan_month-"+i).val(association_loan_months)
            }
        }
        association_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            association_loan_months_total = Number(association_loan_months_total) + Number($("#association_loan_month-" + i).val());
        }
        total_association_loan_new_val = Number(total_association_loan) - (association_loan_months_total);
        $("#total_association_loan").val(total_association_loan_new_val);
    })
    $('.association_loan_fields_month').on('input',function(e){
        total_association_loan_new_val = 0;
        association_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                association_loan_months_total += Number($("#association_loan_month-" + i).val());
            }
        }
        total_association_loan_new_val = Number(total_association_loan)  - (association_loan_months_total)
        $("#total_association_loan").val(total_association_loan_new_val);
    })

    // حقل قرض الإدخار
    let savings_loan_months_total = 0;
    let savings_loan_months;
    let total_savings_loan_new_val;

    $('.savings_loan_fields').on('input',function(e){
        savings_loan_months = $('#savings_loan_months').val();
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                $("#savings_loan_month-"+i).val(savings_loan_months)
            }
        }
        savings_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            savings_loan_months_total = Number(savings_loan_months_total) + Number($("#savings_loan_month-" + i).val());
        }
        total_savings_loan_new_val = Number(total_savings_loan) - (savings_loan_months_total);
        $("#total_savings_loan").val(total_savings_loan_new_val);
    })
    $('.savings_loan_fields_month').on('input',function(e){
        total_savings_loan_new_val = 0;
        savings_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                savings_loan_months_total += Number($("#savings_loan_month-" + i).val());
            }
        }
        total_savings_loan_new_val = Number(total_savings_loan) - (savings_loan_months_total);
        $("#total_savings_loan").val(total_savings_loan_new_val);
    })

    // حقل قرض اللجنة
    let shekel_loan_months_total = 0;
    let shekel_loan_months;
    let total_shekel_loan_new_val;

    $('.shekel_loan_fields').on('input',function(e){
        shekel_loan_months = $('#shekel_loan_months').val();
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                $("#shekel_loan_month-"+i).val(shekel_loan_months)
            }
        }
        shekel_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            shekel_loan_months_total = Number(shekel_loan_months_total) + Number($("#shekel_loan_month-" + i).val());
        }
        total_shekel_loan_new_val = Number(total_shekel_loan) - (shekel_loan_months_total);
        $("#total_shekel_loan").val(total_shekel_loan_new_val);
    })
    $('.shekel_loan_fields_month').on('input',function(e){
        total_shekel_loan_new_val = 0;
        shekel_loan_months_total = 0;
        for(let i = 1;i <= 12;i++){
            if(i >= currentMonth){
                shekel_loan_months_total += Number($("#shekel_loan_month-" + i).val());
            }
        }
        total_shekel_loan_new_val = Number(total_shekel_loan) - (shekel_loan_months_total);
        $("#total_shekel_loan").val(total_shekel_loan_new_val);
    })

})(jQuery);
