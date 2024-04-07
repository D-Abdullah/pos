// // let element = document.querySelector("#element");
// // let addButtom = document.querySelector(".buttons svg");
// // let elementUp = document.querySelector(".elements");

// // addButtom.addEventListener("click", () => {

// //     let newElement = element.cloneNode(true);

// //     let input = newElement.children[0].children[1];
// //     input.value = "";

// //     let inputDate = newElement.children[1].children[0].children[1];
// //     inputDate.value = new Date;

// //     elementUp.appendChild(newElement);
// // })

// let buttons = document.querySelectorAll(".special .tabs");
// let parts = document.querySelectorAll(".part");

// buttons.forEach(button => {
//     button.addEventListener("click", () => {
//         console.log("found");
//     })

//     button.addEventListener("click", () => {

//         buttons.forEach(element => {

//             element.classList.remove("active-btn");

//             button.classList.add("active-btn");

//             document.querySelector("#addNewProduct button").classList.remove(button.id)

//         })

//         parts.forEach(part => {

//             part.style.display = "none";
//             part.classList.remove("show")

//             if (button.id === part.id) {

//                 part.style.display = "flex";
//                 part.classList.add("show");

//             }

//         })

//     })

// })

// // popup

// document.querySelector("#specialConcert").addEventListener("click", () => {

//     document.querySelector("#popupAddSpecial").classList.remove("close");
//     document.querySelector("body").classList.add("overflow-hidden");
//     document.querySelector(".overlay").classList.remove("none");

// })

// let products = document.querySelectorAll(".part .up .box");
// products.forEach(product => {

//     product.addEventListener("click", () => {

//         document.querySelector("body").classList.add("overflow-hidden");

//         let NameOfProduct = product.children[0].children[0].innerHTML;

//         if (document.querySelector(".special #ourProduct").classList.contains("active-btn")) {

//             document.querySelector("#popupAddOurProduct #nameProduct").innerHTML = NameOfProduct;
//             let model = document.getElementById("popupAddOurProduct");
//             model.classList.remove("close");

//         } else if (document.querySelector(".special #rent").classList.contains("active-btn")) {

//             document.querySelector("#popupAddRent #nameProduct").innerHTML = NameOfProduct;
//             document.getElementById("popupAddRent").classList.remove("close");

//         } else if (document.querySelector(".special #specialConcert").classList.contains("active-btn")) {

//             document.getElementById("popupAddSpecial").classList.remove("close");

//         }

//         document.querySelector(".overlay").classList.remove("none");

//     })

// })

// document.querySelectorAll("#edit").forEach(icon => {

//     icon.addEventListener("click", () => {

//         document.querySelector("body").classList.add("overflow-hidden");
//         document.querySelector(".overlay").classList.remove("none");

//         let NameOfProduct = icon.parentElement.parentElement.children[0].innerHTML;

//         if (document.querySelector(".special #ourProduct").classList.contains("active-btn")) {

//             document.querySelector("#popupEditOurProduct #nameProduct").innerHTML = NameOfProduct;

//             document.getElementById("popupEditOurProduct").classList.remove("close");

//         } else if (document.querySelector(".special #rent").classList.contains("active-btn")) {

//             document.querySelector("#popupEditRent #nameProduct").innerHTML = NameOfProduct;

//             document.getElementById("popupEditRent").classList.remove("close");

//         } else if (document.querySelector(".special #specialConcert").classList.contains("active-btn")) {

//             document.getElementById("popupEditSpecial").classList.remove("close");

//         }

//     })

// })

// // remove element
// document.querySelectorAll("#trash").forEach(trash => {

//     trash.addEventListener("click", (e) => {

//         let product = trash.parentElement.parentElement;

//         document.querySelector(".popup-delete .agree").addEventListener("click", () => {

//             product.remove();

//         })

//     })

// })

// // for ourProducts popup
// let upAdd = document.querySelector("#popupAddOurProduct .form-check-2")
// let labelAdd = document.querySelector("#popupAddOurProduct .form-check-2 label");
// let inputAdd = document.querySelector("#popupAddOurProduct .form-check-2 input");

// inputAdd.addEventListener("click", () => {

//     upAdd.classList.toggle("notReady");

//     if (upAdd.classList.contains("notReady")) {

//         labelAdd.innerHTML = "قيد التحضير"

//     } else {

//         labelAdd.innerHTML = "جاهز"

//     }
// })

// let up = document.querySelector("#popupEditOurProduct .form-check-2")
// let label = document.querySelector("#popupEditOurProduct .form-check-2 label");
// let input = document.querySelector("#popupEditOurProduct .form-check-2 input");

// input.addEventListener("click", () => {

//     input.parentElement.classList.toggle("ready");

//     if (input.parentElement.classList.contains("ready")) {

//         label.innerHTML = "جاهز"

//     } else {

//         label.innerHTML = "قيد التحضير"

//     }

// })

// // for rent popup
// let upAddRent = document.querySelector("#popupAddRent .form-check-2")
// let labelAddRent = document.querySelector("#popupAddRent .form-check-2 label");
// let inputAddRent = document.querySelector("#popupAddRent .form-check-2 input");

// inputAddRent.addEventListener("click", () => {

//     upAddRent.classList.toggle("notReady");

//     if (upAddRent.classList.contains("notReady")) {

//         labelAddRent.innerHTML = "قيد التحضير"

//     } else {

//         labelAddRent.innerHTML = "جاهز"

//     }
// })

// let upEditRent = document.querySelector("#popupEditRent .form-check-2")
// let labelEditRent = document.querySelector("#popupEditRent .form-check-2 label");
// let inputEditRent = document.querySelector("#popupEditRent .form-check-2 input");

// inputEditRent.addEventListener("click", () => {

//     inputEditRent.parentElement.classList.toggle("ready");

//     if (inputEditRent.parentElement.classList.contains("ready")) {

//         labelEditRent.innerHTML = "جاهز"

//     } else {

//         labelEditRent.innerHTML = "قيد التحضير"

//     }

// })

// // for specail popup
// let upAddSpecial = document.querySelector("#popupAddSpecial .form-check-2")
// let labelAddSpecial = document.querySelector("#popupAddSpecial .form-check-2 label");
// let inputAddSpecial = document.querySelector("#popupAddSpecial .form-check-2 input");

// inputAddSpecial.addEventListener("click", () => {

//     upAddSpecial.classList.toggle("notReady");

//     if (upAddSpecial.classList.contains("notReady")) {

//         labelAddSpecial.innerHTML = "قيد التحضير"

//     } else {

//         labelAddSpecial.innerHTML = "جاهز"

//     }
// })

// let upEditSpecial = document.querySelector("#popupEditSpecial .form-check-2")
// let labelEditSpecial = document.querySelector("#popupEditSpecial .form-check-2 label");
// let inputEditSpecial = document.querySelector("#popupEditSpecial .form-check-2 input");

// inputEditSpecial.addEventListener("click", () => {

//     inputEditSpecial.parentElement.classList.toggle("ready");

//     if (inputEditSpecial.parentElement.classList.contains("ready")) {

//         labelEditSpecial.innerHTML = "جاهز"

//     } else {

//         labelEditSpecial.innerHTML = "قيد التحضير"

//     }

// })

// // ------------------------------------
