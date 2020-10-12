var createPDF = false;

function showListKain(noPO) {
    if (noPO == 0) {
        document.getElementById("listKainTable").innerHTML = '<tr class="w3-yellow w3-border"><th class="w3-center">Pilih</th><th class="w3-center">Sampel</th><th class="w3-center">Warna</th><th class="w3-center">Nomor Karung</th><th class="w3-center">Meter</th></tr>';
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                var str = this.responseText.split("~");
                document.getElementById("listKainTable").innerHTML = str[1];
                document.getElementById("fieldDetailPO").innerHTML = str[2];
            }
        };
        xmlhttp.open("GET", "getByPO?inputNoPO=" + noPO, true);
        xmlhttp.send();
    }
}
