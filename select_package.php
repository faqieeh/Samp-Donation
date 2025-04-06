<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$character = findCharacter($_SESSION['username']);
if (!$character) {
    unset($_SESSION['username']);
    header("Location: index.php");
    exit();
}

if (isset($_POST['select_package'])) {
    $selected_vip = (int)$_POST['selected_vip'];
    
    if ($selected_vip < 1 || $selected_vip > count($vip_packages)) {
        $error = "Paket VIP tidak valid!";
    } else {
        $_SESSION['selected_vip'] = $selected_vip;
        header("Location: payment.php");
        exit();
    }
}

include 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-success">
            <h5 class="mb-1">Karakter ditemukan!</h5>
            <p class="mb-0">
                <strong>Nama:</strong> <?php echo htmlspecialchars($character['username']); ?> | 
                <strong>Level:</strong> <?php echo $character['level']; ?> | 
                <strong>Status VIP:</strong> <?php echo getVIPStatus($character['vip'], $character['vip_time']); ?>
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <h2 class="text-center">Pilih Paket VIP</h2>
        <p class="text-center">Pilih paket VIP yang sesuai dengan kebutuhan Anda</p>
    </div>
</div>

<form method="post">
    <input type="hidden" id="selected_vip" name="selected_vip" value="">
    
    <div class="row justify-content-center">
        <?php foreach ($vip_packages as $package): ?>
        <div class="col-md-4 mb-4">
            <div id="package-<?php echo $package['level']; ?>" class="card vip-card vip-<?php echo strtolower(explode(' ', $package['name'])[1]); ?>" onclick="selectPackage(<?php echo $package['level']; ?>)">
                <div class="card-body text-center">
                    <img src="assets/images/vip-badges/<?php echo strtolower(explode(' ', $package['name'])[1]); ?>.png" alt="<?php echo $package['name']; ?>" class="badge-vip">
                    <h4><?php echo $package['name']; ?></h4>
                    <h5 class="text-primary">Rp <?php echo number_format($package['price'], 0, ',', '.'); ?></h5>
                    <p><small>Durasi: <?php echo $package['duration']; ?> hari</small></p>
                    <hr>
                    <h6>Benefits:</h6>
                    <ul class="list-unstyled text-start">
                        <?php foreach ($package['benefits'] as $benefit): ?>
                        <li><i class="bi bi-check-circle-fill text-success"></i> <?php echo $benefit; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="row">
        <div class="col-12 text-center">
            <button type="submit" id="btn-continue" name="select_package" class="btn btn-lg btn-primary" disabled>Lanjut ke Pembayaran</button>
        </div>
    </div>
</form>

<?php include 'includes/footer.php'; ?>