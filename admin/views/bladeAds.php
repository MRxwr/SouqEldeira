<?php
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB("products",array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Ads");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB("products",array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Ads");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB("products",array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Ads");
	}
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark"><?php echo direction("Ads List","قائمة الإعلانات") ?></h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table class="table display responsive product-overview mb-30" id="myTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo direction("Date","التاريخ") ?></th>
                                        <th><?php echo direction("Title","العنوان") ?></th>
                                        <th><?php echo direction("User / Shop","المستخدم / المحل") ?></th>
                                        <th><?php echo direction("Category","القسم") ?></th>
                                        <th><?php echo direction("Property Type","نوع العقار") ?></th>
                                        <th><?php echo direction("Price","السعر") ?></th>
                                        <th><?php echo direction("Type","النوع") ?></th>
                                        <th><?php echo direction("Status","الحالة") ?></th>
                                        <th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if( $products = selectDB("products","`status` = '0' ORDER BY `id` DESC") ){
                                        for( $i = 0; $i < sizeof($products); $i++ ){
                                            $counter = $i + 1;
                                            
                                            // Get User/Shop Label
                                            $userLabel = "Guest";
                                            if ($products[$i]["shopId"] != 0) {
                                                if ($shop = selectDB("shops", "`id` = '{$products[$i]["shopId"]}'")) {
                                                    $userLabel = direction($shop[0]["enTitle"], $shop[0]["arTitle"]) . " (Shop)";
                                                }
                                            } elseif ($products[$i]["userId"] != 0) {
                                                if ($userObj = selectDB("users", "`id` = '{$products[$i]["userId"]}'")) {
                                                    $userLabel = $userObj[0]["name"] . " (User)";
                                                }
                                            }

                                            // Get Category Label
                                            $categoryLabel = "";
                                            if ($category = selectDB("categories", "`id` = '{$products[$i]["categoryId"]}'")) {
                                                $categoryLabel = direction($category[0]["enTitle"], $category[0]["arTitle"]);
                                            }

                                            // Get Property Type Label
                                            $propertyTypeLabel = "";
                                            if ($propertyType = selectDB("propertyType", "`id` = '{$products[$i]["propertyType"]}'")) {
                                                $propertyTypeLabel = direction($propertyType[0]["enTitle"], $propertyType[0]["arTitle"]);
                                            }

                                            $adType = ($products[$i]["adType"] == 1) ? direction("Regular", "عادي") : direction("Special", "مميز");
                                            
                                            if ( $products[$i]["hidden"] == 2 ){
                                                $icon = "fa fa-eye";
                                                $link = "?v=Ads&show={$products[$i]["id"]}";
                                                $hideText = direction("Show","إظهار");
                                                $statusText = "<span class='label label-warning'>".direction("Hidden", "مخفي")."</span>";
                                            }else{
                                                $icon = "fa fa-eye-slash";
                                                $link = "?v=Ads&hide={$products[$i]["id"]}";
                                                $hideText = direction("Hide","إخفاء");
                                                $statusText = "<span class='label label-success'>".direction("Live", "نشط")."</span>";
                                            }
                                    ?>
                                    <tr>
                                        <td><?php echo $counter ?></td>
                                        <td><?php echo date("Y-m-d", strtotime($products[$i]["date"])) ?></td>
                                        <td><?php echo direction($products[$i]["enTitle"], $products[$i]["arTitle"]) ?></td>
                                        <td><?php echo $userLabel ?></td>
                                        <td><?php echo $categoryLabel ?></td>
                                        <td><?php echo $propertyTypeLabel ?></td>
                                        <td><?php echo $products[$i]["price"] ?></td>
                                        <td><?php echo $adType ?></td>
                                        <td><?php echo $statusText ?></td>
                                        <td class="text-nowrap">
                                            <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hideText ?>"> 
                                                <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
                                            </a>
                                            <a href="?v=Ads&delId=<?php echo $products[$i]["id"] ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>" onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-close text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
