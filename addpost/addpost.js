$(function () {
    //Editor - Markdown
    editormd("editormd");

    //Datepicker - Publish Date
    $('#bootstrap-datepicker').datepicker({
        startDate: "",
        todayBtn: "linked",
        orientation: "bottom left",
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
    });
});


//Submit response
function save_post_success(_data) {
    var data = JSON.parse(_data);
    console.log(data);

    if (data.result == 'success') {
        toast_success(data.result_string);
    }
    else {
        toast_error(data.result_string);
    }
}

var twitter_page_specific_link = '';