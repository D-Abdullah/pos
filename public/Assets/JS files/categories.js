// alert();
// document.getElementById("pdf").onclick = () => {
//     console.log("YES");

//     var table = document.getElementById("table");

//     var opt = {
//         margin: 1,
//         filename: "myfile.pdf",
//         image: { type: "jpeg", quality: 0.98 },
//         html2canvas: { scale: 2 },
//         jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
//     };

//     html2pdf(table, opt);
// };

// document.querySelector("#excel").addEventListener("click", () => {
//     console.log("YES");
// });

// document.getElementById("pdf").onclick = () => {
//     console.log("IN");

//     const table = document.getElementById("table");
//     const tableData = [];

//     // Iterate over each row in the table
//     table.querySelectorAll("tr").forEach(function (row) {
//         const rowData = [];
//         row.querySelectorAll("td, th").forEach(function (cell) {
//             rowData.push(cell.innerText);
//         });
//         tableData.push(rowData.join(","));
//     });

//     // Create a new window to hold the PDF content
//     const win = window.open();

//     // Construct the HTML content for the PDF
//     const htmlContent = `
//       <html>
//       <head>
//         <title>Table to PDF</title>
//       </head>
//       <body>
//         <table>
//           ${tableData.map((row) => `<tr><td>${row}</td></tr>`).join("")}
//         </table>
//       </body>
//       </html>`;

//     // Write the HTML content to the new window
//     win.document.write(htmlContent);

//     // Trigger the print function
//     win.print();

//     // Close the new window after printing
//     win.close();
// };

// document.getElementById("pdf").onclick = () => {
//     console.log("YES");

//     var table = document.getElementById("table");

//     var opt = {
//         margin: 1,
//         filename: "myfile.pdf",
//         image: { type: "jpeg", quality: 0.98 },
//         html2canvas: { scale: 2 },
//         jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
//     };

//     html2pdf(table, opt);
// };
