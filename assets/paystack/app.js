// You will need to make many changes here
// for production

// Do Note that reportErrorToBackend and verifyTransactionOnBackend
// are called in main.js
// Be careful changing their name or the data they accept 


 $(document).ready(function() {
    $("#card-form").submit(function(e){
        e.preventDefault();
        // var email = $('#email').val();
        // var amount = $('#amount').val();
        var user_id = $('#user_id').val();
        var subscription_type = $('#subscription-type').val();
        // then we initialize the transaction on the backend
        //get new access code
        startTransactionOnBackend(user_id, subscription_type);
        NProgress.start();
        // clean up
        // $("#checkout-form").hide();
        // $("#checkout-error").html('');
        // $("#processing").show();
        // $('#email').val('');
        // $('#amount').val('');
    });

    function reportErrorToBackend(error){
        // we are reporting only the error here. in real life
        // you will want to collect a little more information
        // $.ajax({
        //     type: "POST",
        //     url: 'report',
        //     data: {error: error}
        // });
    }

    function verifyTransactionOnBackend(reference){
        var url = "index.php/api/verify_transaction";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {paystack_auth_code: reference},
            success: function (gateway_response) {
                if (gateway_response.code == 1) {
                    updateSubscription(reference);
                   
                } else if (gateway_response.code == -1) {
                    alert("Failed to verify transaction");
                }
                // $("#success-gateway-response").html(gateway_response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                NProgress.done();
                console.log("There was an error verifying "+reference, xhr.responseText);
                reportErrorToBackend(xhr.responseText);
                $("#verify-error").html(xhr.responseText);
            }
        });
    }
    function updateSubscription(reference) {
        var user_id = $('#user_id').val();
        var subscription_type = $('#subscription-type').val();
        var card_number = $('#number').val();
        var number = card_number.substring(card_number.length - 4);
        var current_timestamp = Math.floor(Date.now() / 1000);
        var url = "index.php/api/update_subscription";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {user_id: user_id,
                    paystack_auth_code: reference,
                    subscribed_type: subscription_type,
                    card_number: number,
                    subscribed_date: current_timestamp
                    },
            success: function (gateway_response) {
                if (gateway_response.code == 1) {
                    update_session_for_subscription();
                    console.log(gateway_response.content);
                    alert("Subscription Success");
                } else if (gateway_response.code == -1) {
                    alert("Failed to verify transaction");
                }
                // $("#success-gateway-response").html(gateway_response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                NProgress.done();
                console.log("There was an error verifying "+reference, xhr.responseText);
                reportErrorToBackend(xhr.responseText);
                $("#verify-error").html(xhr.responseText);
            }, 
            complete: function(res) {
                
            }
        });
    }
    function update_session_for_subscription() {
        var url = "index.php/vidhub/auth/update_session_for_subscription";
        $.ajax({
            type: "GET",
            url: url,
            success: function () {
                    window.location.replace("vidhub");
                // $("#success-gateway-response").html(gateway_response);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                NProgress.done();
                console.log("There was an error verifying "+reference, xhr.responseText);
                reportErrorToBackend(xhr.responseText);
                $("#verify-error").html(xhr.responseText);
            }, 
            complete: function(res) {
                NProgress.done();
            }
        });
    }
    function startTransactionOnBackend(user_id, subscription_type){
        var url = "index.php/api/get_new_access_code";
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {user_id: user_id, subscription_type: subscription_type},
            success: function (res) {
                console.log(res);
                if (res.code == 1) {
                    startPaystack(res.content);
                    console.log(res.content);
                } else if (res.code == -1) {
                    alert("Failed to get access code");
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("There was an error getting an accesscode", xhr.responseText);
                reportErrorToBackend(xhr.responseText);

                // clean up
                $("#processing").hide();
                $("#checkout-form").show();
                $("#checkout-error").html(xhr.responseText);
            }
        });
    }
    function startPaystack(access_code){
        // Paystack object that will handle payment
        // Note that it is initialized asynchronously

        Paystack.init({
            access_code: access_code,
            form: "card-form"
        }).then(function(returnedObj){
            window.PAYSTACK = returnedObj;
            // showCardEntry();
            PAYSTACK.card.charge().then(handleResponse, handleError);
        }).catch(function(error){
            // If there was a problem, you may 
            // log to console (while testing)
            console.log("There was an error loading Paystack", error);
            // or report to your backend for debugging (in production)
            window.reportErrorToBackend(error);
        });

        function showCardEntry(){
            stopProcessing();
            // $("#card-form").show();
            // $("#failed").hide();
            $("#number").val('');
            $("#cvv").val('');
            $("#expiryMonth").val('');
            $("#expiryYear").val('');
            $("#card-form").submit(function(evt){
                startProcessing(evt);
                PAYSTACK.card.charge()
                    .then(handleResponse, handleError);
            });
        }

        function startProcessing(e){
            e.preventDefault();
            // $("#processing").show();
            e.target && $(e.target).hide();
            e.target && $(e.target).off('submit');
            $("#error").hide();
            $("#error-message").html('');
            $("#error-errors").html('');
        }

        function stopProcessing(){
            // $("#processing").hide();
        }

        function startPinAuth(response){
            $("#pin-form").show();
            $("#pin-form").submit(function(e){
                startProcessing(e);
                PAYSTACK.card.charge({
                    pin: fetchValueWhileClearingField('pin')
                }).then(handleResponse, handleError);
            });
        }

        function startOtpAuth(response){
            $("#otp-form").show();
            $("#otp-message").html(response.message);
            $("#otp-form").submit(function(e){
                startProcessing(e);
                PAYSTACK.card.validateToken({
                    token: fetchValueWhileClearingField('otp')
                }).then(handleResponse, handleError);
            });
        }

        function start3dsAuth(response){
            $("#3ds-form").show();
            $("#3ds-message").html(response.message);
            $("#3ds-form").submit(function(e){
                startProcessing(e);
                PAYSTACK.card.verify3DS()
                    .then(handleResponse, handleError);
            });
        }

        function startPhoneAuth(response){
            $("#phone-form").show();
            $("#phone-message").html(response.message);
            $("#phone-form").submit(function(e){
                startProcessing(e);
                PAYSTACK.card.validatePhone({
                    phone: fetchValueWhileClearingField('phone')
                }).then(handleResponse, handleError);
            });
        }

        function showTimeout(response){
            $("#timeout").show();
            $("#timeout-message").html(response.message);
            console.log(response.message);
            alert("Time out");
        }

        function showSuccess(response){
            // $("#success").show();
            // $("#success-message").html(response.message);
            // $("#success-reference").html(response.data.reference);
            console.log(response.message);
            verifyTransactionOnBackend(response.data.reference);
        }

        function showFailed(response){
            // $("#failed").show();
            // $("#failed-message").html(response.message);
            console.log(response.message);
            alert("Failed");
            showCardEntry();
        }

        function handleResponse(response){
            console.log(response);
            stopProcessing();
            switch(response.status) {
                case 'auth':
                    switch(response.data.auth) {
                        case 'pin':
                            startPinAuth(response);
                            break;
                        case 'phone':
                            startPhoneAuth(response);
                            break;
                        case 'otp':
                            startOtpAuth(response);
                            break;
                        case '3DS':
                            start3dsAuth(response);
                            break;
                    }
                    break;
                case 'timeout':
                    NProgress.done();
                    showTimeout(response);
                    break;
                case 'success':
                    showSuccess(response);
                    break;
                case 'failed':
                    NProgress.done();
                    showFailed(response);
                    break;
            }
        }

        function handleError(error){
            $("#error").show();
            showPaystackError(error);
            console.log(error);
            reportErrorToBackend(error);
            showCardEntry();
        }

        function fetchValueWhileClearingField(id){
            var val = $('#'+id).val();
            $('#'+id).val('');
            return val;
        }

        function showPaystackError(error){
            if(!(typeof error.message === 'string')){
                // Not a paystack error
                return;
            }
            $("#error-message").html(error.message);
            if(!(Object.prototype.toString.call( error.errors ) === '[object Array]')){
                // Not an array of messages
                return;
            }
            var len = error.errors.length;
            // build the error string
            var errStr = '<ul>';
            for (i=0; i<len; ++i) {
                errStr = errStr+'<li>'+error.errors[i].field+': '+error.errors[i].message+'</li>';
            }
            $("#error-errors").html(errStr+'</ul>');
        }

    }
  });   


