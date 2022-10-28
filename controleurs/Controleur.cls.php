<?php
class Controleur 
{
    protected $modele;
    protected $gabarit;
    protected $params;


    function __construct($modele, $module, $action)
    {
        if(class_exists($modele)) {
            $this->modele = new $modele();
        }
        $this->gabarit = new HtmlGabarit($module, $action);
        $this->gabarit->affecter('page', $module);
/*         $this->params = $params;
 */
        // Comme les paramètres de messages d'erreurs sont utilisés souvent, on les 
        // gère dans le constructeur de base.
        if (isset($this->params['msg'])) {
            $this->gabarit->affecter('erreur', $this->messagesUI[$this->params['msg']]);
        }
    }

    function __destruct()
    {
       $this->gabarit->genererVue(); 
    }

    public function index()
    {

    }
}