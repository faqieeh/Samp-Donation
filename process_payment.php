<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['username']) || !isset($_SESSION['selected_vip'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$selected_vip = (int)$_SESSION['selected_vip'];
$transaction_id = $_SESSION['transaction_id'];

$selected_package = null;
foreach ($vip_packages as $package) {
    if ($package['level'] == $selected_vip) {
        $selected_package = $package;
        break;
    }
}

if (!$selected_package) {

    $_SESSION['error'] = "Paket VIP tidak valid!";
    header("Location: select_package.php");
    exit();
}

if (updateVIP($username, $selected_package['level'], $selected_package['duration'])) {
    $_SESSION['payment_success'] = true;
    header("Location: confirmation.php");
} else {
    $_SESSION['error'] = "Gagal memperbarui status VIP. Silakan coba lagi.";
    header("Location: payment.php");
}
exit();
?>