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

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}

/* ------------------------------ */

var nbSubject = 0;

/*!
 *  \fn function AddSubject()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 23:37:59
 *  \brief add a subject in dom
 *  \return --
 *  \remarks cannot add more than 3 subjects
 */
function AddSubject() {
    if( nbSubject > 2)
    {
        alert("Vous ne pouvez pas ajouter plus de 3 sujets");
        return;
    }   

    nbSubject++;
    let div = document.createElement("div");
    div.className = "desc subject";
    div.id = "subject" + nbSubject;
    div.innerHTML = 
    '<button onclick="suppr(this)">Supprimer</button> <input type="text" name="subject-name" placeholder="Nom du sujet"> <textarea name="subject-description" placeholder="Description du sujet"></textarea>';

    
    document.getElementById("list-subject").appendChild(div);
}

/* ------------------------------ */

/*!
 *  \fn function supprr(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 23:40:59
 *  \brief delete an element
 *  \param that     : the element to delete
 *  \return --
 *  \remarks --
 */
function suppr(that) {
    that.parentElement.remove();
    nbSubject--;
    return (0);
}

/* ------------------------------ */

/*!
 *  \fn function valider()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Mon 29 May 2023 - 00:23:25
 *  \brief create a challenge
 *  \return --
 *  \remarks --
 */
async function valider() {
    
    let data = {
        "titre": document.getElementById("main-title").value,
        "description": document.getElementById("main-desc").value,
        "startDate": document.getElementById("startDate").value,
        "endDate": document.getElementById("endDate").value,
    };

    /* add '\' before ' */
    data["titre"] = data["titre"].replace(/'/g, "\\'");
    data["description"] = data["description"].replace(/'/g, "\\'");

    let img = new FormData();
    img.append("image", document.getElementById("main-image").files[0]);

    for(let index in data){
        if(data[index] == "")
        {
            alert("Veuillez remplir tous les champs ! " + index + " est vide");
            return;
        }
    }

    let count = 1;
    data["subjects"] = {};
    for(let subject of document.getElementsByClassName("subject"))
    {
        let datas2 = {
            "name":subject.children[1].value, 
            "description": subject.children[2].value
        };

        for(let index in datas2){
            if(datas2[index] == "") 
            {
                alert("Veuillez remplir tous les champs des sujets ! ");
                return;
            }
        }
        
        /* add '\' before ' */
        datas2["name"] = datas2["name"].replace(/'/g, "\\'");
        datas2["description"] = datas2["description"].replace(/'/g, "\\'");

        data["subjects"][count - 1] = {"idS": count, "name": datas2['name'], "description": datas2["description"]};
        count++;
    }

    if (count == 1)
    {
        alert("Veuillez ajouter au moins un sujet !");
        return;
    }

    data["nbSubjects"] = count - 1;


    const upload = await fetch("/php/ajax_request/uploadImage.php", {
        method: "POST",
        body: img
    })
    .then(response => response.text())
    .then( function(res) {
        console.log(res);
        if(res.startsWith("Success"))
        {
            data["image"] = res.split(":")[1];
        }
        else
        {
            alert("Une erreur est survenue lors de l'upload de l'image !");
        }
    });
    
    const response = await fetch("/php/ajax_request/createChallenge.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "data=" + JSON.stringify(data)
    })
    .then(response => response.text())
    .then( function(res) {
        console.log(res);
        if(res.startsWith("Success"))
        {
            alert("Votre évènement a bien été créé !");
            window.location.href = "/pages/";
        }
        else
        {
            alert("Une erreur est survenue lors de la création de l'évènement !");
        }
    });

    return (0);
}

/* -------------------------------------------------------------------------- */

/*!
 *  \fn function deleteDataC(idDataC)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Wed 31 May 2023 - 15:55:49
 *  \brief delete a challenge
 *  \param idDataC     : the id of the challenge to delete
 *  \return --
 *  \remarks ask for confirmation
 */
async function deleteDataC(idDataC) {
    if( !confirm("Voulez-vous vraiment supprimer cet évènement ?"))
        return (false);

    const response = await fetch("/php/ajax_request/deleteDataC.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "idDataC=" + idDataC
    })
    .then(response => response.text())
    .then( function(res) {
        if(res.startsWith("Success"))
        {
            alert("Votre évènement a bien été supprimé !");
            document.getElementById(idDataC).remove();
        }
        else
        {
            alert("Une erreur est survenue lors de la suppression de l'évènement !\n" + res);
        }
    });

    return (true);
}

/* ------------------------------------------------------------------------------------------ */

/*!
 *  \fn function Sauvegarder()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Wed 31 May 2023 - 17:39:31
 *  \brief update the challenge
 *  \param idDataC     : the id of the challenge to update
 *  \return --
 *  \remarks ask for confirmation
 */
async function Sauvegarder(idDataC) {
    if( !confirm("Voulez-vous sauvegarder les modifications de cet évènement ?"))
        return (false);

    let data = {
        "name" : document.getElementById("main-title").textContent.replace(/'/g, "\\'"),
        "description" : document.getElementById("main-desc").textContent.replace(/'/g, "\\'"),
        "startDate" : document.getElementById("startDate").value.replace(/'/g, "\\'"),
        "endDate" : document.getElementById("endDate").value.replace(/'/g, "\\'"),
        "idDataC" : idDataC,
    };

    /* get all subjects */
    let count = 1;
    data["subjects"] = {};
    for(let subject of document.getElementsByClassName("subject"))
    {
        let datas2 = {
            "name":subject.children[0].textContent.replace(/'/g, "\\'"),
            "description": subject.children[1].textContent.replace(/'/g, "\\'")
        };

        data["subjects"][count - 1] = {"idS": count, "name": datas2['name'], "description": datas2["description"]};
        count++;
    }

    const response = await fetch("/php/ajax_request/UpdateDataC.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "data=" + JSON.stringify(data)
    })
    .then(response => response.text())
    .then( function(res) {
        if(res.startsWith("Success"))
        {
            alert("Votre évènement a bien été modifié !");
        }
        else
        {
            alert("Une erreur est survenue lors de la modification de l'évènement !\n" + res);
        }
    });

    return (true);
}


/* ------------------------------------------------------------------------------------------ */

/*!
 *  \fn function inscrire(idDataC)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Wed 31 May 2023 - 23:43:01
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
async function inscrire(idDataC) {

    let data = new Map();

    const response = await fetch("/php/ajax_request/currentUser.php")
    .then(response => response.text())
    .then( function(res) {
        console.log(res);
        if(res.startsWith("Success"))
        {
            data.set("idDataC", idDataC);
            data.set("idUser", res.split(":")[1]);
            data.set("role", res.split(":")[2]);
            
            if(data.get("role") != "USER" && data.get("role") != "STUDENT")
            {
                alert("Vous devez être un étudiant pour vous inscrire à un évènement !");
                return (false);
            }
        }
        else
        {
            alert("Vous devez être connecté pour vous inscrire à un évènement !");
            header("Location: /pages/login.php");
            return (false);
        }
    });

    console.log(data.get("idUser"));
    const response2 = await fetch("/php/ajax_request/currentUserTeam.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "idUser=" + data.get("idUser")
    })
    .then(response => response.text())
    .then( function(res) {
        console.log(res);
        if(!res.startsWith("Success"))
        {
            alert("error : " + res);
            return (false);
        }
        else if(res.split(":")[1] != "null")
        {
            alert("Vous êtes déjà inscrit à un évènement !");
            return (false);
        }
    });

    window.location.href = "/pages/teamInscription.php?idDataC=" + idDataC;
    return (true);
}