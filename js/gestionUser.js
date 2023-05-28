/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 28/05/2023 00:02:21 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/*! 
 *  \file gestionUser.js
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 00:02:21
 *
 *  \brief 
 *      all js function for gestionUser.php
 *
 */

/* **************************************************************************** */
/*                                                                              */

const preview = document.getElementById("preview");
const fake = document.getElementById("fake_preview");
var IS_HIDE_PREVIEW =  true;

/* **************************************************************************** */
/*                        FUNCTIONS                                             */

/*!
 *  \fn function change_preview()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 00:08:28
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function change_preview() {

    const quit = document.getElementById("quit-btn");
    console.log(quit);
    if(IS_HIDE_PREVIEW)
    {
        preview.style.display = "flex";
        fake.style.display = "flex";
        setTimeout(function(){ fake.style.width = "25%"; }, 1);
        setTimeout(function(){ preview.style.width = "20%"; }, 1);
        preview.style.height = "60vh";
        quit.onclick = change_preview;
    }
    
    else
    {
        fake.style.width = "0";
        preview.style.width = "0";
        preview.style.height = "0";
        setTimeout(function(){ preview.style.display = "none"; }, 500);
        setTimeout(function(){ fake .style.display = "none"; }, 500);
        quit.onclick = null;
    }
    
    IS_HIDE_PREVIEW = !IS_HIDE_PREVIEW;
    return (0);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function gather_data(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 02:21:29
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function gather_data(that) {    
    let data = new Map();

    data.set("id", that.id);
    let name = that.children[that.children.length - 1].children[0].textContent.split(" ");
    data.set("lastName", name[0]);
    data.set("firstName", name[1]);
    data.set("email", that.children[0].value);
    data.set("number", that.children[1].value);
    data.set("role", that.children[2].value);
    data.set("img", that.children[that.children.length - 2].children[0].src);

    if(data.get("role") == "STUDENT")
    {
        data.set("idGroup", that.children[3].value);
        data.set("lvStudy", that.children[4].value);
        data.set("school", that.children[5].value);
        data.set("city", that.children[6].value);
    }
    else if(data.get("role") == "MANAGER")
    {
        data.set("company", that.children[3].value);
        data.set("startDate", that.children[4].value);
        data.set("endDate", that.children[5].value);
        data.set("idEvent", that.children[6].value);
    }

    return (data);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function createInput(type, name, value, parent)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 02:31:50
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function createInput(type, name, placeholder ,value, isEnable , parent) {
    let input = document.createElement("input");
    input.type = type;
    input.name = name;
    input.value = value;
    input.placeholder = placeholder;
    input.id = name;

    if (!isEnable)
        input.disabled = true;
    
    parent.appendChild(input);
    return (true);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function show(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 00:03:36
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function show(that) {
    
    if (IS_HIDE_PREVIEW)
        change_preview();
    
    /* get all the data of that */
    data = gather_data(that);
    
    /* change the preview */
    const previewid = document.getElementById("preview-id");
    const previewrole = document.getElementById("preview-role");
    const top_preview = document.getElementsByClassName("preview-top")[0];
    const mid_preview = document.getElementsByClassName("preview-mid")[0];
    const custom = document.getElementsByClassName("preview-custom")[0];
    const btn_preview = document.getElementsByClassName("preview-validation-btn")[0];
    
    /* the hell of the DOM */
    previewid.value = data.get("id");
    previewrole.value = data.get("role");
    top_preview.children[0].children[0].src = data.get("img");
    top_preview.children[1].children[0].value = data.get("lastName");
    top_preview.children[1].children[1].value = data.get("firstName");
    mid_preview.children[0].children[0].value = data.get("email");
    mid_preview.children[0].children[1].value = data.get("number");

    /* delete the custom preview */
    while (custom.firstChild) 
        custom.removeChild(custom.firstChild);
    
    btn_preview.children[1].style.display = "none";
    
    /* create the custom preview */
    if(data.get("role") == "STUDENT")
    {
        createInput("text", "prev-city", "Ville", data.get("city"),true,  custom);
        createInput("text", "prev-school", "Ecole", data.get("school"),true,  custom);
        createInput("text", "prev-lvStudy", "Niveau d'étude", data.get("lvStudy"),true,  custom);
        createInput("text", "prev-idGroup", "Groupe", data.get("idGroup"),false,  custom);
    }
    else if(data.get("role") == "MANAGER")
    {
        createInput("text", "prev-company", "Entreprise", data.get("company"), true, custom);
        createInput("date", "prev-startDate", "Date de début", data.get("startDate"), true, custom);
        createInput("date", "prev-endDate", "Date de fin", data.get("endDate"), true, custom);
        createInput("text", "prev-respo", "Respo data event id :", data.get("idEvent"), true, custom);
    }
    else if(data.get("role") == "USER")
    {
        btn_preview.children[1].style.display = "block";
    }

    return (1);
}

