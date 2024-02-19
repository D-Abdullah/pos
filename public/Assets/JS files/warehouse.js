let buttons = document.querySelectorAll(".page .main-container .special button");
let sections = document.querySelectorAll(".page .main-container section");



buttons.forEach(button => {

    button.addEventListener("click", (e) => {

        buttons.forEach(element => {

            element.classList.remove("active-btn");

            button.classList.add("active-btn");

        })

        sections.forEach(section => {

            section.classList.add("none");

            if (button.dataset.count === section.id) {

                section.classList.remove("none");

            }

        })

    })

})