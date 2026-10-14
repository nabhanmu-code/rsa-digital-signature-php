# RSA Digital Signature in PHP

This small student project demonstrates a digital signature with RSA.

## Requirements

- XAMPP with PHP and OpenSSL enabled
- A web browser

## Run the program

1. Copy `rsa_signature.php` into the `htdocs` folder.
2. Start Apache in XAMPP.
3. Open `http://localhost/rsa_signature.php` in a browser.
4. Enter a message and click **إنشاء التوقيع** (Create Signature).

The program signs the message using the RSA private key and SHA-256. It checks the signature with the public key, then checks it again after changing the message.

## Expected result

The original message should pass verification. The changed message should fail verification.
