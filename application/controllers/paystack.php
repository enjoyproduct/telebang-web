<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/3/2017
 * Time: 3:56 AM
 */
require_once 'vendor/autoload.php';
use Yabacon\Paystack;
use Yabacon\Paystack\MetadataBuilder;
function get_new_access_code ($data) {
    $amountinkobo = $data['amount'];
    $email = $data['email'];
    $builder = new MetadataBuilder();
    $builder->withCustomField('Started From', 'started_from', 'sample charge card backend');
    $builder->withCustomField('Requested by', 'requested_by', $email);
    $builder->withCustomField('Server', 'server', 'http://telebang.com/vidhub');
//    time()%2 && $builder->withCustomFilters(['recurring'=>true]);
    $metadata = $builder->build();

    try{
        $paystack = new Paystack(PAYSTACK_SECRET);
        $trx = $paystack->transaction->initialize([
            'amount'=>$amountinkobo,
            'email'=>$email,
            'metadata'=>$metadata
        ]);
    } catch(Exception $e){
        $result['code'] = -1;
        $result['message'] = "Failed to get access code";
        $result['content'] = $e->getMessage();
//        http_response_code(400);
//        die($e->getMessage());
        return($result);
    }

    $result['code'] = 1;
    $result['message'] = "Success to get access code";
    $result['content'] = $trx->data->access_code;
//    die($trx->data->access_code);
    return($result);
}
function verify_transaction($reference) {

    try{
        $paystack = new Paystack(PAYSTACK_SECRET);
        $trx = $paystack->transaction->verify([
            'reference'=>$reference,
        ]);
    } catch(Exception $e){
        $result['code'] = -1;
        $result['message'] = "Failed to verify transaction";
        $result['content'] = $e->getMessage();
//        http_response_code(400);
//        die($e->getMessage());
        return($result);
    }

    if($trx->data->status === 'success'){
        // give value
    }

    $result['code'] = 1;
    $result['message'] = "Success to get verify transaction";
    $result['content'] = $trx->data->gateway_response;
    // dump gateway response for display to user
//    die($trx->data->gateway_response);
    return($result);
}