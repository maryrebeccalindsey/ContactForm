<?php
// Simple spam prevention (optional)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

// Sanitize input
$name = strip_tags(trim($_POST["name"]));
$email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$message = strip_tags(trim($_POST["message"]));

if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
    http_response_code(400);
    echo "Invalid input. Please check your entries.";
    exit;
}

// Prepare the email
$recipient = "maryrebeccalindsey@gmail.com"; // Change to your email
$subject = "New Contact Form Submission from RedPaw Cats";
$email_content = "Name: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Message:\n$message\n";
$email_headers = "From: $name <$email>";

// Send the email
if (mail($recipient, $subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo "Thank you for contacting us!";
} else {
    http_response_code(500);
    echo "Oops! Something went wrong, and we couldn't send your message.";
}
?>
