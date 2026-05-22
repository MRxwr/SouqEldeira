<?php
if (isset($_POST["enAbout"])) {
    if (updateDB("settings", $_POST, "`id` = '1'")) {
        header("LOCATION: ?v=WebPages");
    } else {
        ?>
        <script>
            alert("Could not process your request, Please try again.");
        </script>
        <?php
    }
}

$settings = selectDB("settings", "`id` = '1'");
$row = $settings[0];
?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark"><?php echo direction("Edit Website Pages", "تعديل صفحات الموقع") ?></h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row">
                            <!-- About Us -->
                            <div class="col-md-6 mb-30">
                                <label class="control-label mb-10 text-primary font-18 fw-bold"><?php echo direction("English About Us", "من نحن بالإنجليزي") ?></label>
                                <textarea name="enAbout" class="tinymce"><?php echo $row["enAbout"] ?></textarea>
                            </div>
                            <div class="col-md-6 mb-30">
                                <label class="control-label mb-10 text-primary font-18 fw-bold"><?php echo direction("Arabic About Us", "من نحن بالعربي") ?></label>
                                <textarea name="arAbout" class="tinymce"><?php echo $row["arAbout"] ?></textarea>
                            </div>

                            <div class="col-md-12"><hr class="light-grey-hr"></div>

                            <!-- Terms and Conditions -->
                            <div class="col-md-6 mb-30">
                                <label class="control-label mb-10 text-primary font-18 fw-bold"><?php echo direction("English Terms", "الشروط والأحكام بالإنجليزي") ?></label>
                                <textarea name="enTerms" class="tinymce"><?php echo $row["enTerms"] ?></textarea>
                            </div>
                            <div class="col-md-6 mb-30">
                                <label class="control-label mb-10 text-primary font-18 fw-bold"><?php echo direction("Arabic Terms", "الشروط والأحكام بالعربي") ?></label>
                                <textarea name="arTerms" class="tinymce"><?php echo $row["arTerms"] ?></textarea>
                            </div>

                            <div class="col-md-12"><hr class="light-grey-hr"></div>

                            <!-- Privacy Policy -->
                            <div class="col-md-6 mb-30">
                                <label class="control-label mb-10 text-primary font-18 fw-bold"><?php echo direction("English Policy", "سياسة الخصوصية بالإنجليزي") ?></label>
                                <textarea name="enPolicy" class="tinymce"><?php echo $row["enPolicy"] ?></textarea>
                            </div>
                            <div class="col-md-6 mb-30">
                                <label class="control-label mb-10 text-primary font-18 fw-bold"><?php echo direction("Arabic Policy", "سياسة الخصوصية بالعربي") ?></label>
                                <textarea name="arPolicy" class="tinymce"><?php echo $row["arPolicy"] ?></textarea>
                            </div>

                            <div class="col-md-12 mt-20 text-center">
                                <button type="submit" class="btn btn-primary btn-lg btn-block "><?php echo direction("Save Changes", "حفظ التعديلات") ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
