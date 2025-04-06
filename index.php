<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$error = "";
$character = null;

if (isset($_POST['check_username'])) {
    $username = trim($_POST['username']);
    
    if (empty($username)) {
        $error = "Silakan masukkan nama karakter Anda!";
    } else {
        $character = findCharacter($username);
        
        if ($character) {
            $_SESSION['username'] = $character['username'];
            header("Location: select_package.php");
            exit();
        } else {
            $error = "Karakter dengan nama '$username' tidak ditemukan!";
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Cek Karakter Anda</h5>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <p>Sebelum melakukan donasi VIP, silakan masukkan nama karakter Anda untuk verifikasi:</p>
                
                <form method="post" onsubmit="return validateUsernameForm()">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nama Karakter</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan nama karakter dalam game" required>
                        <small class="text-muted">Contoh: Faqih_Ganteng (gunakan "_")</small>
                    </div>
                    <button type="submit" name="check_username" class="btn btn-primary w-100">Cek Karakter</button>
                </form>
            </div>
            <div class="card-footer">
                <p class="mb-0 text-center">Donasi VIP membantu server kami tetap berjalan dan memberikan Anda benefit eksklusif dalam game!</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>