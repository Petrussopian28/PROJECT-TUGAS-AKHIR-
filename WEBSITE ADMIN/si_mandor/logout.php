<?php
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

// Jika ingin menghancurkan sesi juga, hapus juga cookie sesi.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Akhirnya, hancurkan sesi.
session_destroy();

// Mengirim respons ke client
$response = array(
    'status' => 'success',
    'message' => 'Logout berhasil'
);

echo json_encode($response);
?>
