(function ($) {
    $(".table-hover").delegate("tr.total_select", "click", function () {
        total_id = $(this).data("id");
        $.ajax({
            url: app_link + "totals/" + total_id + "/edit", // Replace with your Laravel route URL
            method: "GET",
            data: {
                showModel: true,
                total_id: total_id,
                _token: csrf_token, // Include the CSRF token
            },
            success: function (response) {
                $("div#showtotal form").remove();
                $("div.modal-footer form").remove();
                let modalDiv =`
                        <form action="`+app_link+`totals/`+ response['id'] +`" method="post" class="col-12">
                            <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                            <input type="hidden" name="_method" value="put">
                            <div class="form-group p-1 col-6">
                                <label for="gender">رقم الموظف</label>
                                <div class="input-group mb-3">
                                    <input id="employee_id"  name="employee_id" class="form-control"  value="`+ response['employee_id'] +`"  placeholder="0" readonly required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group p-3 col-4">
                                    <label for="total_receivables">إجمالي المستحقات</label>
                                    <input type="number" step="0.01" value="`+ response['total_receivables'] +`" name="total_receivables" id="total_receivables" class="form-control" placeholder="5000...." />
                                </div>
                                <div class="form-group p-3 col-4">
                                    <label for="total_savings">إجمالي الإدخارات</label>
                                    <input type="number" step="0.01" value="`+ response['total_savings'] +`" name="total_savings" id="total_savings" class="form-control" placeholder="5000...." />
                                </div>
                                <div class="form-group p-3 col-4">
                                    <label for="total_association_loan">إجمالي قرض الجمعية</label>
                                    <input type="number" step="0.01" value="`+ response['total_association_loan'] +`"  name="total_association_loan" id="total_association_loan" class="form-control" placeholder="5000...." />
                                </div>
                                <div class="form-group p-3 col-4">
                                    <label for="total_savings_loan">إجمالي قرض الإدخار $</label>
                                    <input type="number" step="0.01"value="`+ response['total_savings_loan'] +`"  name="total_savings_loan" id="total_savings_loan" class="form-control" placeholder="5000...." />
                                </div>
                                <div class="form-group p-3 col-4">
                                    <label for="total_shekel_loan">إجمالي قرض اللجنة (الشيكل)</label>
                                    <input type="number" step="0.01" value="`+ response['total_shekel_loan'] +`"  name="total_shekel_loan" id="total_shekel_loan" class="form-control" placeholder="5000...." />
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col">
                                    <a href="`+app_link+`exchanges?employee_id=`+ response['employee_id'] +`" class="nav-link" >عمل صرف للموظف</a>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
                                        تعديل
                                    </button>
                                </div>
                            </div>
                        </form>
                            `;
                $("div#showtotal").append(modalDiv);
                $("div.modal-footer").append(`
                    <form action="`+app_link+`totals/`+ response['id'] +`" method="post" class="mr-3">
                        <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn btn-danger" style="margin: 0.5rem -0.75rem; text-align: right;"
                        href="#">حذف</button>
                    </form>
                `);
                $("#openModalShow").click();
            },
            error: function (error) {
                console.error("Error removing product from wishlist:", error);
            },
        });
    });


})(jQuery);
