<?php
// ===========================
// SEND EMAIL HANDLER
// ===========================

// Set JSON response header
header('Content-Type: application/json');

// Enable error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// ===========================
// CONFIGURATION
// ===========================

// Email configuration - CHANGE THESE VALUES
$ADMIN_EMAIL = 'contact@langues-pro.com';
$SCHOOL_NAME = 'École des Langues';
$SCHOOL_PHONE = '+33 (0)1 23 45 67 89';
$SCHOOL_ADDRESS = '123 Rue de la Paix, 75000 Paris, France';

// Whitelisted email domain (optional - remove if you want all emails)
// $ALLOWED_DOMAIN = 'example.com';

// Rate limiting (requests per minute)
$RATE_LIMIT = 5;
$RATE_LIMIT_TIME = 60; // seconds

// ===========================
// RESPONSE FUNCTION
// ===========================

function sendResponse($success, $message) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit();
}

// ===========================
// SECURITY CHECKS
// ===========================

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Méthode de requête non autorisée');
}

// Check if form was submitted
if (empty($_POST)) {
    sendResponse(false, 'Aucune donnée reçue');
}

// ===========================
// RATE LIMITING
// ===========================

session_start();

$current_time = time();
if (!isset($_SESSION['form_submissions'])) {
    $_SESSION['form_submissions'] = [];
}

// Clean old submissions
$_SESSION['form_submissions'] = array_filter($_SESSION['form_submissions'], function($time) use ($current_time) {
    return ($current_time - $time) < $RATE_LIMIT_TIME;
});

// Check rate limit
if (count($_SESSION['form_submissions']) >= $RATE_LIMIT) {
    sendResponse(false, 'Trop de requêtes. Veuillez attendre avant de renvoyer le formulaire.');
}

// Record this submission
$_SESSION['form_submissions'][] = $current_time;

// ===========================
// INPUT VALIDATION & SANITIZATION
// ===========================

// Helper function to validate and sanitize input
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

// Get and validate form fields
$name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
$email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
$phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
$subject = isset($_POST['subject']) ? sanitizeInput($_POST['subject']) : '';
$message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';

// ===========================
// VALIDATION RULES
// ===========================

// Validate name
if (empty($name)) {
    sendResponse(false, 'Le nom est requis');
}

if (strlen($name) < 2 || strlen($name) > 100) {
    sendResponse(false, 'Le nom doit contenir entre 2 et 100 caractères');
}

// Validate email
if (empty($email)) {
    sendResponse(false, 'L\'adresse email est requise');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendResponse(false, 'L\'adresse email n\'est pas valide');
}

// Validate phone (optional but if provided, must be valid format)
if (!empty($phone)) {
    if (!preg_match('/^[0-9\s\-\+\(\)]{6,20}$/', $phone)) {
        sendResponse(false, 'Le numéro de téléphone n\'est pas valide');
    }
}

// Validate subject
if (empty($subject)) {
    sendResponse(false, 'Le sujet est requis');
}

$allowed_subjects = ['inscription', 'information', 'entreprise', 'autre'];
if (!in_array(strtolower($subject), $allowed_subjects)) {
    sendResponse(false, 'Sujet invalide');
}

// Validate message
if (empty($message)) {
    sendResponse(false, 'Le message est requis');
}

if (strlen($message) < 10 || strlen($message) > 5000) {
    sendResponse(false, 'Le message doit contenir entre 10 et 5000 caractères');
}

// Check for spam patterns
$spam_keywords = ['viagra', 'casino', 'casino online', 'lottery', 'weight loss'];
$message_lower = strtolower($message);
foreach ($spam_keywords as $keyword) {
    if (strpos($message_lower, $keyword) !== false) {
        sendResponse(false, 'Votre message contient des mots non autorisés');
    }
}

// ===========================
// EMAIL COMPOSITION
// ===========================

// Email to admin
$admin_subject = "[Nouveau Formulaire] École des Langues - " . $subject;

