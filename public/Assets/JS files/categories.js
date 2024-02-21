// alert();
document.getElementById("pdf").onclick = () => {
    console.log("YES");

    var table = document.getElementById("table");

    var opt = {
        margin: 1,
        filename: 'myfile.pdf',
        image: {type: 'jpeg', quality: 0.98},
        html2canvas: {scale: 2},
        jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
    }

    html2pdf(table, opt);

}

document.querySelector("#excel").addEventListener("click", () => {
    console.log("YES");
})

