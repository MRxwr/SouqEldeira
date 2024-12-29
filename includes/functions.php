<?php
 function getMyAds($id, $tp='expired'){
    if($tp == 'expired'){
        $date = date("Y-m-d");
        $myads = selectDB("products"," `expiryDate` > '{$date}' AND `status` = '0' AND `userId` = '{$id}'");
    }else{
        $myads = selectDB("products"," `expiryDate` < '{$date}' AND `status` = '0' AND `userId` = '{$id}'");
    }
    return $myads;
 }