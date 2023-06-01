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
        for(let active of document.getElementsByClassName("active"))
            active.className.replace("active", "");
        
        url = "Main"
    }

    /* get active class */
    pages[url].style.display = "flex";

    /* change active class */
    document.getElementById("menu-" + url).className += " active";

}

/* -------------------------------------------------------------------------- */

/*!
 *  \fn function passLead(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 17:03:15
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
async function inviteGroup(that) {
    let mail = document.getElementById("email").value;
    let idGroup;
    if(mail == "")
    {
        alert("Entrez une adresse mail");
        return;
    }


    const response = await fetch('/php/ajax_request/isUserInGroup.php', {
        method: 'POST',
        headers: {
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: "login=" + mail
    })
    .then(response => response.text())
    .then( function(res)  {
        console.log(res);
        if(!res.startsWith("Success"))
        {
            alert(res.split(":")[1]);
            return;
        }
        idGroup = res.split(':')[1];
    });

    const response2 = await fetch('/php/ajax_request/inviteGroup.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "login=" + mail + "&idGroup=" + idGroup
    })
    .then(response => response.text())
    .then( function(res)  {
        console.log(res);
        if(res.startsWith("Success"))
        {
            alert("Utilisateur invité");
            document.getElementById("email").value = "";
            let data = {
                "fn" : res.split(':')[1],
                "ln" : res.split(':')[2],
                "id" : res.split(':')[3]
            };

            /* add dom option */
            let option = document.createElement('option');
            option.innerHTML = data['fn'] + ' ' + data['ln'];
            option.id=data['id'];
            document.getElementById('selectInSettings').appendChild(option);

            /*add dom user list */
            let div = document.createElement('option');
            div.className = "student";

            let p = document.createElement("p");
            p.innerHTML = data['fn'] + ' ' + data['ln'];

            div.appendChild(p);
            document.getElementById('list-group-name').appendChild(div);

        }
        else {
            alert(res);
            return;
        }
    });
}

/* ------------------------------------- */

/*!
 *  \fn function changeLeader(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 18:26:42
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
async function changeLeader() {
    console.log(document.getElementById("selectInSettings").options[document.getElementById("selectInSettings").selectedIndex]);
    let id = document.getElementById("selectInSettings").options[document.getElementById("selectInSettings").selectedIndex].id;
    let idGroup = document.getElementById('idGroup').value;

    const response = await fetch('/php/ajax_request/changeLeader.php', {
        method: 'POST',
        headers: {
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: "idLeader=" + id + "&idGroup=" + idGroup
    })
    .then(response => response.text())
    .then( function(res)  {
        console.log(res);
        if(!res.startsWith("Success"))
        {
            alert(res.split(":")[1]);
            return;
        }
        alert("Le group à un nouveau leader !");
        window.location.reload();
    });
    return (0);
}

/* ------------------------------------------------------------------------------------ */

/*!
 *  \fn function leave()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 21:34:58
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function leave() {
    
    const response = fetch('/php/ajax_request/leaveGroup.php', {
        method: 'POST',
        headers: {
            'Content-Type': "application/x-www-form-urlencoded"
        },
        body: "idUser=" + document.getElementsByClassName("me")[0].id + "&idGroup=" + document.getElementById('idGroup').value
    })
    .then(response => response.text())
    .then( function(res)  {
        console.log(res);
        if(!res.startsWith("Success"))
        {
            alert(res.split(":")[1]);
            return;
        }
        alert("Vous avez quitté le groupe !");
        window.location.href = "/pages/index.php";
    });

    return (0);
}