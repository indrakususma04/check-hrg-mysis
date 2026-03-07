const barcodeInput = document.getElementById("barcode");

barcodeInput.addEventListener("keydown", function(e){

    if(e.key === "Enter"){

        let barcode = this.value;

        fetch("check-harga.php?barcode=" + barcode)
        .then(response => response.json())
        .then(data => {

            if(data.status === "success"){

                let barang = data.data[0];

                document.getElementById("namaBarang").innerText = barang.NAMA;
                document.getElementById("satuan").innerText = barang.SATUAN;
                document.getElementById("harga1").innerText = barang.harga1;
                document.getElementById("harga2").innerText = barang.harga2;
                document.getElementById("harga3").innerText = barang.harga3;

            }else{

                document.getElementById("namaBarang").innerText = "Barang tidak ditemukan";

            }

        });

        this.value = "";

    }

});