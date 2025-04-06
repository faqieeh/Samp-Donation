<?php

function findCharacter($username) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT username, level, vip, vip_time FROM players WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function updateVIP($username, $vip_level, $duration_days) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $vip_level = (int)$vip_level;
    $duration_seconds = $duration_days * 86400;
    
    $query = "UPDATE players SET vip = $vip_level, 
              vip_time = CASE 
                WHEN vip_time > 0 THEN vip_time + $duration_seconds 
                ELSE UNIX_TIMESTAMP() + $duration_seconds 
              END 
              WHERE username = '$username'";
              
    return mysqli_query($conn, $query);
}

$vip_packages = [
    [
        'level' => 1,
        'name' => 'VIP Bronze',
        'price' => 25000,
        'duration' => 30, // hari
        'benefits' => [
            'Spawn dengan $10,000',
            'Akses VIP Lounge',
            '2 Slot Kendaraan Tambahan',
            'Tag VIP di Chat'
        ]
    ],
    [
        'level' => 2,
        'name' => 'VIP Silver',
        'price' => 50000,
        'duration' => 30,
        'benefits' => [
            'Spawn dengan $20,000',
            'Akses VIP Lounge',
            '5 Slot Kendaraan Tambahan',
            'Tag VIP di Chat',
            'Akses ke Senjata Khusus'
        ]
    ],
    [
        'level' => 3,
        'name' => 'VIP Gold',
        'price' => 100000,
        'duration' => 30,
        'benefits' => [
            'Spawn dengan $50,000',
            'Akses VIP Lounge',
            '10 Slot Kendaraan Tambahan',
            'Tag VIP di Chat',
            'Akses ke Senjata Khusus',
            'Teleport ke Lokasi VIP',
            'Custom Skin Eksklusif'
        ]
    ]
];

function getVIPStatus($vip_level, $vip_time) {
    if ($vip_level == 0 || $vip_time <= 0) {
        return "Tidak memiliki VIP";
    }
    
    $vip_names = [1 => "Bronze", 2 => "Silver", 3 => "Gold"];
    $vip_name = isset($vip_names[$vip_level]) ? $vip_names[$vip_level] : "Unknown";
    
    $time_left = $vip_time - time();
    if ($time_left <= 0) {
        return "VIP $vip_name (Expired)";
    }
    
    $days_left = floor($time_left / 86400);
    return "VIP $vip_name ($days_left hari tersisa)";
}

// Fungsi untuk generate ID transaksi
function generateTransactionID() {
    return "VIP" . date("YmdHis") . rand(100, 999);
}
?>