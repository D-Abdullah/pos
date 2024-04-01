// handle menu open and close and localStorage
let menu = document.querySelector(".menu");
let buttonArrow = document.querySelector("header .up > button");
let buttonMenu = document.querySelector(".menu button");
let logo = document.querySelector(".menu .logo .logoImg-2");

buttonArrow.addEventListener("click", () => {
    menu.classList.toggle("close");
    buttonArrow.classList.toggle("shrink");
});

buttonMenu.addEventListener("click", () => {
    menu.classList.add("close");
    buttonArrow.classList.add("shrink");
});

// go to personalAccount
let person = document.querySelector("header .avatar");
let list = document.querySelectorAll("header .info .manage  ul li");

person.addEventListener("click", () => {
    document.querySelector("header .info .manage").classList.toggle("none");

    document.addEventListener("click", (event) => {
        if (event.target !== person) {
            document
                .querySelector("header .info .manage")
                .classList.add("none");
        }
    });
});

// handle remove and edit click
document.querySelectorAll("#trash").forEach((trash) => {
    let id = trash.dataset.id;

    trash.addEventListener("click", (e) => {
        document.querySelector("body").classList.add("overflow-hidden");

        document.querySelector(".overlay").classList.remove("none");

        document.querySelector(".popup-delete").classList.remove("close");

        document
            .querySelector(".popup-delete .agree")
            .addEventListener("click", () => {
                document
                    .querySelector("body")
                    .classList.remove("overflow-hidden");

                document.querySelector(".overlay").classList.add("none");

                document.querySelector(".popup-delete").classList.add("close");
            });

        document
            .querySelector(".popup-delete .disagree")
            .addEventListener("click", () => {
                document
                    .querySelector("body")
                    .classList.remove("overflow-hidden");

                document.querySelector(".overlay").classList.add("none");

                document.querySelector(".popup-delete").classList.add("close");
            });
    });
});

document.querySelectorAll("table #edit").forEach((edit) => {
    let id = edit.dataset.id;
    edit.addEventListener("click", () => {
        document.querySelector(".overlay").classList.remove("none");

        document
            .querySelector(".popup-edit.id-" + id)
            .classList.remove("close");

        document.querySelector("body").classList.add("overflow-hidden");
    });
});

// handle popup
let popups = document.querySelectorAll(".popup");
let popupsExit = document.querySelectorAll(".popup img");

document.querySelectorAll(".features .add-button button").forEach((button) => {
    button.addEventListener("click", () => {
        document.querySelector(".overlay").classList.remove("none");

        document.querySelector(".popup-add").classList.remove("close");

        document.querySelector("body").classList.add("overflow-hidden");
    });
});

popupsExit.forEach((exit) => {
    if (!exit.parentElement.classList.contains("none")) {
        exit.addEventListener("click", (e) => {
            e.preventDefault();

            closePopups();
        });
    }
});

document.querySelector(".overlay").addEventListener("click", (e) => {
    if (e.target.classList.contains("overlay")) {
        closePopups();
    }
});

function closePopups() {
    document.querySelector(".overlay").classList.add("none");

    popups.forEach((popup) => {
        if (!popup.classList.contains("close")) {
            popup.classList.add("close");

            document.querySelector("body").classList.remove("overflow-hidden");
        }
    });
}

document.onkeyup = function (e) {
    if (e.key === "Escape") {
        document.querySelector(".overlay").classList.add("none");

        popups.forEach((popup) => {
            if (!popup.classList.contains("close")) {
                popup.classList.add("close");

                document
                    .querySelector("body")
                    .classList.remove("overflow-hidden");
            }
        });
    }
};

// Start Loader
const loader = document.querySelector("#spinner");

window.addEventListener("load", () => {
    loader.style.display = "none";
});

window.addEventListener("DOMContentLoaded", () => {
    loader.style.display = "flex";
});
