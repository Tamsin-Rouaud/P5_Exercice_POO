<?php
// Déclaration du typage strict pour s'assurer que les types de données passés aux fonctions et aux méthodes sont strictement respectés
declare(strict_types=1);

// Inclusion du fichier de configuration où sont stockées les constantes de connexion à la base de données
require_once(__DIR__ . '/config/mysql.php');

// Déclaration de la classe DBConnect pour gérer la connexion à la base de données
class DBConnect 
{
    // Déclaration d'une propriété privée $pdo qui contiendra l'objet PDO (utilisé pour la connexion à la base de données)
    private $pdo;

    // Déclaration d'une méthode publique getPDO qui retourne un objet PDO
    public function getPDO(): PDO
    {
        // Vérifie si la propriété $pdo est null (pas encore initialisée)
        if ($this->pdo === null) {
            try {
                // Création d'un nouvel objet PDO pour la connexion à la base de données
                $this->pdo = new PDO(
                    // Utilisation de sprintf pour formater la chaîne de connexion avec l'hôte et le nom de la base de données
                    sprintf('mysql:host=%s;dbname=%s;charset=utf8', MYSQL_HOST, MYSQL_BASENAME),
                    
                    // Identifiant pour la connexion à la base de données
                    MYSQL_ID,
                    
                    // Mot de passe pour la connexion à la base de données
                    MYSQL_PASSWORD,
                    
                    // Tableau d'options pour la connexion PDO
                    [
                        // Définition du mode de gestion des erreurs pour lever des exceptions en cas d'erreur
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                );
            } catch (Exception $e) {
                // Capture l'exception en cas d'erreur et arrête l'exécution du script en affichant un message d'erreur
                die('Erreur : ' . $e->getMessage());
            }
        }
        // Retourne l'objet PDO créé ou déjà existant
        return $this->pdo;
    }
}

// Bloc de test pour vérifier le fonctionnement de la classe DBConnect
try {
    // Instancie un objet de la classe DBConnect
    $db = new DBConnect();

    // Appelle la méthode getPDO pour obtenir l'objet PDO
    $pdo = $db->getPDO();

    // Exécute une requête SQL simple pour tester la connexion (vérifie simplement que la requête peut s'exécuter)
    $stmt = $pdo->query('SELECT 1');

    // Affiche un message de succès si la connexion et la requête se sont bien déroulées
    echo 'Connexion réussie et requête exécutée avec succès.';
} catch (Exception $e) {
    // Capture et affiche un message en cas d'erreur lors de la création de l'objet PDO ou de l'exécution de la requête
    echo 'Erreur : ' . $e->getMessage();
}

?>
