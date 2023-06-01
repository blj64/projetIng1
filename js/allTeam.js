/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 10:42:22 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/*! 
 *  \file allTeam.js
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 10:42:22
 *
 *  \brief 
 *
 *
 */


/*!
 *  \fn function send_form()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 10:42:35
 *  \brief send form to all team
 *  \return --
 *  \remarks check if all field are filled
 */
async function send_form() {
    const EMPTY_STRING = "";
    let formdata = new FormData();

    formdata.append("idDataC", document.getElementById("idDataC").value);
    formdata.append("startDate", document.getElementById("startD").value);
    formdata.append("endDate", document.getElementById("endD").value);
    formdata.append("url", document.getElementById("url").value);

    for (let data of formdata) {
        if(data[1] == EMPTY_STRING)
            {
                alert("Veuillez remplir tous les champs du formulaire avant de valider");
                return (0);
            }
    }

    const response = await fetch("../php/ajax_request/addForm.php", {
        method: "POST",
        body: formdata
    })
    .then (response => response.text())
    .then ( function (res) {
        console.log(res);
        if (res.startsWith("Success"))
        {
            alert("Le formulaire a bien été ajouté et envoyé à toutes les équipes.");
        }
        else
        {
            alert(res);
        }
    });

    return (0);
}