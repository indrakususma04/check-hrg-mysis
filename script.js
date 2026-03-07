const barcodeInput=document.getElementById("barcode");

const cacheBarang={};

const modal=document.getElementById("modal");

const modalClose=document.getElementById("modalClose");

const modalMessage=document.getElementById("modalMessage");

function tampilBarang(barang){

document.getElementById("namaBarang").innerText=barang.NAMA||"-";

document.getElementById("satuan").innerText=barang.SATUAN||"-";

document.getElementById("labelHarga1").innerText=
`Harga 1 : Rp ${barang.harga1||"-"} (Minimal ${barang.Q1||"-"})`;

document.getElementById("labelHarga2").innerText=
`Harga 2 : Rp ${barang.harga2||"-"} (Minimal ${barang.Q2||"-"})`;

document.getElementById("labelHarga3").innerText=
`Harga 3 : Rp ${barang.harga3||"-"} (Minimal ${barang.Q3||"-"})`;

}

function resetField(){

document.getElementById("namaBarang").innerText="-";

document.getElementById("satuan").innerText="-";

document.getElementById("labelHarga1").innerText="";

document.getElementById("labelHarga2").innerText="";

document.getElementById("labelHarga3").innerText="";

}

function showModal(message){

modalMessage.innerText=message;

modal.style.display="block";

}

modalClose.onclick=function(){

modal.style.display="none";

}

window.onclick=function(e){

if(e.target===modal){

modal.style.display="none";

}

}

barcodeInput.addEventListener("keydown",function(e){

if(e.key==="Enter"){

e.preventDefault();

let barcode=this.value.trim();

if(!barcode)return;

if(cacheBarang[barcode]){

tampilBarang(cacheBarang[barcode]);

}else{

fetch("check-harga.php?barcode="+encodeURIComponent(barcode))

.then(res=>res.json())

.then(data=>{

if(data.status==="success"&&data.data.length>0){

const barang=data.data[0];

cacheBarang[barcode]=barang;

tampilBarang(barang);

}else{

showModal("Barang tidak ditemukan");

resetField();

}

})

.catch(()=>{

showModal("Gagal mengambil data");

});

}

this.value="";

setTimeout(resetField,10000);

}

});