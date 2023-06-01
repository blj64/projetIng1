/* **************************************************************************** */
/*                                                                              */
/*                                                       ::::::::  :::   :::    */
/*   IA Pau                                             :+:    :+: :+:   :+:    */
/*                                                    +:+         +:+ +:+       */
/*   By: Durandnico <durandnico@cy-tech.fr>          +#+          +#++:         */
/*                                                 +#+           +#+            */
/*   Created: 01/06/2023 01:10:17 by Durandnico   #+#    #+#    #+#             */
/*                                                ########     ###              */
/*                                                                              */
/* **************************************************************************** */

/*! 
 *  \file sign.js
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 01:10:17
 *
 *  \brief Sign in and sign up functions
 *
 *
 */

var switcher = true; 

/*!
 *  \fn function show()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 01:11:19
 *  \brief show the team name input
 *  \return --
 *  \remarks use global variable switcher
 */
function show() {
    const input = document.getElementById("teamName");

    if (switcher)
        input.style.display = "block";
    else
        input.style.display = "none";
    
    switcher = !switcher;
 
    return (0);
}

/* ---------------------------------------------------------------------------- */

/*!
 *  \fn function verif_form()
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Thu 01 June 2023 - 01:10:33
 *  \brief verify the form
 *  \return true if the form is valid, false otherwise
 *  \remarks --
 */
function verif_form() {
    return !switcher || confirm("Etes-vous sûr de ne pas vouloir créer d'équipe ? Sans équipe vous ne serez pas inscrit à la compétition. Vous pourrez toujours en créer une plus tard ou vous faire inviter dans une autre équipe.");
}