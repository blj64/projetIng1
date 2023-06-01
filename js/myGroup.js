/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 22/05/2023 22:25:37 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/*! 
 *  \file myGroup.js
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Mon 22 May 2023 - 22:25:37
 *
 *  \brief 
 *      -JS function for myGroup.php
 *
 */

/** 
 *  @fn function changeMenu(that)
 *  @author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  @version 0.1
 *  @date Mon 22 May 2023 - 22:26:18
 *  @brief change active class on menu 
 *  @param that     : element clicked
 *  @return --
 *  @remarks --
 */
function changeMenu(that) {
    const pages = {
        "Main": document.getElementById("Main"),
        "Messagerie": document.getElementById("Messagerie"),
        "Setting": document.getElementById("Setting"),
        "Rendu": document.getElementById("Rendu")
    };

    /* get active class */
    let active = document.getElementsByClassName("active");

    /* hide active page and show new one */
    pages[active[0].href.split("#")[1]].style.display = "none";
    pages[that.href.split("#")[1]].style.display = "flex";

    /* change active class */
    active[0].className = active[0].className.replace(" active", "");
    that.className += " active";
}


/* -------------------------------------------------------------------------- */

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name; 
    thumbnailElement.style.backgroundImage = null;

    const box_success   = document.getElementsByClassName("box__success")[0];
    const box_error     = document.getElementsByClassName("box__error")[0];
    const send_button   = document.getElementById("send_button");
    if(file.name.endsWith(".py"))
    {
        box_error.style.display = "none";
        box_success.style.display = "block";
        send_button.disabled = false;
    } else {
        box_error.style.display = "block"
        box_success.style.display = "none";
        box_error.children[0].innerHTML = "Must upload a .py file";
        send_button.disabled = true;
    }
}


/* -------------------------------------------------------------------------- */

document.getElementsByTagName('body')[0].onload = function() {
    const pages = {
        "Main": document.getElementById("Main"),
        "Messagerie": document.getElementById("Messagerie"),
        "Setting": document.getElementById("Setting"),
        "Rendu": document.getElementById("Rendu")
    };
    
    /*get the # in url */
    let full_url = window.location.href.split("#");
    let url = full_url[1];

    if(url == undefined || url == "Setting" || pages[url] == undefined)
    {
        window.location.href = full_url[0] + "#Main";
        window.location.reload();
        return;
    }

    /* get active class */
    pages[url].style.display = "flex";

    /* change active class */
    document.getElementById("menu-" + url).className += " active";

}