new DataTable("#table");

$(function () {
    $("#select-form").on("change", function () {
        var url = new URL("/research-forms/submissions", window.location.href);
        url.searchParams.set("formId", $("#select-form").val());
        url.searchParams.set("departmentId", $("#select-department").val());

        window.location.href = url.toString();
    });

    $("#select-department").on("change", function () {
        var url = new URL("/research-forms/submissions", window.location.href);
        url.searchParams.set("formId", $("#select-form").val());
        url.searchParams.set("departmentId", $("#select-department").val());

        window.location.href = url.toString();
    });

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this)
            .siblings(".custom-file-label")
            .addClass("selected")
            .html(fileName);
    });
});
