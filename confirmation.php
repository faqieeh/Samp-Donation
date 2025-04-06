<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['payment_success']) || !$_SESSION['payment_success']) {
    header("Location: index.php");
    exit();
}

$character = findCharacter($_SESSION['username']);
$selected_vip = (int)$_SESSION['selected_vip'];
$selected_package = null;

foreach ($vip_packages as $package) {
    if ($package['level'] == $selected_vip) {
        $selected_package = $package;
        break;
    }
}

$transaction_id = $_SESSION['transaction_id'];
$username = $_SESSION['username'];

unset($_SESSION['username']);
unset($_SESSION['selected_vip']);
unset($_SESSION['transaction_id']);
unset($_SESSION['payment_success']);

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Pembayaran Berhasil!</h5>
            </div>
            <div class="card-body">
                <div class="my-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                
                <h4>Terima Kasih, <?php echo htmlspecialchars($username); ?>!</h4>
                <p>VIP <?php echo $selected_package['name']; ?> Anda telah berhasil diaktifkan.</p>
                
                <table class="table">
                    <tr>
                        <td>ID Transaksi</td>
                        <td>:</td>
                        <td><?php echo $transaction_id; ?></td>
                    </tr>
                    <tr>
                        <td>Paket VIP</td>
                        <td>:</td>
                        <td><?php echo $selected_package['name']; ?></td>
                    </tr>
                    <tr>
                        <td>Durasi</td>
                        <td>:</td>
                        <td><?php echo $selected_package['duration']; ?> hari</td>
                    </tr>
                </table>
                
                <div class="alert alert-info">
                    <p class="mb-0">Silahkan login ke dalam game untuk mulai menikmati benefit VIP Anda!</p>
                </div>
                
                <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>