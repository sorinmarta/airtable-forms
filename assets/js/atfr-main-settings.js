jQuery(document).ready( function() {
    jQuery("#atfr-creds-form").on('submit', function(e) {
        e.preventDefault();
        const action = document.getElementById('atfr-creds-action')
        const nonce = document.getElementById('atfr-creds-nonce')
        const ATKey = document.getElementById('atfr-key')
        const ATBase = document.getElementById('atfr-base-id')
        const ATTable = document.getElementById('atfr-table')

        jQuery.ajax({
            type : "post",
            dataType : "json",
            url : myAjax.ajaxurl,
            data : {
                action: action.value,
                atfr_key : ATKey.value,
                atfr_base : ATBase.value,
                atfr_table : ATTable.value,
                nonce: nonce.value
            },
            success: function(response) {
                const errorList = document.querySelector('.atfr-error-box');

                if (errorList.classList.contains('atfr-show')){
                    errorList.classList.remove('atfr-show');
                    document.querySelector('.atfr-error-box p').remove();
                }

                if(response.type == "success") {
                    console.log(response.message);
                }
                else {
                    if (response.field){
                        let element;
                        switch (response.field){
                            case 'ATKey':
                                element = ATKey
                                break;
                            case 'ATBase':
                                element = ATBase
                                break;
                            case 'ATTable':
                                element = ATTable
                                break;
                        }
                        element.style.border = '1px solid red';
                        const errorElement = document.createElement('p');
                        errorElement.innerText = response.message;
                        errorList.append(errorElement);
                        errorList.classList.add('atfr-show');
                    }
                }
            }
        })
    })
})