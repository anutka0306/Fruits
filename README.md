
## Install Project

1. Copy project from github to you local server
git clone https://github.com/anutka0306/Fruits.git
2. Create database and change in .env database connection parameters
   
3.In you terminal:<br>
composer update<br>
php bin/console migrate
4. In terminal:<br>
npm install<br>
npm run dev

5. In terminal:<br>
   symfony serve

## Console command for receive fruits
php bin/console fruits:get-fruits

## Email sending
1. In .env file you need to write configuration for send email
MAILER_DSN=gmail://yourmail@gmail.com:app_password@default?verify_peer=0

You can generate them in your account Google
   
2. In src/Controller/MailerController.php you can change email address of sender and letter recipient: function sendEmail

   