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
function createInput(type, name, value, isEnable , parent) {
    let input = document.createElement("input");
    input.type = type;
    input.name = name;
    input.value = value;

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
    const top_preview = document.getElementsByClassName("preview-top")[0];
    const mid_preview = document.getElementsByClassName("preview-mid")[0];
    const custom = document.getElementsByClassName("preview-custom")[0];
    const btn_preview = document.getElementsByClassName("preview-validation-btn")[0];
    /* the hell of the DOM */
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
        createInput("text", "city, Ville", data.get("city"),true,  custom);
        createInput("text", "school, Ecole", data.get("school"),true,  custom);
        createInput("text", "lvStudy, Niveau d'étude", data.get("lvStudy"),true,  custom);
        createInput("text", "idGroup, Groupe", data.get("idGroup"),false,  custom);
    }
    else if(data.get("role") == "MANAGER")
    {
        createInput("text", "company, Entreprise", data.get("company"), true, custom);
        createInput("date", "startDate, Date de début", data.get("startDate"), true, custom);
        createInput("date", "endDate, Date de fin", data.get("endDate"), true, custom);
    }
    else if(data.get("role") == "USER")
    {
        btn_preview.children[1].style.display = "block";
    }

    return (1);
}