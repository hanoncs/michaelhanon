function send_message_success(_data) {
    var data = JSON.parse(_data);
    $('.alert').remove();
    if (data.result == 'success') {
        //toast_success(data.result_string);
        //$('#btn-contact-submit').attr('disabled', '');
        $('#btn-contact-submit').replaceWith('<div class="alert alert-success">' + data.result_string + '</div>');
    }
    else {
        //toast_error(data.result_string);
        $('<div class="alert alert-danger">' + data.result_string + '</div>').insertBefore('#btn-contact-submit');
    }
}

var twitter_page_specific_link = 'Contact @MichaelHanon';
