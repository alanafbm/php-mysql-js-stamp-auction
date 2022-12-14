<?php
class TimbreControleur extends Controleur
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
        $this->gabarit->affecterActionParDefaut('tout');
        $this->tout();
    }

    /**
     * Affichage de tous les encheres avec les timbres.
     *  Route associée: timbre/tout
     */
    public function tout()
    {
        // Chercher les timbres de la BD 
        $this->modele->tout();
        // Injecte le résultat dans la 'vue'
        $this->gabarit->affecter('encheres', $this->modele->tout());
        // Use for add modifier and supprimer in timbre/tout
        if($_SESSION){
            $this->gabarit->affecter('utilisateur', $_SESSION["utilisateur"]->uti_id);
        }
        // $this->gabarit->affecter('timbres', $this->modele->toutTimbre());
       

    }

    /**
      * Affichage du détail d’un timbre particulier est cliqué.
     *  Route associée : timbre/un
     */
    public function un($tim_id)
    {
        // Chercher les timbres de la BD  et Injecte le résultat dans la 'vue'
        $this->gabarit->affecter('timbre', $this->modele->un($tim_id));
        $mise_max = $this->modele->toutMises($tim_id[0]);
        $this->gabarit->affecter('mise', $mise_max);

        
    }

    
    /**
     * Ajout d'une enchere / timbre.
     *  Route associée: timbre/ajouter
     */
    public function ajouter() 
    {

        $con_id = $this->modele->unConservation($_POST['con_etat']);

        // $file = addslashes(file_get_contents($_FILES["img_path"]["tmp_name"]));
        $enc_id = $this->modele->ajouterEnchere($_POST, $_SESSION["utilisateur"]->uti_id);
        $tim_id = $this->modele->ajouterTimbre($enc_id, $_POST, $con_id);
        $this->modele->ajouterImg($tim_id, $_FILES["fileToUpload"]);

        Utilitaire::nouvelleRoute('timbre/tout');
    }

    /**
     * Modification d'un timbre.
     *  Route associée: timbre/changer
     */
    public function modifier($enc_id) 
    {
        // Utilitaire::nouvelleRoute('timbre/tout');
    }
    
    public function modification($enc_id)
    {
        $con_id = $this->modele->unConservation($_POST['con_etat']);
        print_r($con_id);
        $this->modele->changerEnchere($_POST, $_SESSION["utilisateur"]->uti_id, $enc_id);
        $tim_id = $this->modele->changerTimbre($_POST, $enc_id, $con_id);
        $this->modele->changerImg($_FILES["fileToUpload"], $tim_id);

        Utilitaire::nouvelleRoute('timbre/tout');


    }

    /**
     * Suppression d'un timbre/enchere/image.
     *  Route associée: timbre/retirer
     */
    public function retirer($enc_id) 
    {
        $this->modele->retirer($enc_id);
        Utilitaire::nouvelleRoute('timbre/tout');
    }

    /**
     * Recherche d'un enchere.
     *  Route associée: timbre/rechercher
     */
    public function rechercher() 
    {
        if($_POST){
            // Certifie
            if($_POST["certifie"] && $_POST["certifie"]  != "0") {
                $this->gabarit->affecter('encheres', $this->modele->rechercheCertifie($_POST));
            }
            // Condition   
            if ($_POST["condition"] && $_POST["condition"] != "0"){
                
                $this->gabarit->affecter('encheres', $this->modele->rechercheCondition($_POST));
            }
            // Recherche
            if ($_POST["recherche"]){
                $recherche = "%" . $_POST['recherche'] . "%";
                $this->gabarit->affecter('encheres', $this->modele->rechercher($recherche));
            }
        }
        else{
            Utilitaire::nouvelleRoute('timbre/tout');
        }
    }


    public function miser()
    {
        $valeurMise = $_POST["inputMise"];
        $tim_id = $_POST["tim_id"];
     
        $mise_id = $this->modele->insertMise($valeurMise, $tim_id, $_SESSION["utilisateur"]->uti_id);
        if($mise_id != 0){
            $mise_max = $this->modele->toutMises($tim_id);
            $this->gabarit->affecter('timbre', $this->modele->un($tim_id));
            $this->gabarit->affecter('mise', $mise_max);
        
            Utilitaire::nouvelleRoute('timbre/un/' . $tim_id);
        }

    }
    

}