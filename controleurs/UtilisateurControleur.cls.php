<?php
class UtilisateurControleur extends Controleur
{

    public function __construct($modele, $module, $action)
    {
        parent::__construct($modele, $module, $action);
    }
    
    /**
     * Méthode invoquée par défaut.
     */
    
    public function index()
    {
        if (isset($_SESSION['utilisateur'])) {
            Utilitaire::nouvelleRoute('utilisateur/index');
            echo "Erro no utilisateur controleur index";
        }

    }

    /**
     * Méthode nouveau pour rediriger vers la page de nouvel utilisateur.
     */
    public function nouveau()
    {
        
    }

  
    /**
     * Ajoute un utilisateur.
     */
    public function ajouter()
    {
      
    }

    /**
     * Méthode connexion.
     */
    public function connexion()
    {
        $courriel = $_POST['uti_courriel'];
        $mdp = $_POST['uti_mdp'];
        $utilisateur = $this->modele->un($courriel);
        // $uti_id = $utilisateur->uti_id;
        $uti_courriel = $utilisateur->uti_courriel;
        var_dump($uti_courriel);
        $erreur = "";
        //!password_verify($mdp, $utilisateur->uti_mdp) estava dando erro!
        if ($courriel != $uti_courriel || $mdp != $utilisateur->uti_mdp) {
            $erreur = "Combinaison courriel / mot de passe erroné";
        }
        else if ($utilisateur->uti_confirmation == 0) {
            $erreur = "Compte non confirmé : vérifiez vos courriels";

        }

        if ($erreur == "") {
            // Sauvegarder état de connexion
            $_SESSION['utilisateur'] = $utilisateur;
            $this->gabarit->affecter('utilisateur_id', $utilisateur);
            Utilitaire::nouvelleRoute('accueil/index');

        } else {
            $this->gabarit->affecter('erreur', $erreur);
            $this->gabarit->affecterActionParDefaut('index');
            $this->index([]);
        }
    }

    
    /**
      * Verification d’un utilisateur particulier.
     *  Route associée : utilisateur/un
     */
    public function un($courriel)
    {
        // Chercher les utilisateurs de la BD 
        // print_r($this->modele->un($courriel));
        $this->modele->un($courriel);
    }

    /**
     * Méthode déconnexion.
     */
    public function deconnexion()
    {
        unset($_SESSION['utilisateur']);
        Utilitaire::nouvelleRoute('accueil/index');
    }

  /**
     * Affichage pour les donnes d'un utilisateur.
     *  Route associée: utilisateur/profil
     */
    public function profil()
    {
        if(isset($_SESSION["utilisateur"]))
        {
            // print_r($this->modele->un($_SESSION["utilisateur"]->uti_id));
            //  print_r($this->modele->toutEnchere());
            // print_r($this->modele->toutFavoris($_SESSION["utilisateur"]->uti_id));
            $this->gabarit->affecter('utilisateur', $this->modele->un($_SESSION["utilisateur"]->uti_courriel));
            $this->gabarit->affecter('favoris', $this->modele->toutFavoris($_SESSION["utilisateur"]->uti_id));
            $this->gabarit->affecter('encheres', $this->modele->toutEnchere());
            // $this->gabarit->affecter('images', $this->modele->toutImages());



        }
    }
    public function favoris($tim_id)
    {
        // print_r($tim_id);
        $id_tim = $tim_id[0];
        $this->modele->addFavoris($id_tim, $_SESSION["utilisateur"]->uti_id);
        $this->gabarit->affecter('favoris', $this->modele->toutFavoris($_SESSION["utilisateur"]->uti_id));
        // print_r($this->modele->toutFavoris($id_tim));
        Utilitaire::nouvelleRoute('utilisateur/profil');
    }


}