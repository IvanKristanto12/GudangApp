function showWarna(idSampel) {
    if (idSampel == 0) {
        document.getElementById("selectWarna").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("selectWarna").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "getListWarna?inputId=" + idSampel, true);
        xmlhttp.send();
    }
}
