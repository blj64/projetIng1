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

/*!
 *  \fn function changeMenu(that)
 *  \author DURAND Nicolas Erich Pierre <durandnico@cy-tech.fr>
 *  \version 0.1
 *  \date Mon 22 May 2023 - 22:26:18
 *  \brief 
 *  \param 
 *  \return 
 *  \remarks 
 */
function changeMenu(that) {
    /* get # of the url */
    var hmenu = window.location.href.split("#")[1];

    if( hmenu == that.href.split("#")[1] ) {
        console.log("same menu");
        return;
    }

    /* change active class */
    var active = document.getElementsByClassName("active");
    active[0].className = active[0].className.replace(" active", "");
    that.className += " active";

    /* change content */
}