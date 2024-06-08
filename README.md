<p align="center">Laravel Email Sending Setup</p>
This guide will walk you through configuring email sending in your Laravel project using Gmail's SMTP server.
## Prerequisites
-A Google account with access to Gmail
-A Laravel project set up on your local machine
-Composer installed

## Step 1: Configure Google Account for App Password
1. Go to your Google Account.
2. Navigate to the Security tab.
3. Under Signing in to Google, select App passwords.
4. Generate a new app password and copy the key. Save this key securely as you will need it for your Laravel project.

## Step 2: Create a New Laravel Project
If you haven't created a Laravel project yet, you can create one using the following command:
# composer create-project laravel/laravel:^10.0 emailsending-app

## Step 3: Configure .env File for Email
Open your '.env' file and update the following lines with your Gmail and app password details:
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
Replace your-email@gmail.com with your Gmail address and your-app-password with the app password you generated.

## Step 4: Create a Mailable Class
Run the following command to create a mailable class:
php artisan make:mail SendMail
This will create a file at app/Mail/SendMail.php. Update this file with the following code:
class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Email Notification')
                    ->view('email.sendEmail');
    }
}

## Step 5: Create Email View
Create a new directory named email inside resources/views, and then create a file named sendEmail.blade.php inside the email directory with the following content:
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <p>{{ $mailData['body'] }}</p>
    <p>Thanks,</p>
    <p>Your Company Name</p>
</body>
</html>

## Step 6: Create a Controller
Run the following command to create a controller:
php artisan make:controller SendMailController
Update the SendMailController.php file with the following code:
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
class SendMailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Ghansham Soomarani',
            'body' => 'This mail is for testing purposes'
        ];
        Mail::to('receiver@example.com')->send(new SendMail($mailData));
        return response()->json(['message' => 'Email sent successfully!'], 200);
    }
}
Replace receiver@example.com with the email address of the recipient.

## Step 7: Define a Route
Open routes/web.php and add the following route:
use App\Http\Controllers\SendMailController;
Route::get('/sendmail', [SendMailController::class, 'index'])->name('sendMail');

## Step 8: Create a Button to Send Email
Open resources/views/welcome.blade.php and add a button to trigger the email sending:
## Step 9: Run Your Application
Start your Laravel application by running:
php artisan serve
Visit http://127.0.0.1:8000 in your browser and click the "Send Test Email" button to send a test email.
