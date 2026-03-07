<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Check Harga Barang</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .header { display: flex; align-items: center; justify-content: space-between; background: #007bff; color: white; padding: 10px 20px; border-radius: 8px; }
        .header img { height: 50px; }
        .container { max-width: 500px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);}
        input[type=text] { width: 100%; padding: 10px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 20px; }
        .hasil-container { margin-top: 20px; }
        .harga-item { display: flex; justify-content: space-between; padding: 5px 0; font-size: 16px; }
        .harga-item span:first-child { font-weight: bold; }
        h3 { margin-bottom: 5px; }

        /* MODAL STYLE */
        .modal {
            display: none; /* hidden default */
            position: fixed; 
            z-index: 1000; 
            left: 0; top: 0; width: 100%; height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.5); 
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto; 
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .modal button {
            padding: 8px 16px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }
        .modal button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <header class="header">
        <h1 class="title">CHECK HARGA</h1>
        <div class="logo"><img src="./img/logo-toko.png" alt="Logo Toko"></div>
    </header>

    <main class="container">
        <h2 class="scan-title">SCAN BARCODE</h2>
        <input type="text" id="barcode" placeholder="Scan Barcode..." autocomplete="off" autofocus>

        <section id="hasil" class="hasil">
            <div class="hasil-container">
                <div class="nama-barang">
                    <h3>Nama Barang</h3>
                    <p id="namaBarang">-</p>
                </div>
                <div class="satuan">
                    <h3>Satuan</h3>
                    <p id="satuan">-</p>
                </div>
                <div class="harga-list">
                    <div class="harga-item"><span id="labelHarga1"></span></div>
                    <div class="harga-item"><span id="labelHarga2"></span></div>
                    <div class="harga-item"><span id="labelHarga3"></span></div>
                </div>
            </div>
        </section>
    </main>

    <!-- MODAL -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <p id="modalMessage">Barang tidak ditemukan!</p>
            <button id="modalClose">Tutup</button>
        </div>
    </div>

    <script>
        const barcodeInput = document.getElementById("barcode");
        const cacheBarang = {};

        const modal = document.getElementById("modal");
        const modalClose = document.getElementById("modalClose");
        const modalMessage = document.getElementById("modalMessage");

        function tampilBarang(barang) {
            document.getElementById("namaBarang").innerText = barang.NAMA || "-";
            document.getElementById("satuan").innerText = barang.SATUAN || "-";
            document.getElementById("labelHarga1").innerText = `Harga 1: ${barang.harga1 || "-"} / 'BELI'${barang.Q1 || "-"}`;
            document.getElementById("labelHarga2").innerText = `Harga 2: ${barang.harga2 || "-"} / 'BELI'${barang.Q2 || "-"}`;
            document.getElementById("labelHarga3").innerText = `Harga 3: ${barang.harga3 || "-"} / 'BELI'${barang.Q3 || "-"}`;
        }

        function resetField() {
            document.getElementById("namaBarang").innerText = "-";
            document.getElementById("satuan").innerText = "-";
            document.getElementById("labelHarga1").innerText = "Harga 1";
            document.getElementById("labelHarga2").innerText = "Harga 2";
            document.getElementById("labelHarga3").innerText = "Harga 3";
        }

        function showModal(message) {
            modalMessage.innerText = message;
            modal.style.display = "block";
        }

        modalClose.addEventListener("click", function() {
            modal.style.display = "none";
        });

        // tutup modal kalau klik di luar content
        window.addEventListener("click", function(e){
            if(e.target === modal) modal.style.display = "none";
        });

        barcodeInput.addEventListener("keydown", function(e) {
            if(e.key === "Enter" || e.keyCode === 13) {
                e.preventDefault();
                let barcode = this.value.trim().replace(/\s/g,'');

                if(!barcode) return;

                if(cacheBarang[barcode]){
                    tampilBarang(cacheBarang[barcode]);
                } else {
                    fetch("check-harga.php?barcode=" + encodeURIComponent(barcode))
                        .then(res => res.json())
                        .then(data => {
                            if(data.status === "success" && data.data.length > 0){
                                const barang = data.data[0];
                                barang.harga1 = barang.harga1 || "-";
                                barang.harga2 = barang.harga2 || "-";
                                barang.harga3 = barang.harga3 || "-";
                                barang.Q1 = barang.Q1 || "-";
                                barang.Q2 = barang.Q2 || "-";
                                barang.Q3 = barang.Q3 || "-";

                                cacheBarang[barcode] = barang;
                                tampilBarang(barang);
                            } else {
                                showModal("Barang tidak ditemukan!");
                                resetField();
                            }
                        })
                        .catch(err => {
                            console.error("Fetch error:", err);
                            showModal("Gagal membaca data dari server!");
                        });
                }

                this.value = "";
                setTimeout(resetField, 10000);
            }
        });
    </script>
</body>
</html>