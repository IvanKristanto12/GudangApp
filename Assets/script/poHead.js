var createPDF = false;

function showListKain(noSO) {
    if (noSO == 0) {
        document.getElementById("listKainTable").innerHTML = '<tr class="w3-yellow w3-border"><th class="w3-center">Pilih</th><th class="w3-center">Sampel</th><th class="w3-center">Warna</th><th class="w3-center">Nomor Karung</th><th class="w3-center">Meter</th><th class="w3-center">Tanggal Masuk</th></tr>';
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var str = this.responseText.split("~");
                document.getElementById("listKainTable").innerHTML = str[1];
                document.getElementById("fieldDetailSO").innerHTML = str[2];
                document.getElementById("pilihPenjual").innerHTML = str[3];
                document.getElementById("pilihPembeli").innerHTML = str[4];
            }
        };
        xmlhttp.open("GET", "getBySO?inputNoSO=" + noSO, true);
        xmlhttp.send();
    }
}
