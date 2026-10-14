<?php

$message = "Hello, this is my message";
$signatureText = "";
$verifyText = "";
$changeText = "";

$opensslConfig = "C:/xampp/php/extras/ssl/openssl.cnf";
if (file_exists($opensslConfig)) {
    putenv("OPENSSL_CONF=" . $opensslConfig);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST["message"] ?? "";


    $privateKey = openssl_pkey_new([
        "config" => $opensslConfig,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
        "private_key_bits" => 2048
    ]);

    if ($privateKey === false) {
        $signatureText = "حدث خطأ أثناء إنشاء المفاتيح: ";
        while ($opensslError = openssl_error_string()) {
            $signatureText .= $opensslError . " ";
        }
    } else {

        $details = openssl_pkey_get_details($privateKey);
        $publicKey = $details["key"];


        openssl_sign($message, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $signatureText = base64_encode($signature);


        $check = openssl_verify($message, $signature, $publicKey, OPENSSL_ALGO_SHA256);
        if ($check == 1) {
            $verifyText = "التوقيع صحيح للرسالة الأصلية";
        } else {
            $verifyText = "التوقيع غير صحيح";
        }


        $changedMessage = $message . " changed";
        $changedCheck = openssl_verify($changedMessage, $signature, $publicKey, OPENSSL_ALGO_SHA256);

        if ($changedCheck == 0) {
            $changeText = "بعد تغيير الرسالة أصبح التوقيع غير صحيح";
        } else {
            $changeText = "لم يتم التحقق من الرسالة المعدلة";
        }
    }
}

function safeText($text)
{
    return htmlspecialchars($text, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تجربة توقيع RSA</title>
</head>

<body>
    <h1>تجربة التوقيع الرقمي RSA</h1>
    <p>في هذا المثال نوقع رسالة ثم نتأكد أن التوقيع صحيح.</p>

    <form method="post">
        <label for="message">اكتب الرسالة:</label><br>
        <textarea id="message" name="message" rows="4" cols="50" required><?= safeText($message) ?></textarea><br>
        <button type="submit">إنشاء التوقيع</button>
    </form>

    <?php if ($signatureText != ""): ?>
        <h2>التوقيع</h2>
        <p><?= safeText($signatureText) ?></p>
        <h2>فحص الرسالة الأصلية</h2>
        <p><?= safeText($verifyText) ?></p>
        <h2>فحص الرسالة بعد تغييرها</h2>
        <p><?= safeText($changeText) ?></p>
    <?php endif; ?>
</body>

</html>
