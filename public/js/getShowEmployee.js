(function ($) {
    $(".showEmployee").on("click", function () {
        let employee = $(this).data("id");
        $.ajax({
            url: app_link + "employees/" + employee, // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("div#ModalShow").remove();
                let employee = `
                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>رقم الهوية</td>
                                        <td>` + response["employee_id"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>العمر</td>
                                        <td>` + response["age"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>تاريخ الميلاد</td>
                                        <td>` + response["date_of_birth"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>الجنس</td>
                                        <td>` + response["gender"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>الحالة الزوجية</td>
                                        <td>` + response["matrimonial_status"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>عدد الزوجات</td>
                                        <td>` + response["number_wives"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>عدد الأولاد</td>
                                        <td>` + response["number_children"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>عدد الأولاد في الجامعة</td>
                                        <td>` + response["number_university_children"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>المؤهل العلمي</td>
                                        <td>` + response["scientific_qualification"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>التخصص</td>
                                        <td>` + response["specialization"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>الجامعة</td>
                                        <td>` + response["university"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>المنطقة</td>
                                        <td>` + response["area"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>العنوان</td>
                                        <td>` + response["address"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>الإيميل</td>
                                        <td>` + response["email"] + `</td>
                                    </tr>
                                    <tr>
                                        <td>رقم الهاتف</td>
                                        <td>` + response["phone_number"] + `</td>
                                    </tr>
                                </table>`;
                let WorkData = "";
                if (response["work_data"] != null) {
                    WorkData =
                        `<h3 class="h3">بيانات العمل</h3>
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>حالة الداوم</td>
                                    <td>` + response["work_data"]["working_status"] + `</td>
                                </tr>
                                <tr>
                                    <td>نوع التعين</td>
                                    <td>` + response["work_data"]["type_appointment"] + `</td>
                                </tr>
                                <tr>
                                    <td>نسبة العلاوة من طبيعة العمل</td>
                                    <td>` + response["work_data"]["percentage_allowance"] + `</td>
                                </tr>
                                <tr>
                                    <td>مجال العمل</td>
                                    <td>` + response["work_data"]["field_action"] + `</td>
                                </tr>
                                <tr>
                                    <td>مزدوج الوظيفة</td>
                                    <td>` + response["work_data"]["dual_function"] + `</td>
                                </tr>
                                <tr>
                                    <td>سنوات الخدمة</td>
                                    <td>` + response["work_data"]["years_service"] + `</td>
                                </tr>
                                <tr>
                                    <td>طبيعة العمل</td>
                                    <td>` + response["work_data"]["nature_work"] + `</td>
                                </tr>
                                <tr>
                                    <td>حالةا لفعالية</td>
                                    <td>` + response["work_data"]["state_effectiveness"] + `</td>
                                </tr>
                                <tr>
                                    <td>جمعية</td>
                                    <td>` + response["work_data"]["association"] + `</td>
                                </tr>
                                <tr>
                                    <td>مكان العمل</td>
                                    <td>` + response["work_data"]["workplace"] + `</td>
                                </tr>
                                <tr>
                                    <td>قسم</td>
                                    <td>` + response["work_data"]["section"] + `</td>
                                </tr>
                                <tr>
                                    <td>التبعية</td>
                                    <td>` + response["work_data"]["dependence"] + `</td>
                                </tr>
                                <tr>
                                    <td>تاريخ العمل</td>
                                    <td>` + response["work_data"]["working_date"] + `</td>
                                </tr>
                                <tr>
                                    <td>تاريخ التثبيت</td>
                                    <td>` + response["work_data"]["date_installation"] + `</td>
                                </tr>
                                <tr>
                                    <td>تاريخ التقاعد</td>
                                    <td>` + response["work_data"]["date_retirement"] + `</td>
                                </tr>
                                <tr>
                                    <td>المنشأة</td>
                                    <td>` + response["work_data"]["establishment"] + `</td>
                                </tr>
                                <tr>
                                    <td>المؤسسة E</td>
                                    <td>` + response["work_data"]["foundation_E"] + `</td>
                                </tr>
                                <tr>
                                    <td>فئة الراتب</td>
                                    <td>` + response["work_data"]["salary_category"] + `</td>
                                </tr>
                            </tbody>
                        </table>`
                }
                let modalDiv =
                    `<div class="modal fade" id="ModalShow" tabindex="-1" role="dialog" aria-labelledby="ModalShowTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ModalShowTitle">الموظف/ة : ` +
                    response["name"] +
                    `</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                    <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingEmployee">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseEmployee" aria-expanded="true" aria-controls="collapseEmployee">
                                            البيانات الشخصية
                                            </button>
                                        </h5>
                                        </div>
                                        <div id="collapseEmployee" class="collapse" aria-labelledby="headingEmployee" data-parent="#accordion">
                                        <div class="card-body">
                                            ` + employee +`
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingWorkData">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseWorkData" aria-expanded="true" aria-controls="collapseWorkData">
                                            بيانات العمل
                                            </button>
                                        </h5>
                                        </div>
                                        <div id="collapseWorkData" class="collapse" aria-labelledby="headingWorkData" data-parent="#accordion">
                                        <div class="card-body">
                                            `+ WorkData + `
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="` + app_link + `employees/` + response["id"] + `/edit" target="_blank" class="btn btn-primary">تعديل البينات الشخصية</a>
                                </div>
                                </div>
                            </div>
                        </div>`;
                $("body").append(modalDiv);
                $("#openModalShow").click();
            },
            error: function (error) {
                console.error("Error removing product from wishlist:", error);
            },
        });
    });
})(jQuery);
