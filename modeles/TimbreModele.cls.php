<?php
class TimbreModele extends AccesBd
{
    /**
     * Fait une requête à la BD et retourne tous les enregistrements de la table enchere, timbre et image.
     * @param string 
     * @return object[] 
     */
    public function tout()
    {
        $command = "SELECT * FROM enchere 
        JOIN timbre ON enchere_enc_id = enc_id
        LEFT JOIN image ON img_timbre_tim_id = tim_id";

        $result = $this->lireTout($command, true);

        // foreach($result as $encheres){
        //     foreach($encheres as $timbre){
        //         // var_dump($timbre);
        //         $id_tim = $timbre->tim_id;
        //         var_dump($id_tim);
        //         $command = "SELECT img_path FROM image WHERE timbre_tim_id = $id_tim";
        //     }
        // }

        return $result;
    }

    // public function toutTimbre()
    // {
    //     $command = "SELECT * FROM timbre";
    //     $result = $this->lireTout($command, true);
        
    //     return $result;
    // }
    
    /**
     * Fait une requête à la BD et retourne le détail d'un timbre.
     * @param string 
     * @return object 
     */
    public function un($tim_id)
    {
        $id = (int)$tim_id[0];

        $result = $this->lireUn("SELECT * FROM timbre 
        JOIN image ON img_timbre_tim_id = tim_id
        JOIN enchere ON enc_id = enchere_enc_id
        WHERE tim_id = :tim_id",['tim_id' => $id]);
       
        return $result;
        // print_r($result);
    }

        
    /**
     * Fait une requête à la BD et retourne le détail d'un conservation.
     * @param string 
     * @return object 
     */
    public function unConservation($con_etat)
    {
        
       return $this->lireUn("SELECT con_id FROM conservation WHERE con_etat=:con_etat", ['con_etat' => $con_etat]);
        // var_dump($con_id);
        
    }

    /**
     * Fait une requête à la BD et insert un nouveau timbre.
     * @param object[] 
     * @param string 
     */
    public function ajouterEnchere($enchere, $uti_id)
    {
        extract($enchere);
        // // Faire une requete pour inserer une nouvelle enchere
         $enc_id = $this->creer(
                    "INSERT INTO enchere (`enc_nom`, `enc_date_debut`, `enc_date_fin`, `enc_pieces`, `utilisateur_uti_id`) VALUES ( :enc_nom, :enc_date_debut, :enc_date_fin, :enc_pieces, :utilisateur_uti_id)"
                    , [
                        "enc_nom"      => $enc_nom, 
                        "enc_date_debut"   => $enc_date_debut,
                        "enc_date_fin"   => $enc_date_fin,
                        "enc_pieces"   => $enc_pieces,
                        "utilisateur_uti_id" => $uti_id
                    ]);
        return $enc_id;
        // print_r($enc_id);
    }
// var_dump($enc_id);

    public function ajouterTimbre($enc_id, $enchere, $con_id)
    {
        extract($enchere);
        $id_con = $con_id->con_id;

        // Faire une requete pour inserer un nouveau timbre
        return $this->creer(
            "INSERT INTO timbre (`tim_nom`, `tim_date_creation`, `tim_couleur`, `tim_pays_origine`, `tim_prix`, `tim_dimensions`, `tim_certifie`, `enchere_enc_id`, `conservation_con_id`) VALUES (:tim_nom, NOW(), :tim_couleur, :tim_pays_origine, :tim_prix, :tim_dimensions, :tim_certifie, :enchere_enc_id, :conservation_con_id)"
            , [
                "tim_nom"         => $enc_nom, 
                "tim_couleur"   => $tim_couleur,
                "tim_pays_origine" => $tim_pays_origine,
                "tim_prix"    => $tim_prix,
                "tim_dimensions"  => $tim_dimensions,
                "tim_certifie"  => $tim_certifie,
                "enchere_enc_id"   => $enc_id,
                "conservation_con_id" => $id_con
            ]);
            
    }

    public function ajouterImg($tim_id)
    {
        // extract($enchere);
        // extract($image); 
        $id_tim = (int)$tim_id;
        $name = 'stamp';
        $path = 'ressources/images/timbres/stamp';
            $this->creer(
                "INSERT INTO image (img_titre, img_path, timbre_tim_id) VALUES( :img_titre, :img_path, :img_timbre_tim_id )", [
                    "img_titre"  => $name.=$tim_id,
                    "img_path" => $path.=$tim_id,
                    "img_timbre_tim_id" => $id_tim
                ]);
            
    }

   

    /**
     * Fait une requête à la BD et modifie les informations d'un timbre.
     * @param object[] 
     * @param string 
     */
    public function changer($contact, $uti_id)
    {
       

    }

    /**
     * Fait une requête à la BD et supprime un timbre.
     * @param string 
     */
    public function retirer($enc_id)
    {
        $id = (int)$enc_id[0];
        //  Supprimer les données des encheres
        $this->supprimer("DELETE FROM enchere WHERE enc_id = :enc_id" 
        , ['enc_id' => $id]);
        $this->supprimer("DELETE FROM timbre WHERE enchere_enc_id = :enc_id" 
        , ['enc_id' => $id]);
        
        var_dump($enc_id);

      
    }

    
    /**
     * Fait une requête à la BD et retourne tous les enregistrements de la table enchere correspondant à l'expression recherchée.
     * @param string $expression Chaine représentant l'expression à rechercher.
     * @param string $uti_id Chaine représentant l'id de l'utilisateur.
     * @return object[] Un tableau d'objets représentant tous les encheres et leur timbres associés.
     *
     */
    public function rechercher($expression)
    {
        print_r($expression);
        return $this->lireTout("SELECT *  FROM enchere 
                                JOIN timbre ON enchere_enc_id = enc_id
                                LEFT JOIN image ON img_timbre_tim_id = tim_id 
                                WHERE enc_nom LIKE :enc_nom OR tim_nom LIKE :tim_nom                                ORDER BY enchere_enc_id"
                                , true, // on veut les données groupées par contact
                                [
                                "enc_nom"          => $expression,
                                "tim_nom"      => $expression 
                            ]); 
    }


    public function rechercheCertifie($post){
        $expression = $post["certifie"];
        return $this->lireTout("SELECT * FROM enchere 
                                JOIN timbre ON enchere_enc_id = enc_id
                                LEFT JOIN image ON img_timbre_tim_id = tim_id 
                                WHERE tim_certifie LIKE :oui OR tim_certifie LIKE :non 
                                ORDER BY enchere_enc_id"
                                , true, 
                                [
                                "oui"          => $expression,
                                "non"      => $expression
                            ]); 

    }

    public function rechercheCondition($post){
        
        $con_id = $post["condition"];
        // print_r($con_id);
        return $this->lireTout("SELECT * FROM enchere 
                                JOIN timbre ON enchere_enc_id = enc_id
                                LEFT JOIN image ON img_timbre_tim_id = tim_id 
                                WHERE conservation_con_id LIKE :avec_gomme OR conservation_con_id LIKE :sans_gomme OR conservation_con_id LIKE :bonne OR conservation_con_id LIKE :endommagee
                                ORDER BY enchere_enc_id"
                                , true, 
                                [
                                    "avec_gomme"          => $con_id,
                                    "sans_gomme"      => $con_id,
                                    "bonne"      => $con_id,
                                    "endommagee"      => $con_id
                                ]); 

    }
    

    public function toutCategories()
    {
        $sql = "SELECT * FROM categorie ORDER BY cat_nom";
        $result = $this->lireTout($sql, false);
        return $result;
    }

    public function toutConditions()
    {
        $sql = "SELECT * FROM condition ORDER BY con_id";
        $result = $this->lireTout($sql, false);
        return $result;
    }

    public function toutMises()
    {
        $sql = "UPDATE * FROM mise ORDER BY mis_id";
        $result = $this->modifier($sql);
        return $result;
    }

    

}

    