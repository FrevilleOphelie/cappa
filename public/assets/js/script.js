const menuDisplay = document.querySelector("#dropMenuMobileContenu");

const menuMobile = () => {

    const menuBtn = document.querySelector("#menuDropBtn");

    menuBtn.addEventListener("click", (event) => {
        //Afficher le menu principal si il est fermé
        if (menuDisplay.classList.contains("hide")) {
            menuDisplay.classList.remove("hide");
            menuDisplay.classList.add("show");
        }
        //Refermer le menu principal si il est ouvert
        else {
            menuDisplay.classList.remove("show");
            menuDisplay.classList.add("hide");
        }
        event.stopPropagation();
    });

    //Fermer le menu principal si clic en dehors du menu
    window.addEventListener("click", (event) => {
        if (!event.target.matches('#menuDropBtn')) {
            if (menuDisplay.classList.contains("show")) {
                menuDisplay.classList.remove("show");
                menuDisplay.classList.add("hide");
            }
        }
    });
};

menuMobile();