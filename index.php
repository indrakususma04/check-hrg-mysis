<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Check Harga Barang</title>

<link rel="stylesheet" href="style.css">

<!-- FONT POPPINS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<header class="header">

    <h1>CHECK HARGA</h1>

    <img src="./img/logo-toko.png" alt="Logo">

</header>


<main class="container">

<h2 class="scan-title">SCAN BARCODE</h2>

<input
type="text"
id="barcode"
placeholder="Scan Barcode..."
autocomplete="off"
autofocus
>

<section id="hasil">

<div class="nama-barang">
<h3>Nama Barang</h3>
<p id="namaBarang">-</p>
</div>

<div class="satuan">
<h3>Satuan</h3>
<p id="satuan">-</p>
</div>

<div class="harga-list">

<div class="harga-item">
<span id="labelHarga1">-</span>
</div>

<div class="harga-item">
<span id="labelHarga2">-</span>
</div>

<div class="harga-item">
<span id="labelHarga3">-</span>
</div>

</div>

</section>

</main>


<!-- MODAL -->

<div id="modal" class="modal">

<div class="modal-content">

<p id="modalMessage">Barang tidak ditemukan</p>

<button id="modalClose">Tutup</button>

</div>

</div>


<script src="script.js"></script>

</body>
</html>