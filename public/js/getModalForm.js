(function ($) {
    function disabledField(month) {
        if (month < lastMonth) {
            return "disabled";
        }
    }
    function onChange(text) {
        return text;
    }

    // open modal form for fixed entries
    $(".openModal").click(function () {
        let type = $(this).data("type");
        let label = $(this).data("label");
        let employee_id = $(this).data("employeeid");
        let modal = $("#openModal");
        let btn_open = $("#openModalShow");

        // edit modal data
        modal.find("h5.modal-title").text("تحديد " + label);

        // get modal body
        $.ajax({
            url: app_link + "fixed_entries/getModalForm",
            method: "post",
            data: {
                type: type,
                employee_id: employee_id,
                _token: csrf_token,
            },
            success: function (response) {
                let modal_body =
                    `
                    <div class="modal-body">
                                <input type="hidden" name="_token" value="3GxYNnOD7dWeZj7SFmeJ9n2WKAzYVqHxMo4BBVYY" autocomplete="off">
                                <div class="row mt-3">
                                    <div class="form-group col-md-3">
                                        <h3 class="ml-2">تحديد ثابت لكل شهر</h3>
                                        <input type="number" id="` + type + `_months" name="` + type + `_months" oninput="fields_month()" value="" class="form-control fields_month" placeholder="0">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <h3 class="ml-3">تحديد لكل شهر</h3>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">يناير</th>
                                                <th scope="col">فبراير</th>
                                                <th scope="col">مارس</th>
                                                <th scope="col">أبريل</th>
                                                <th scope="col">مايو</th>
                                                <th scope="col">يونيو</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="number" id="` + type +`_month-1" name="` +type +`_month-1" class="form-control fields_month-1" placeholder="0." ` +disabledField(1) +`  value="` +response[type + "_month-1"] +`">
                                                </td>
                                                <td>
                                                    <input type="number" id="` + type +`_month-2" name="` +type +`_month-2" class="form-control fields_month-2" placeholder="0." ` +disabledField(2) +`  value="` +response[type + "_month-2"] +`">
                                                </td>
                                                <td>
                                                    <input type="number" id="` + type +`_month-3" name="` +type +`_month-3" class="form-control fields_month-3" placeholder="0." ` +disabledField(3) +`  value="` +response[type + "_month-3"] +`">
                                                </td>
                                                <td>
                                                    <input type="number" id="` + type +`_month-4" name="` +type +`_month-4" class="form-control fields_month-4" placeholder="0." ` +disabledField(4) +`  value="` +response[type + "_month-4"] +`">
                                                </td>
                                                <td>
                                                    <input type="number" id="` + type +`_month-5" name="` +type +`_month-5" class="form-control fields_month-5" placeholder="0." ` +disabledField(5) +`  value="` +response[type + "_month-5"] +`">
                                                </td>
                                                <td>
                                                    <input type="number" id="` + type +`_month-6" name="` +type +`_month-6" class="form-control fields_month-` + 6 + `" placeholder="0." ` +disabledField(6) +`  value="` +response[type + "_month-6"] +`">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">يوليو</th>
                                                <th scope="col">أغسطس</th>
                                                <th scope="col">سبتمبر</th>
                                                <th scope="col">أكتوبر</th>
                                                <th scope="col">نوفمبر</th>
                                                <th scope="col">ديسمبر</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="number" id="`+type+`_month-7" name="`+type+`_month-7" class="form-control fields_month-7" placeholder="0." `+disabledField(7)+` value="`+response[type+ "_month-7"]+`">
                                                </td>
                                                <td>
                                                    <input type="number" id="`+type+`_month-8" name="`+type+`_month-8" class="form-control fields_month-8" placeholder="0." `+disabledField(8)+` value="`+response[type+ "_month-8"]+`">
                                                </td>
                                                <td>
                                                    <input type="number" id="`+type+`_month-9" name="`+type+`_month-9" class="form-control fields_month-9" placeholder="0." `+disabledField(9)+` value="`+response[type+ "_month-9"]+`">
                                                </td>
                                                <td>
                                                    <input type="number" id="`+type+`_month-10" name="`+type+`_month-10" class="form-control fields_month-10" placeholder="0." `+disabledField(10)+` value="`+response[type+ "_month-10"]+`">
                                                </td>
                                                <td>
                                                    <input type="number" id="`+type+`_month-11" name="`+type+`_month-11" class="form-control fields_month-11" placeholder="0." `+disabledField(11)+` value="`+response[type+ "_month-11"]+`">
                                                </td>
                                                <td>
                                                    <input type="number" id="`+type+`_month-12" name="`+type+`_month-12" class="form-control fields_month-12" placeholder="0." `+disabledField(12)+` value="`+response[type+ "_month-12"]+`">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="submit" data-status="create" data-employeeid="` +
                    employee_id +
                    `" data-type="` +
                    type +
                    `" class="btn btn-primary">إنشاء</button>
                                </div>
                        </div>`;
                modal.find("div.modalBody").html(modal_body);
            },
            error: function (response) {
                console.error(response);
            },
        });

        // open modal
        btn_open.click();
    });

    // send modal form
    $("#sendModalForm").on("submit", function (e) {
        e.preventDefault();
        var formData = [];
        $.each($(this).serializeArray(), function (i, field) {
            formData[field.name] = field.value;
        });
        let field = $('button[name="submit"]').data("type");
        let employee_id = $('button[name="submit"]').data("employeeid");
        $.ajax({
            url: app_link + "fixed_entries",
            method: "post",
            data: {
                employee_id: employee_id,
                [field + "_months"]: $("#" + field + "_months").val(),
                "01": $("#" + field + "_month-1").val(),
                "02": $("#" + field + "_month-2").val(),
                "03": $("#" + field + "_month-3").val(),
                "04": $("#" + field + "_month-4").val(),
                "05": $("#" + field + "_month-5").val(),
                "06": $("#" + field + "_month-6").val(),
                "07": $("#" + field + "_month-7").val(),
                "08": $("#" + field + "_month-8").val(),
                "09": $("#" + field + "_month-9").val(),
                10: $("#" + field + "_month-10").val(),
                11: $("#" + field + "_month-11").val(),
                12: $("#" + field + "_month-12").val(),
                [field + "_create"]: true,
                _token: csrf_token,
            },
            success: function (response) {
                // $("#openModal").modal("toggle");
                $("button.close").click();
            },
            error: function (response) {
                console.error(response);
            },
        });
    });

    // open modal form for fixed entries
    $(".openModalLoan").click(function () {
        let type = $(this).data("type");
        let label = $(this).data("label");
        let employee_id = $(this).data("employeeid");
        let modal = $("#openModalLoan");
        let btn_open = $("#openModalLoanShow");

        // edit modal data
        modal.find("h5.modal-title").text("تحديد " + label);

        // get modal body
        $.ajax({
            url: app_link + "fixed_entries/getModalFormLoan",
            method: "post",
            data: {
                type: type,
                employee_id: employee_id,
                _token: csrf_token,
            },
            success: function (response) {
                let total_old;
                if(type == "association_loan"){
                    total_old = response['total_association_loan_old'];
                }else if(type == "savings_loan"){
                    total_old = response['total_savings_loan_old'];
                }else if(type == "shekel_loan"){
                    total_old = response['total_shekel_loan_old'];
                }
                let modal_body = `
                <div class="row mt-3 align-items-center">
                            <span>ويصرف الإجمالي على كل شهر : </span>
                            <div class="form-group col-md-3 m-0">
                                <input type="number" id="`+ type +`_months" oninput="`+ type +`_fields()" name="`+ type +`_months" value="" class="form-control d-inline `+ type +`_fields" placeholder="0...">
                            </div>
                    </div>
                    <hr>
                    <div class="row">
                        <h3 class="ml-3">تحديد لكل شهر</h3>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">يناير</th>
                                    <th scope="col">فبراير</th>
                                    <th scope="col">مارس</th>
                                    <th scope="col">أبريل</th>
                                    <th scope="col">مايو</th>
                                    <th scope="col">يونيو</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" id="`+ type +`_month-1" name="`+ type +`_month-1" class="form-control"  ` +disabledField(1) +`  oninput="`+ type +`_fields_month()" placeholder="0." disabled="" value="` +response[type + "_month-1"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-2" name="`+ type +`_month-2" class="form-control"  ` +disabledField(2) +`  oninput="`+ type +`_fields_month()" placeholder="0." disabled="" value="` +response[type + "_month-2"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-3" name="`+ type +`_month-3" class="form-control"  ` +disabledField(3) +`  oninput="`+ type +`_fields_month()" placeholder="0." disabled="" value="` +response[type + "_month-3"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-4" name="`+ type +`_month-4" class="form-control"  ` +disabledField(4) +`  oninput="`+ type +`_fields_month()" placeholder="0." disabled="" value="` +response[type + "_month-4"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-5" name="`+ type +`_month-5" class="form-control"  ` +disabledField(5) +`  oninput="`+ type +`_fields_month()" placeholder="0." disabled="" value="` +response[type + "_month-5"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-6" name="`+ type +`_month-6" class="form-control"  ` +disabledField(6) +`  oninput="`+ type +`_fields_month()" placeholder="0." disabled="" value="` +response[type + "_month-6"] +`">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">يوليو</th>
                                    <th scope="col">أغسطس</th>
                                    <th scope="col">سبتمبر</th>
                                    <th scope="col">أكتوبر</th>
                                    <th scope="col">نوفمبر</th>
                                    <th scope="col">ديسمبر</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" id="`+ type +`_month-7" name="`+ type +`_month-7" class="form-control"  ` +disabledField(7) +`  oninput="`+ type +`_fields_month()" placeholder="0." value="` +response[type + "_month-7"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-8" name="`+ type +`_month-8" class="form-control"  ` +disabledField(8) +`  oninput="`+ type +`_fields_month()" placeholder="0." value="` +response[type + "_month-8"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-9" name="`+ type +`_month-9" class="form-control"  ` +disabledField(9) +`  oninput="`+ type +`_fields_month()" placeholder="0." value="` +response[type + "_month-9"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-10" name="`+ type +`_month-10" class="form-control"  ` +disabledField(10) +`  oninput="`+ type +`_fields_month()" placeholder="0." value="` +response[type + "_month-10"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-11" name="`+ type +`_month-11" class="form-control"  ` +disabledField(11) +`  oninput="`+ type +`_fields_month()" placeholder="0." value="` +response[type + "_month-11"] +`">
                                    </td>
                                    <td>
                                        <input type="number" id="`+ type +`_month-12" name="`+ type +`_month-12" class="form-control"  ` +disabledField(12) +`  oninput="`+ type +`_fields_month()" placeholder="0." value="` +response[type + "_month-12"] +`">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row mt-3 align-items-center">
                        <span>المبلغ الإجمالي القديم</span>
                        <span id="total_`+ type +`_old">
                            ` + total_old + `
                        </span>
                        <span>المبلغ الإجمالي المتبقي</span>
                        <div class="form-group col-md-3 m-0">
                            <input type="number" id="total_`+ type +`" name="total_`+ type +`" value="` + total_old + `" class="form-control d-inline" placeholder="0....">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" data-status="create" id="`+ type +`_form" class="btn btn-primary" data-employeeid="` +employee_id +`" data-type="` +type +`">إنشاء</button>
                    </div>`;

                modal.find("div.modalBodyLoan").html(modal_body);
            },
            error: function (response) {
                console.error(response);
            },
        });

        // open modal
        btn_open.click();
    });

    // send modal form
    $("#sendModalLoanForm").on("submit", function (e) {
        e.preventDefault();
        var formData = [];
        $.each($(this).serializeArray(), function (i, field) {
            formData[field.name] = field.value;
        });
        $(this).find

        let field = $('button[name="submit"]').data("type");
        let employee_id = $('button[name="submit"]').data("employeeid");
        $.ajax({
            url: app_link + "fixed_entries",
            method: "post",
            data: {
                employee_id: employee_id,
                [field + "_months"]: $("#" + field + "_months").val(),
                "01": $("#" + field + "_month-1").val(),
                "02": $("#" + field + "_month-2").val(),
                "03": $("#" + field + "_month-3").val(),
                "04": $("#" + field + "_month-4").val(),
                "05": $("#" + field + "_month-5").val(),
                "06": $("#" + field + "_month-6").val(),
                "07": $("#" + field + "_month-7").val(),
                "08": $("#" + field + "_month-8").val(),
                "09": $("#" + field + "_month-9").val(),
                10: $("#" + field + "_month-10").val(),
                11: $("#" + field + "_month-11").val(),
                12: $("#" + field + "_month-12").val(),
                ['total_' + field]: $('#total_' + field + "").val(),
                [field + "_create"]: true,
                _token: csrf_token,
            },
            success: function (response) {
                $(this).find("button.close").click();

                $("button.close").click();
            },
            error: function (response) {
                console.error(response);
            },
        });
    });
})(jQuery);
