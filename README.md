<h1 align="center">💸 MetroUnity - Website Donasi Otomatis untuk Server SAMP</h1>

<p align="center">
  Website donasi khusus untuk developer GTA SAMP yang ingin menyediakan sistem <strong>VIP otomatis</strong> untuk para pemainnya.
  <br />
  <br />
  <img src="https://img.shields.io/badge/status-stable-brightgreen?style=flat-square" />
  <img src="https://img.shields.io/badge/made%20with-PHP-blue?style=flat-square" />
  <img src="https://img.shields.io/badge/payment-Tripay-orange?style=flat-square" />
  <img src="https://img.shields.io/github/license/faqieeh/Samp-Donation?style=flat-square" />
</p>

---

## ✨ Fitur Utama

- 🔎 Validasi nama karakter secara real-time (AJAX)
- 🎁 Sistem donasi VIP otomatis tanpa login
- 💳 Integrasi penuh dengan Tripay Payment Gateway
- 📦 Pilihan paket VIP dengan UI ala Codashop
- 🌙 Tema dark elegan, cocok buat komunitas gaming
- 🔧 Mudah disesuaikan dengan database GM kalian

---

## 📸 Tampilan Website

<p align="center">
  <img src="screenshots/input.png" alt="Input Nama" width="250"/> 
  <img src="screenshots/packages.png" alt="Paket VIP" width="250"/> 
  <img src="screenshots/payment.png" alt="Pembayaran" width="250"/>
</p>

---

## ⚙️ Cara Penggunaan

1. **Clone repo** ini ke hosting atau localhost kamu
2. Edit `config.php` dan sesuaikan koneksi database
3. Pastikan struktur tabel di database kamu sesuai:
   ```sql
   TABLE: players
   COLUMNS: username, vip, vip_time, gold
