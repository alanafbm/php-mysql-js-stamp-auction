<?php
class AccueilControleur extends Controleur
{
    public function __construct($modele, $module, $action)
    {
        parent::__construct($modele, $module, $action);
      
    }

    /**
     * Méthode invoquée par défaut si aucune action n'est indiquée.
     */
    public function index()
    {
        

    }


    public function apropos()
    {
        Utilitaire::nouvelleRoute('apropos/index');
    }

}