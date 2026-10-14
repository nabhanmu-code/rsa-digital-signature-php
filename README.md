# RSA Digital Signature in PHP

This small PHP student project demonstrates an RSA digital signature.

## Requirements

- XAMPP with PHP and the OpenSSL extension enabled
- A web browser

## Run the program

1. Put `rsa_signature.php` in `C:\\xampp\\htdocs\\nabhan` (or another folder inside `htdocs`).
2. Start Apache in XAMPP.
3. Open `http://localhost/nabhan/rsa_signature.php` in a browser.
4. Enter a message and click **إنشاء التوقيع** (Create Signature).

The program creates an RSA key pair, signs the message using the private key and SHA-256, and checks the signature with the public key. It then checks the same signature after changing the message.

## Expected result

The original message should pass verification. The changed message should fail verification.
