// handle menu open and close and localStorage
let menu = document.querySelector(".menu");
let buttonArrow = document.querySelector("header .up > button");
let buttonMenu = document.querySelector(".menu button");
let logo = document.querySelector(".menu .logo .logoImg-2");

buttonArrow.addEventListener("click", () => {

    menu.classList.toggle("close");

    buttonArrow.classList.toggle("shrink");
    
})

buttonMenu.addEventListener("click", () => {
    
    menu.classList.add("close");
    buttonArrow.classList.add("shrink");

})

// go to personalAccount
let person = document.querySelector("header .avatar img");
let list = document.querySelectorAll("header .info .manage  ul li");

person.addEventListener("click", () => {

    document.querySelector("header .info .manage").classList.toggle("none");

    document.addEventListener("click", (event) => {

        if (event.target !== person) {

            document.querySelector("header .info .manage").classList.add("none");

        }

    })

})

// handle remove and edit click
document.querySelectorAll("table tbody #trash").forEach(trash => {
    
    trash.addEventListener("click", (e) => {

        document.querySelector(".overlay").classList.remove("none");

        document.querySelector(".popup-delete").classList.remove("close");

        document.querySelector(".popup-delete .agree").addEventListener("click", () => {
            
            document.querySelector(".overlay").classList.add("none");
            
            document.querySelector(".popup-delete").classList.add("close");
            
        })
        
        document.querySelector(".popup-delete .disagree").addEventListener("click", () => {
        
            document.querySelector(".overlay").classList.add("none");
    
            document.querySelector(".popup-delete").classList.add("close");

        })
        
    })
    
})


// handle popup

let popups = document.querySelectorAll(".popup");
let popupsExit = document.querySelectorAll(".popup > img");

popupsExit.forEach(exit => {
    
    if (!exit.parentElement.classList.contains("none")) {
        
        exit.addEventListener("click", () => {

            document.querySelector(".overlay").classList.add("none");
            
            popups.forEach(popup => {
        
                if (!popup.classList.contains("close")) {
                    
                    popup.classList.add("close")
                    
                }
                
            })
            
        })

    }
    
})

document.onkeyup = function (e) {
    
    if (e.key === "Escape") {
        
        document.querySelector(".overlay").classList.add("none");
        
        popups.forEach(popup => {
            
            if (!popup.classList.contains("close")) {
                
                popup.classList.add("close")
                
            }
    
        })
        
    }    
}


