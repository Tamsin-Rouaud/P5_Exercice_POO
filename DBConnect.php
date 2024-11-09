<?php
// Active le mode strict des types pour exiger que les arguments et les valeurs de retour respectent strictement les types déclarés
declare(strict_types=1);

// Inclusion du fichier de configuration où sont stockées les constantes de connexion à la base de données
require_once(__DIR__ . '/config/mysql.php');

// Déclaration de la classe DBConnect pour gérer la connexion à la base de données
class DBConnect {
    // Propriété privée $pdo qui contiendra l'objet PDO pour établir la connexion à la base de données
    private $pdo;
    
    // Propriété statique privée $instance initialisée à NULL qui contiendra l'instance unique de la classe DBConnect (Singleton)
    private static $instance = null;
    
    // Propriétés privées pour stocker les informations de connexion (constantes définies dans mysql.php)
    private $host = MYSQL_HOST;
    private $db = MYSQL_BASENAME;
    private $user = MYSQL_ID;
    private $pass = MYSQL_PASSWORD;

    // Constructeur privé pour empêcher l'instanciation directe de la classe (fait partie du pattern Singleton)
    private function __construct() {
        // Si la connexion n'est pas encore établie, initialise l'objet PDO
        if ($this->pdo === null) {
            try {
                // Création de l'objet PDO en utilisant les informations de connexion
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
                // Configuration de PDO pour lever une exception en cas d'erreur (mode ERRMODE_EXCEPTION)
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // En cas d'erreur de connexion, affiche un message d'erreur
                echo 'Erreur de connexion : ' . $e->getMessage();
            }
        }
    }

    // Méthode statique getInstance() pour récupérer l'instance unique de DBConnect
    public static function getInstance(): self
    {
        // Si l'instance n'est pas encore créée, en crée une nouvelle
        if (is_null(self::$instance)) {
            // echo "Classe instanciée" . PHP_EOL;
            self::$instance = new self();
        }
        // Retourne l'instance unique de DBConnect
        return self::$instance;
    }

    // Méthode pour récupérer l'objet PDO, permettant d'exécuter des requêtes SQL à partir d'autres parties du code
    public function getPDO() {
        return $this->pdo;
    }
}




// // Bloc de test pour vérifier le fonctionnement de la classe DBConnect
// try {
//     // Appel à la méthode statique getInstance() pour obtenir l'instance unique de DBConnect
//     $db = DBConnect::getInstance();

//     // Appel de la méthode getPDO pour récupérer l'objet PDO
//     $pdo = $db->getPDO();

//     // Exécution d'une requête SQL simple pour tester la connexion
//     $statement = $pdo->query('SELECT 1');

//     // Affiche un message de succès si la connexion et la requête se sont bien déroulées
//     echo "Connexion réussie et requête exécutée avec succès." . PHP_EOL;
// } catch (Exception $e) {
//     // Capture et affiche un message d'erreur en cas de problème de connexion ou d'exécution de la requête
//     echo 'Erreur : ' . $e->getMessage();
// }

