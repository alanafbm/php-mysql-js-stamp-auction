class Enchere{

    constructor(el) {
        // _el contient l'élément form où se le contact et les boutons.
        this._el = el;
        // L'input nommé cat_id contient l'id du contact.
        this._id = this._el.cat_id.value;
        this._elBtnUpdate = this._el.querySelector('[data-js-update]');
        this._elBtnDelete = this._el.querySelector('[data-js-delete]');

        this.init();
    }

    /**
     * Initialise les comportements
     */
     init() {
        /**
         * Comportement suite à l'événement click du bouton 'supprimer'.
         */
        this._elBtnDelete.addEventListener('click', function() {
            this._el.action = 'index.php?route=contact/supprimer/' + this._id;
            this._el.submit();
        }.bind(this));

        /**
         * Comportement suite à l'événement click du bouton 'modifier'.
         */
        this._elBtnUpdate.addEventListener('click', function(){
            this._el.action = 'index.php?route=contact/modifier/' + this._id;
            this._el.submit();
        }.bind(this));
    }

}

export default Enchere;

