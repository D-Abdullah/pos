function dropdown(value, list) {
    let span = document.getElementById(value);
    let ul = document.getElementById(list);
    let options = ul.parentElement;
    let listItems = ul.children;

    options.classList.toggle("none");

    if (!options.classList.contains("none")) {
        for (let i = 0; i < listItems.length; i++) {
            const li = listItems[i];
            li.addEventListener("click", (l) => {
                if (l.target.parentElement.id !== "search") {
                    for (let i = 0; i < listItems.length; i++) {
                        listItems[i].classList.remove("active");
                    }
                    l.target.classList.add("active");
                    span.innerText = l.target.innerText;
                    options.classList.add("none");
                }
            });
        }
        document.addEventListener("click", (e) => {
            mainBtn = span.parentElement;
            let x = listItems[0];

            if (
                e.target !== mainBtn &&
                e.target !== span &&
                e.target !== mainBtn.children[1] &&
                e.target.parentElement.id !== "search"
            ) {
                options.classList.add("none");
            }
        });
    }
}

let buttom = document.querySelector("header .select-btn button");
let svg = document.querySelector("header .select-btn svg");

svg.addEventListener("click", () => {
    HeaderDrobdown();
});

buttom.addEventListener("click", () => {
    HeaderDrobdown();
});

function HeaderDrobdown() {
    let buttom = document.querySelector("header .select-btn button");
    let options = document.querySelector("header .select-btn .options");
    let list = document.querySelectorAll("header .select-btn .options ul li");
    let svg = document.querySelector("header .select-btn svg");

    options.classList.toggle("none");

    list.forEach((li) => {
        li.addEventListener("click", (e) => {
            buttom.innerHTML = e.target.innerText;

            options.classList.add("none");

            list.forEach((l) => {
                l.classList.remove("active");
            });

            li.classList.add("active");
        });

        document.addEventListener("click", (e) => {
            if (e.target !== buttom && e.target !== li && e.target !== svg) {
                options.classList.add("none");
            }
        });
    });
}