$admin_message = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 8px; }
        .header { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { background: white; padding: 20px; }
        .field { margin-bottom: 15px; }
        .field-label { font-weight: bold; color: #2563eb; }
        .field-value { color: #333; padding: 10px; background: #f0f0f0; border-radius: 4px; margin-top: 5px; }
        .footer { background: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #666; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouveau Message de Formulaire de Contact</h2>
            <p>$SCHOOL_NAME</p>
        </div>
        <div class="content">
            <div class="field">
                <div class="field-label">Nom:</div>
                <div class="field-value">$name</div>
            </div>
            <div class="field">
                <div class="field-label">Email:</div>
                <div class="field-value"><a href="mailto:$email">$email</a></div>
            </div>
            <div class="field">
                <div class="field-label">Téléphone:</div>
                <div class="field-value">{$phone}</div>
            </div>
            <div class="field">
                <div class="field-label">Sujet:</div>
                <div class="field-value">$subject</div>
            </div>
            <div class="field">
                <div class="field-label">Message:</div>
                <div class="field-value" style="white-space: pre-wrap;">$message</div>
            </div>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
            <div style="font-size: 12px; color: #999;">
                <p><strong>Informations supplémentaires:</strong></p>
                <p>$user_ip = $_SERVER['REMOTE_ADDR'];: $_SERVER['REMOTE_ADDR']</p>
                <p>$current_date = date('d/m/Y H:i:s');</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2026 $SCHOOL_NAME. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
EOT;

// Email to user (confirmation)
$user_subject = "Confirmation de réception - $SCHOOL_NAME";

$user_message = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 8px; }
        .header { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { background: white; padding: 20px; }
        .footer { background: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #666; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Merci de nous avoir contacté!</h2>
            <p>$SCHOOL_NAME</p>
        </div>
        <div class="content">
            <p>Bonjour $name,</p>
            <p>Nous avons bien reçu votre message et nous vous remercions de votre intérêt pour $SCHOOL_NAME.</p>
            <p>Notre équipe examinera votre demande et vous répondra dans les 24 heures.</p>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
            <p><strong>Vos informations:</strong></p>
            <p><strong>Sujet:</strong> $subject<br>
            <strong>Date d'envoi:</strong> " . date('d/m/Y H:i:s') . "</p>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
            <p><strong>Coordonnées:</strong></p>
            <p>
                Adresse: $SCHOOL_ADDRESS<br>
                Téléphone: $SCHOOL_PHONE<br>
                Email: $ADMIN_EMAIL
            </p>
            <p>Cordialement,<br>
            L'équipe de $SCHOOL_NAME</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 $SCHOOL_NAME. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
EOT;

// ===========================
// SEND EMAILS
// ===========================

// Email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: " . $SCHOOL_NAME . " <noreply@langues-pro.com>\r\n";$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

try {
    // Send email to admin
    $admin_mail_sent = mail($ADMIN_EMAIL, $admin_subject, $admin_message, $headers);
    
    // Send confirmation email to user
    $user_headers = "MIME-Version: 1.0" . "\r\n";
    $user_headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $user_headers .= "From: " . $ADMIN_EMAIL . "\r\n";
    
    $user_mail_sent = mail($email, $user_subject, $user_message, $user_headers);
    
    if ($admin_mail_sent && $user_mail_sent) {
        // Log successful submission (optional)
        logMessage($name, $email, $subject, 'success');
        sendResponse(true, 'Votre message a été envoyé avec succès! Nous vous répondrons bientôt.');
    } else {
        logMessage($name, $email, $subject, 'failed');
        sendResponse(false, 'Erreur lors de l\'envoi du message. Veuillez réessayer plus tard.');
    }
} catch (Exception $e) {
    logMessage($name, $email, $subject, 'error: ' . $e->getMessage());
    sendResponse(false, 'Une erreur est survenue. Veuillez réessayer plus tard.');
}

// ===========================
// LOGGING FUNCTION
// ===========================

function logMessage($name, $email, $subject, $status) {
    $log_file = __DIR__ . '/logs.txt';
    
    // Create logs directory if it doesn't exist
    $log_dir = dirname($log_file);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $log_entry = date('Y-m-d H:i:s') . " | From: $name ($email) | Subject: $subject | Status: $status" . "\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

?>
