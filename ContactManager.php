<?php
// Active le typage strict pour exiger que les types de données des arguments et des valeurs de retour respectent strictement les types déclarés
declare(strict_types=1);

// Inclusion du fichier contenant la classe DBConnect pour gérer la connexion à la base de données
require_once 'DBConnect.php';
// Inclusion du fichier contenant la classe Contact pour pouvoir l'utiliser dans ContactManager
require_once 'Contact.php';

// Déclaration de la classe ContactManager pour gérer les opérations CRUD (Create, Read, Update, Delete) sur les contacts
class ContactManager {
    // Propriété privée $db qui contient l'instance de connexion à la base de données
    private $db;

    // Constructeur de la classe ContactManager qui initialise la connexion à la base de données
    public function __construct() {
        // Récupère l'instance de PDO à partir de la classe DBConnect
        $this->db = DBConnect::getInstance()->getPDO();
    }

    // Méthode findAll() pour récupérer tous les contacts de la base de données
    public function findAll(): array {
        // Initialisation d'un tableau pour stocker les objets Contact
        $contacts = [];

        try {
            // Exécute la requête SQL pour sélectionner tous les contacts dans la table 'contact'
            $statement = $this->db->query('SELECT * FROM contact');

            // Parcourt chaque ligne du résultat de la requête pour créer un objet Contact pour chaque contact
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                // Crée une instance de Contact avec les données récupérées
                $contact = new Contact($row['name'], $row['email'], $row['phone_number']);
                // On définit l'ID ici, car il est auto-généré dans la base de données
            $contact->setId($row['id']);
                // Ajoute l'objet Contact créé au tableau $contacts
                $contacts[] = $contact;
            }
        } catch (PDOException $e) {
            // En cas d'erreur lors de la récupération des contacts, affiche un message d'erreur
            echo 'Erreur lors de la récupération des contacts : ' . $e->getMessage();
        }

        // Affiche le contenu de $contacts pour vérifier qu'il contient bien des objets Contact
        var_dump($contacts);

        // Retourne le tableau d'objets Contact
        return $contacts;
    }
}

// Bloc de test pour vérifier le bon fonctionnement de la méthode findAll()
try {
    // Création d'une instance de ContactManager
    $contactManager = new ContactManager();

    // Appel de la méthode findAll() pour récupérer tous les contacts
    $contacts = $contactManager->findAll();
    
    // Affiche les objets Contact récupérés pour vérifier qu'ils ont bien été chargés
    var_dump($contacts);
} catch (Exception $e) {
    // En cas d'erreur, affiche le message d'erreur
    echo 'Erreur : ' . $e->getMessage();
}
?>
