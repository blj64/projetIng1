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
                "Setting": document.getElementById("Setting")
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