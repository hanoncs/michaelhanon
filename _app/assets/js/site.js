//JqueryForm API INFO:http://malsup.com/jquery/form/#api
//wait until the DOM is ready


$(document).ready(function () {

    $(document).on('click', '.ClickSubmit', function (e) {
        e.preventDefault();
        AjaxCustomSubmit(this);
    });

    $(document).on('change', '.ChangeSubmit', function (e) {
        e.preventDefault();

        AjaxCustomSubmit(this);
    });

    $(document).on('keyup', '.KeyupSubmit', function (e) {
        e.preventDefault();
        AjaxCustomSubmit(this);
    });

    $(document).on('focusout', '.FocusoutSubmit', function (e) {
        e.preventDefault();
        AjaxCustomSubmit(this);
    });

    function AjaxCustomSubmit(ObjectContext) {

        //--------------AjaxCustomSubmit Properties-----------------------//
        //data-type="html"                          //jquery return type
        //data-path=""                              //the page to submit ajax to
        //data-formid="frm"                         //the ID of form to submit - Defaulted to frm
        //data-method="GET"                         //the form method "FORM" or "POST"
        //data-success="SomeFunction"               //Callbackfunction Name

        //defaults
        var FormID = 'frm', DataType = 'html', AStart = '', ASuccess = '', ABSend = '',
            AComplete = '', AStop = '', AError = '', OldPath = '', OldMethod = '';

        //Get Original FormAction
        if (typeof $('form').attr('action') != "undefined") {
            OldPath = $('Form').attr('action');
        }
        //Get Original Mothod
        if (typeof $('form').attr('method') != "undefined") {
            OldMethod = $('Form').attr('method');
        }

        //check for data type
        if ($(ObjectContext).data('type')) {
            DataType = $(ObjectContext).data('type');
        }

        if ($(ObjectContext).data('method')) {
            $('form').attr("method", $(ObjectContext).data('method'));
        }
        //check to make sure a data-path is declared, otherwide log in the console.
        if ($(ObjectContext).data('path')) {
            $('form').attr("action", $(ObjectContext).data('path'));
        }
        else {
            console.log('You must declare a data-path on the Ajax Submit button.');
        }

        //check if callback functions exist on the current page  when the function runs
        if ($(ObjectContext).data('success')) {
            if (typeof eval($(ObjectContext).data('success')) == 'function') {
                ASuccess = eval($(ObjectContext).data('success'));
            }
        }
        if ($(ObjectContext).data('adddata1')) {
            var AddData1 = $(ObjectContext).data('adddata1');
        }
        if ($(ObjectContext).data('adddata2')) {
            var AddData2 = $(ObjectContext).data('adddata2');
        }
        if ($(ObjectContext).data('adddata3')) {
            var AddData3 = $(ObjectContext).data('adddata3');
        }
        if ($(ObjectContext).data('adddata4')) {
            var AddData4 = $(ObjectContext).data('adddata4');
        }

        $('form').ajaxSubmit({
            data: {
                'Data1': AddData1,
                'Data2': AddData2,
                'Data3': AddData3,
                'Data4': AddData4
            },
            dataType: DataType,
            success: ASuccess, //AjaxSuccess
            cache: false,
        });

        //reset form action to original before ajax submit
        $('form').attr("action", OldPath);

        //reset form method to original before ajax submit
        $('form').attr("method", OldMethod);
    }

});


//-------------------------------------//
//----------Toast Start----------------//


toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-bottom-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "200",
    "hideDuration": "200",
    "timeOut": "4000",
    "extendedTimeOut": "0",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


function toast_success(val) {
    toastr["success"](val);
}

function toast_error(val) {
    toastr["error"](val);
}

function toast_info(val) {
    toastr["info"](val);
}

function toast_display() {
    if (data.result == 'success') {
        toast_success(data.result_string);
    }
    else {
        toast_error(data.result_string);
    }
}

//---------Toast End------------------//
//------------------------------------//
