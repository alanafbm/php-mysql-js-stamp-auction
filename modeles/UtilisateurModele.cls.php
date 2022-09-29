<?php
class UtilisateurModele extends AccesBd
{
    /**
     * Obtenir le détail d'un utilisateur
     * @param string $courriel Adresse courriel de l'utilisateur
     */
    public function un($courriel)
    {
        return $this->lireUn(
            "SELECT * FROM utilisateur WHERE uti_courriel=:courriel",
            ['courriel' => $courriel]
        );
    }

     /**
     * Fait une requête à la BD et retourne tous les enregistrements de la table enchere.
     * @param string 
     * @return object[] 
     */
    public function toutEnchere()
    {
        $command = "SELECT * FROM enchere 
        JOIN timbre ON enchere_enc_id = enc_id 
        LEFT JOIN image ON img_timbre_tim_id = tim_id
        ORDER BY enc_id";

        $result = $this->lireTout($command, true);


        return $result;

       /*  "SELECT * FROM enchere 
                    JOIN timbre ON enchere_enc_id = enc_id 
                    JOIN images ON timbre_tim_id = tim_id 
                    ORDER BY enc_id"; */
    }

    public function toutImages()
    {
        $command = "SELECT * FROM image 
        JOIN enchere ON enc_id = enchere_enc_id";

        $result = $this->lireTout($command, true);


        return $result;

       /*  "SELECT * FROM enchere 
                    JOIN timbre ON enchere_enc_id = enc_id 
                    JOIN images ON timbre_tim_id = tim_id 
                    ORDER BY enc_id"; */
    }
  

    /**
     * Ajouter un utilisateur
     * @param array $utilisateur Tableau contenant le détail d'un utilisateur.
     */
    public function ajouter()
    {
        $cc = uniqid('stampee', true);

        $params = array(
            ':nom' => $_POST['uti_nom'],
            ':prenom' => $_POST['uti_prenom'],
            ':courriel' => $_POST['uti_courriel'],
            ':pays_residence' => $_POST['uti_pays_residence'],
            ':mdp' => password_hash($_POST['uti_mdp'], PASSWORD_DEFAULT)
        );

        $res = $this->creer(
            "INSERT INTO utilisateur (uti_courriel, uti_mdp, uti_nom, uti_prenom, uti_privilege, uti_pays_residence, uti_date_register, uti_confirmation)
            VALUES (:courriel, :mdp, :nom, :prenom, 2, :pays_residence,  NOW(), '')",
            $params
        );

        if (is_numeric($res)) {
            return ['courriel' => $_POST['uti_courriel'], 'cc' => $cc];
        }

        return $res;
    }
    public function addFavoris($tim_id, $uti_id)
    {
        $result = $this->creer( "INSERT INTO favoris (fav_utilisateur_uti_id, fav_timbre_tim_id) VALUES(:uti_id, :tim_id )",
            [
                "uti_id" => $uti_id,
                "tim_id" => $tim_id
            ]); 
            return $result;
    }

    public function toutFavoris($uti_id)
    {
        $command = $this->lireUn("SELECT * FROM favoris
        WHERE fav_utilisateur_uti_id = :id_uti", ["id_uti" => $uti_id]);
        // print_r($command);
        return $command;
    }

}
