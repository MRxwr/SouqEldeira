<?php
// Handle "Change phone number" manual reset
if (isset($_GET["reset"]) && $_GET["reset"] == "phone") {
    unset($_SESSION["pending_phone"]);
    header("Location: /login");
    die();
}

// Step 1: Request OTP
if (isset($_POST["send_otp"]) && !empty($_POST["phone"])) {
    unset($_SESSION["pending_phone"]);
    $phone = $_POST["phone"];
    $code = rand(100000, 999999);
    
    // Cleanup old codes for this phone
    if (function_exists('deleteDB')) {
        deleteDB("phone_verifications", "`phone` = '{$phone}'");
    }
    
    // Store new code in DB
    $data = array(
        "phone" => $phone,
        "code" => $code,
        "expiry" => date("Y-m-d H:i:s", strtotime("+10 minutes"))
    );
    
    if (insertDB("phone_verifications", $data)) {
        whatsappUltraMsgVerify($phone, $code);
        $_SESSION["pending_phone"] = $phone;
        $successMsg = direction("OTP sent successfully to your WhatsApp", "تم إرسال رمز التحقق بنجاح إلى الواتساب الخاص بك");
    } else {
        $msg = direction("Error sending OTP", "خطأ في إرسال رمز التحقق");
    }
}

// Step 2: Verify OTP
if (isset($_POST["verify_otp"]) && !empty($_POST["otp_code"]) && isset($_SESSION["pending_phone"])) {
    $phone = $_SESSION["pending_phone"];
    $otp = trim($_POST["otp_code"]); // trim to remove any spaces
    
    // We remove the expiry check for a moment to debug if it is a timezone issue
    $check = selectDBNew("phone_verifications", [$phone, $otp], "`phone` = ? AND `code` = ?", "");
    
    if ($check) {
        $expiryTime = strtotime($check[0]["expiry"]);
        $currentTime = time();
        
        if ($currentTime > $expiryTime) {
            $msg = direction("Code expired. Please request a new one.", "انتهت صلاحية الرمز. يرجى طلب رمز جديد.");
        } else {
            // Success! Remove verification entry
            if (function_exists('deleteDB')) {
                deleteDB("phone_verifications", "`phone` = '{$phone}'");
            }
        
            // 1. Check if user exists
            $users = selectDBNew("users", [$phone], "`phone` = ?", "");
            
            if (!$users) {
                // Register new user
                $GenerateNewCC = md5(rand());
                $userData = array(
                    "phone" => $phone,
                    "name" => "user_" . $phone, // Placeholder
                    "username" => "user_" . $phone, // Placeholder
                    "status" => 0,
                    "hidden" => 0,
                    "keepMeAlive" => $GenerateNewCC
                );
                insertDB("users", $userData);
                $users = selectDBNew("users", [$phone], "`phone` = ?", "");
            } else {
                $GenerateNewCC = md5(rand());
                updateDB("users", array("keepMeAlive" => $GenerateNewCC), "`id` = '{$users[0]["id"]}'");
            }
            
            // 2. Set Sessions and Cookies
            $_SESSION["timeout"] = time() + (86400 * 30);
            $_SESSION[$cookieSession] = $GenerateNewCC;
            
            // Set cookie with security flags for better Safari/iOS compatibility
            $cookieOptions = [
                'expires' => time() + (86400 * 30),
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Lax'
            ];
            setcookie($cookieSession, $GenerateNewCC, $cookieOptions);
            
            unset($_SESSION["pending_phone"]);
            header("Location: /home");
            die();
        }
    } else {
        $msg = direction("Invalid or expired OTP", "رمز التحقق غير صحيح أو منتهي الصلاحية");
    }
}

if( isset($_GET["error"]) ){
    if( $_GET["error"] == "status" ){
        $msg = direction("Your account is blocked", "تم حظر حسابك");
    }elseif( $_GET["error"] == "blocked" ){
        $msg = direction("Your account is locked", "تم قفل حسابك");
    }elseif( $_GET["error"] == "login" ){
        $msg = direction("Login failed", "فشل تسجيل الدخول");
    }
}
?>

<div class="row">
    <div class="col-md-11 mx-auto">
        <div class="guest-form-action">
            <div class="form-container mt-5">
                <form id="login-form" method="post" action="/login">
                    <div class="mb-4 text-center">
                        <img src="assets/img/logo-1.png" class="img-fluid" alt="...">
                    </div>

                    <?php if (!empty($msg)) { ?>
                        <div class="alert alert-danger d-flex align-items-center py-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $msg; ?>
                        </div>
                    <?php } ?>

                    <?php if (!empty($successMsg)) { ?>
                        <div class="alert alert-success d-flex align-items-center py-2" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> <?php echo $successMsg; ?>
                        </div>
                    <?php } ?>

                    <?php if (!isset($_SESSION["pending_phone"])) { ?>
                        <!-- Step 1: Input Phone -->
                        <div class="form-outline mb-4">
                            <h1><?php echo direction("Phone Number (with country code)", "رقم الهاتف مع كود الدولة"); ?></h1>
                            <input type="text" class="form-control" name="phone" placeholder="96512345678" required />
                            <div class="form-text mt-2"><?php echo direction("Example: 965XXXXXXXX", "مثال: 965XXXXXXXX"); ?></div>
                        </div>
                        <button type="submit" name="send_otp" class="btn btn-primary btn-block w-100 mb-4 py-2">
                            <?php echo direction("Send Verification Code", "إرسال رمز التحقق"); ?>
                        </button>
                    <?php } else { ?>
                        <!-- Step 2: Input OTP -->
                        <div class="form-outline mb-4">
                            <h1><?php echo direction("Enter Verification Code", "أدخل رمز التحقق"); ?></h1>
                            <input type="text" class="form-control text-center" name="otp_code" maxlength="6" placeholder="000000" style="letter-spacing: 10px; font-size: 24px; font-weight: bold;" required />
                            <div class="form-text mt-2 text-center">
                                <?php echo direction("Code sent to: ", "تم إرسال الرمز إلى: "); ?> <b><?php echo $_SESSION["pending_phone"]; ?></b>
                            </div>
                        </div>
                        <button type="submit" name="verify_otp" class="btn btn-success btn-block w-100 mb-3 py-2">
                            <?php echo direction("Verify and Login", "تحقق وتسجيل الدخول"); ?>
                        </button>
                        <div class="text-center">
                            <a href="/reset-phone" class="text-muted"><?php echo direction("Change phone number", "تغيير رقم الهاتف"); ?></a>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
