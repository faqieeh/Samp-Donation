<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['selected_vip'])) {
    header("Location: index.php");
    exit();
}

$character = findCharacter($_SESSION['username']);
if (!$character) {
    unset($_SESSION['username']);
    header("Location: index.php");
    exit();
}

$selected_vip = (int)$_SESSION['selected_vip'];
$selected_package = null;

foreach ($vip_packages as $package) {
    if ($package['level'] == $selected_vip) {
        $selected_package = $package;
        break;
    }
}

if (!$selected_package) {
    unset($_SESSION['selected_vip']);
    header("Location: select_package.php");
    exit();
}

// Generate transaction ID
$transaction_id = generateTransactionID();
$_SESSION['transaction_id'] = $transaction_id;

if (isset($_POST['process_payment'])) {
    $_SESSION['payment_success'] = true;
    
    if (updateVIP($character['username'], $selected_package['level'], $selected_package['duration'])) {
        header("Location: confirmation.php");
        exit();
    } else {
        $error = "Terjadi kesalahan saat memperbarui status VIP. Silakan coba lagi.";
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Pembayaran VIP</h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <h5>Detail Pesanan</h5>
                <table class="table">
                    <tr>
                        <td>Nama Karakter</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($character['username']); ?></td>
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
                    <tr>
                        <td>Harga</td>
                        <td>:</td>
                        <td>Rp <?php echo number_format($selected_package['price'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>ID Transaksi</td>
                        <td>:</td>
                        <td><?php echo $transaction_id; ?></td>
                    </tr>
                </table>
                
                <hr>
                
                <h5>Instruksi Pembayaran</h5>
                <p>Silakan transfer ke rekening berikut:</p>
                
                <div class="alert alert-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1"><strong>GoPay</strong></p>
                            <h5 class="mb-0">081315518906</h5>
                            <p class="mb-0 mt-2"><small>Atas nama: Admin Server GTA SAMP</small></p>
                        </div>
                        <div>
                            <img src="assets/images/gopay.png" alt="GoPay" width="100">
                        </div>
                    </div>
                </div>
                
                <p>Nominal Transfer: <strong>Rp <?php echo number_format($selected_package['price'], 0, ',', '.'); ?></strong></p>
                
                <div class="alert alert-warning">
                    <p class="mb-0"><strong>Penting:</strong> Setelah melakukan pembayaran, klik tombol "Konfirmasi Pembayaran" di bawah ini untuk mengaktifkan VIP Anda.</p>
                </div>
                
                <form method="post" class="mt-4">
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Bukti Pembayaran (Opsional)</label>
                        <input type="file" class="form-control" id="payment_proof">
                        <small class="text-muted">Jika diperlukan, upload screenshot bukti pembayaran Anda</small>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="payment_confirm" required>
                        <label class="form-check-label" for="payment_confirm">
                            Saya menyatakan telah melakukan pembayaran sesuai nominal yang tertera di atas.
                        </label>
                    </div>
                    
                    <button type="submit" name="process_payment" class="btn btn-success w-100">Konfirmasi Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>