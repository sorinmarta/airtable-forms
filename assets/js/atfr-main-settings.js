jQuery(document).ready( function() {
    // HTML elements required
    var action = document.getElementById('atfr-creds-action')
    var nonce = document.getElementById('atfr-creds-nonce')
    var ATKey = document.getElementById('atfr-key')

    // Form submitted
    jQuery("#atfr-creds-form").on('submit', function(e) {
        e.preventDefault();
        // AJAX Request
        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {
                action: action.value,
                atfr_key : ATKey.value,
                nonce: nonce.value
            },
            success: function(response) {
                if (response.type == 'success'){
                    atfrShowResponse('success', response.message);
                }

                if (response.type == 'error'){
                    atfrShowResponse('error', response.message, response.field)
                }
            }
        })
    })
    function atfrShowResponse (type, message, field=null) {
        var noticeList = document.querySelector('.atfr-error-box');

        // Reset the previous DOM changes
        atfrResetNotices(noticeList);

        // Success action
        if (type == 'success') {
            // Display the success notice
            displayNotice(noticeList,'success',message);
        } else if (type == 'error') {
        
            var element;

            // Figure out what field is empty
            switch (field) {
                case 'ATKey':
                    element = ATKey
                    break;
            }

            // Add the red border
            element.classList.add('atfr-field-error');

            // Display the error message
            displayNotice(noticeList,'error',message);
        }
    }

    function atfrResetNotices (noticeList){
        // Remove the paragraphs
        if (noticeList.classList.contains('atfr-show')) {
            noticeList.classList.remove('atfr-show');
            document.querySelector('.atfr-error-box p').remove();
        }

        // Remove the red border around fields
        var form = document.querySelector('#atfr-creds-form');
        var formElements = form.children;

        for (i = 0; i< formElements.length; i++){
            if(formElements[i].classList.contains('atfr-field-error')){
                formElements[i].classList.remove('atfr-field-error')
            }
        }

        // Remove the success or error class on the notice box
        var noticeBox = document.querySelector('.atfr-error-box');

        if(noticeBox.classList.contains('atfr-notice-error')){
            noticeBox.classList.remove('atfr-notice-error');
        }

        if(noticeBox.classList.contains('atfr-notice-success')){
            noticeBox.classList.remove('atfr-notice-success');
        }
    }

    function displayNotice(parentElement, type, message){
        // Success action
        if(type == 'success'){
            var noticeElement = document.createElement('p');
                noticeElement.innerText = message;
                parentElement.append(noticeElement);
                parentElement.classList.add('atfr-show');
                parentElement.classList.add('atfr-notice-success');
        }

        // Error action
        if(type == 'error'){
            var noticeElement = document.createElement('p');
            noticeElement.innerText = message;
            parentElement.append(noticeElement);
            parentElement.classList.add('atfr-show');
            parentElement.classList.add('atfr-notice-error');
        }
    }

})