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
    /* change active class */
    let active = document.getElementsByClassName("active");

    if (active[0] == that)
        return;

    active[0].className = active[0].className.replace(" active", "");
    that.className += " active";
}