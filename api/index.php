<?php

require 'config.php';

// Error reporting setup
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Set the Content-Type header for JSON responses
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data from the POST request
    $inputData = $_POST;

    // Initialize an array to hold the sanitized data
    $sanitizedData = [];

    $sanitizedData['userIp'] = getClientIP();
    $sanitizedData['date'] = date('Y-m-d H:i:s');

    // Iterate over each piece of data
    foreach ($inputData as $key => $value) {
        // Sanitize the data (e.g., remove potentially harmful characters)
        // $sanitizedData[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        $sanitizedData[$key] = $value;
    }

    // Prepare the message to be sent
    $message = "New input data received:<br>\n";
    //json_encode($sanitizedData, JSON_PRETTY_PRINT);

    foreach ($sanitizedData as $key => $value) {
        $message .= ucfirst(str_replace('_', ' ', $key)) . ": " . $value . "<br>\n";
    }


    $status = false;
    $errors = [];

    // Send the message via email
    if ($sendViaMail) {
        $mailResponse = sendMail($message, 'New Form Submitted', 'uploads/' . $file_name);
        if ($mailResponse['status']) {
            $status = true;
        } else {
            $errors['mail'] = $mailResponse['message'];
        }
    }

    // Send the message via Telegram bot
    if ($sendViaTelegram) {
        $telegramResponse = sendTelegramDocument($botToken, $chatId, $message, 'uploads/' . $file_name);
        if ($telegramResponse->ok) {
            $status = true;
        } else {
            $errors['bot'] = $telegramResponse->description;
        }
    }

    // Set the HTTP status code based on the responses
    if ($status) {
        http_response_code(200); // OK
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to send message',
            'errors' => $errors
        ]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

function sendMail($message, $subject = 'New Contact Form Submitted')
{
    require 'config.php';

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = $emailHost;
        $mail->SMTPAuth = true;
        $mail->Username = $emailUsername;
        $mail->Password = $emailPassword;
        $mail->SMTPSecure = $emailEnc;
        $mail->Port = $emailPort;

        // Recipients
        $mail->setFrom($sendFromEmail, $sendFromName);
        $mail->addAddress($sendToEmail, $sendToName);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;

        $mail->send();

        return [
            'status' => true,
            'message' => 'Message has been sent'
        ];
    } catch (Exception $e) {
        error_log($mail->ErrorInfo);
        error_log($e->getMessage());
        return [
            'status' => false,
            'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        ];
    }
}

function sendTelegramDocument($botToken, $chatId, $message)
{
    try {
        // Prepare the API URL
        $apiUrl = "https://api.telegram.org/bot" . $botToken . "/sendMessage";

        // Prepare the POST data
        $postData = [
            'chat_id' => $chatId,
            'text' => $message,
        ];

        // Initialize cURL
        $ch = curl_init($apiUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        // Execute the cURL request
        $response = curl_exec($ch);

        // Close cURL
        curl_close($ch);

        // Decode the JSON response
        return json_decode($response);
    } catch (Error $e) {
        error_log($e->getMessage());
        return [
            'status' => false,
            'message' => "Message could not be sent. Error: {$e->getMessage()}"
        ];
    }
}

function getClientIP()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}
