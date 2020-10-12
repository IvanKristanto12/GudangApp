function setTotal() {
    var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
    var totalPcs = checkboxes.length;
    var totalMeter = 0;
    var listKain = "";
    if (checkboxes.length > 0) {
        for (var i = 0; i < checkboxes.length; i++) {
            totalMeter += checkboxes[i].parentElement.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.innerHTML * 1.0;
            listKain += checkboxes[i].value + ", ";
        }

    }
    document.getElementById("totalPcs").value = totalPcs;
    document.getElementById("totalMeter").value = totalMeter;
    document.getElementById("kain").value = listKain;

}

if (createPDF) {
    window.open('POPDF', '_blank');
}