/* ---------------------------------------------------------------------------- */


/*!
 *  \fn function dom_delete_user(id)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 17:28:29
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function dom_delete_user(id) {
    
    const user = document.getElementById(id);
    user.parentNode.removeChild(user);

    return (0);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function dom_change_user_to_manager(id)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 17:29:20
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function dom_change_user_to_manager(id) {
    
    const user = document.getElementById(id);
    const manger_list = document.getElementsByClassName('user-list')[1];
    manger_list.appendChild(user);
    return (0);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function gather_data_preview()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 17:31:19
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function gather_data_preview() {
    
    let data = new Map();

    data.set("id", document.getElementById("preview-id").value);
    data.set("img", document.getElementsByClassName("preview-top")[0].children[0].children[0].src);
    data.set("lastName", document.getElementById("prev-lastName").value);
    data.set("firstName", document.getElementById("prev-firstName").value);
    data.set("email", document.getElementById("prev-email").value);
    data.set("number", document.getElementById("prev-number").value);
    data.set("role", document.getElementById("preview-role").value);

    if(data.get("role") == "STUDENT")
    {
        data.set("city", document.getElementById("prev-city").value);
        data.set("school", document.getElementById("prev-school").value);
        data.set("lvStudy", document.getElementById("prev-lvStudy").value);
    }else if(data.get("role") == "MANAGER")
    {
        data.set("company", document.getElementById("prev-company").value);
        data.set("startDate", document.getElementById("prev-startDate").value);
        data.set("endDate", document.getElementById("prev-endDate").value);
        data.set("idEvent", document.getElementById("prev-respo").value);
    }

    return (data);
}

/* ---------------------------------------------------------------------------- */
/*!
 *  \fn function deleteUser(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 17:16:51
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
async function deleteUser() {
    console.log("deleteUser");

    let data = gather_data_preview();

    console.log(data.get("id"));

    const response = await fetch("/php/ajax_request/deleteUser.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + data.get("id")
    })
    .then(response => response.text())
    .then( function (res) {
        console.log(res);
        if (res.startsWith("Success"))
        {
            dom_delete_user(data.get("id"));
            change_preview();
        }
    });

    return (0);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function MakeManager(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 17:24:07
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
async function MakeManager() {
    
    let data = gather_data_preview();
    
    data.set("company", prompt("Quel est le nom de l'entreprise ?", "IA Pau"));

    const response = await fetch("/php/ajax_request/addManager.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + data.get("id") + "&company=" + data.get("company") + "&startDate=" + data.get("startDate") + "&endDate=" + data.get("endDate") + "&idDataC=" + data.get("idEvent")
    })
    .then(response => response.text())
    .then( function (res) {
        console.log(res);
        if (res.startsWith("Success"))
        {
            dom_change_user_to_manager(data.get("id"));
            change_preview();
        }
    });

    return (0);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function updateUser(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Sun 28 May 2023 - 17:25:39
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
async function updateUser() {

    let data = gather_data_preview();

    const response = await fetch("/php/ajax_request/updateUser.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + data.get("id") + "&lastName=" + data.get("lastName") + "&firstName=" + data.get("firstName") + "&email=" + data.get("email") + "&number=" + data.get("number") + "&city=" + data.get("city") + "&school=" + data.get("school") + "&lvStudy=" + data.get("lvStudy") + "&idGroup=" + data.get("idGroup") + "&company=" + data.get("company") + "&startDate=" + data.get("startDate") + "&endDate=" + data.get("endDate") + "&role=" + data.get("role")
    })
    .then(response => response.text())
    .then( function (res) {
        console.log(res);
        if (res.startsWith("Success"))
        {
            window.location.reload();
        }
    }
    );
    
    return (0);
}

/* ---------------------------------------------------------------------------- */
