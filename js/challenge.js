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
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
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
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
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
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
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