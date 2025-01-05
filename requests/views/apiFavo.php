<?php
if( isset($_GET["valid"]) && !empty($_GET["valid"]) ){
    if( $user = selectDBNew("users", [$_GET["valid"]], "`keepMeAlive` LIKE ?","") ){
        $userDetails["id"] = $user[0]["id"];
        if( $product = selectDBNew("products", [$_GET["id"]], "`id` = ?","") ){
            $listOfUsers = json_decode($product[0]["listOfUsers"],true);
            if( !is_null($listOfUsers) && !is_array($listOfUsers) ){
                $listOfUsers = array();
            }
            if( in_array($userDetails["id"],$listOfUsers) ){
                
                unset($listOfUsers[array_search($userDetails["id"],$listOfUsers)]);
                $listOfUsers = array_values($listOfUsers);
                $listOfUsers = json_encode($listOfUsers);
                updateDB("products",array("listOfUsers" => $listOfUsers),"`id` = '{$_GET["id"]}'");
                echo outputData(array("msg" => direction("Removed from favorites","تم حذف العقار من المفضلة")));die();
            }else{
                $listOfUsers = json_decode($product[0]["listOfUsers"],true);
                $listOfUsers[] = $userDetails["id"];
                $listOfUsers = array_values($listOfUsers);
                $listOfUsers = json_encode($listOfUsers);
                updateDB("products",array("listOfUsers" => $listOfUsers),"`id` = '{$_GET["id"]}'");
                echo outputData(array("msg" => direction("Added to favorites","تم إضافة العقار الى المفضلة")));die();
            }
        }else{
            echo outputError(array("msg" => "Poduct not found"));die();
        }
    }else{
        echo outputError(array("msg" => "User not found"));die();
    }
}else{
    echo outputError(array("msg" => "set validity code"));die();
}
?>