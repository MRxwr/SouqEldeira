<?php
if(!empty($data) && is_array($data) && $data){
    $paymentGateway = "knet";
    $fullAmount = $data["totalAmount"];
    $orderId = date("Ymd").rand(0000,9999).time();
   //preparing upayment payload and creating order
    $postBody = array(
       'language' => 'en',
       'paymentGateway[src]' => "{$paymentGateway}",
       'order[id]' => $orderId,
       'order[currency]' => 'KWD',
       'order[amount]' => (string)$fullAmount,
       'order[description]' => "{$data["details"]}",
       'reference[id]' => $orderId,
       'customer[name]' => "{$data["name"]}",
       'customer[email]' => "{$data["email"]}",
       'customer[mobile]' => "{$data["phone"]}",
       'returnUrl' => 'https://souqeldeira.createkwservers.com/index.php',
       'cancelUrl' => 'https://souqeldeira.createkwservers.com/index.php',
       'notificationUrl' => 'https://souqeldeira.createkwservers.com/index.php',
       );
   $curl = curl_init();
   curl_setopt_array($curl, array(
       CURLOPT_URL => 'https://uapi.upayments.com/api/v1/charge',
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'POST',
       CURLOPT_POSTFIELDS => $postBody,
       CURLOPT_HTTPHEADER => array(
           'Authorization: Bearer afmceR6nHQaIehhpOel036LBhC8hihuB8iNh9ACF',
       ),
   ));
   $response = curl_exec($curl);
   curl_close($curl);
   $response = json_decode($response,true);
   //saving info and redirecting to payment pages
   if( isset($response["status"]) && $response["status"] == true && isset($response["data"]["link"]) && !empty($response["data"]["link"]) ){
       $_SESSION["paymentLink"] = $response["data"]["link"];
       header("Location: {$response["data"]["link"]}");
   }else{
   
   } 
}
 
?>