import Enchere from "./Enchere.js";

(function() {

    // Cette variable contient chacun des éléments data-js-form,
    // c'est-à-dire, toutes les contacts qui ont été chargés
    // à partir de la base de données.
    let elCard = document.querySelectorAll('[data-js-card]');

    // Un objet Contact est créé pour chacun des éléments data-js-form
    // pour faire en ce que les comportements des boutons soient initialisés.
    for (let i = 0, l = elCard.length; i < l; i++) {
        new Enchere(elCard[i]);
    }

})();
