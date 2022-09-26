<?php
session_start();

//- Pilote de l'application (ou site Web)

//- Autochargement des classes des librairies externes
include('vendor/autoload.php');

//- Inclure les fichiers de config
include('config/config.php');

$route = "";
if (isset($_GET["route"])) {
  $route = $_GET["route"];
}
$routeur = new Routeur($route);
$routeur->invoquerRoute();

//- Class routeur
class Routeur
{
  private $route = '';

  function __construct($r)
  {
    $this->route = $r;
    //- Autochargement des fichiers de classes
    spl_autoload_register(function ($nomClasse) {
      $nomFichier = "$nomClasse.cls.php";

      if (file_exists("modeles/$nomFichier")) {
        include("modeles/$nomFichier");
      } else if (file_exists("controleurs/$nomFichier")) {
        include("controleurs/$nomFichier");
      } else if (file_exists("gabarits/$nomFichier")) {
        include("gabarits/$nomFichier");
      } else if (file_exists("lib/$nomFichier")) {
        include("lib/$nomFichier");
      }
    });
  }

  //- Method invoquer routeur
  public function invoquerRoute()
  {
    $module = MODULE_DEFAULT;
    $action = "index";
    $params = "";
    $routeTableau = explode('/', $this->route);

      if (count($routeTableau) > 0 && trim($routeTableau[0]) != '') {
        $module = array_shift($routeTableau);
        if (count($routeTableau) > 0 && trim($routeTableau[0]) != '') {
          $action = array_shift($routeTableau);
          $params = $routeTableau;
        }
    }

    //- Instancier le controleur correspondant au module indiqué
    //- Et invoquer la méthode de cet objet correspondant à l'action indiquée
    $nomControleur = ucfirst($module) . 'Controleur'; // Exemple : UtilisateurControleur
    $nomModele = ucfirst($module) . 'Modele'; // Exemple : UtilisateurModele
    if (class_exists($nomControleur)) {
      if (!method_exists($nomControleur, $action)) {
        $action = 'index';
      }

      // try {
        // Pour simplifier le code, les paramètres qui viennent dans l'URL sont passés
        // comme variable d'instances du contrôleur plutôt que comme paramètre de la méthode d'action.
        $controleur = new $nomControleur($nomModele, $module, $action);
        $controleur->$action($params);
      // } catch (Throwable $e) {
      //   echo "<br/>Throwable: " . $e->getMessage();
      // } catch (Exception $e) {
      //   echo "<br/>Exception: " . $e->getMessage();
      // }
        // $controleur = new $nomControleur($nomModele, $module, $action);
        // // var_dump($params);
        // $controleur->$action($params);
     
    } else {
      $controleur = new Controleur('', MODULE_DEFAULT, 'index');
    }
  }
}
