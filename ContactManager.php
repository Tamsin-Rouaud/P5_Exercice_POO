<?php
// Active le typage strict pour exiger que les types de données des arguments et des valeurs de retour respectent strictement les types déclarés
declare(strict_types=1);

// Inclusion du fichier contenant la classe DBConnect pour gérer la connexion à la base de données
require_once 'DBConnect.php';
// Inclusion du fichier contenant la classe Contact pour pouvoir l'utiliser dans ContactManager
require_once 'Contact.php';

// Déclaration de la classe ContactManager pour gérer les opérations CRUD (Create, Read, Update, Delete) sur les contacts
// ContactManager.php
class ContactManager {
    private $db;

    public function __construct() {
        $this->db = DBConnect::getInstance()->getPDO();
    }

    public function findAll(): array {
        $contacts = [];
        try {
            $statement = $this->db->query('SELECT * FROM contact');
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $contact = new Contact($row['name'], $row['email'], $row['phone_number']);
                $contact->setId($row['id']);
                $contacts[] = $contact;
            }
        } catch (PDOException $e) {
            echo 'Erreur lors de la récupération des contacts : ' . $e->getMessage();
        }
        return $contacts;
    }

    // Méthode pour récupérer un contact par son ID
    public function findById(int $id): ?Contact {
        try {
            $statement = $this->db->prepare('SELECT * FROM contact WHERE id = :id');
            $statement->execute(['id' => $id]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Si le contact est trouvé, crée et retourne l'objet Contact
            if ($row) {
                $contact = new Contact($row['name'], $row['email'], $row['phone_number']);
                $contact->setId($row['id']);
                return $contact;
            } else {
                return null;  // Aucun contact trouvé
            }
        } catch (PDOException $e) {
            echo 'Erreur lors de la recherche du contact : ' . $e->getMessage();
            return null;
        }
    }

    public function createContact(string $name, string $email, string $phone_number): void {
    try {
        // Préparer la requête d'insertion
        $statement = $this->db->prepare('INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone)');
        
        // Associer les paramètres et exécuter la requête
        $statement->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone_number,
        ]);

        echo "Le contact a été créé avec succès." . PHP_EOL;
    } catch (PDOException $e) {
        echo 'Erreur lors de la création du contact : ' . $e->getMessage() . PHP_EOL;
    }
}

public function deleteContact(int $id): void {
    try {
        // Préparer la requête de suppression
        $statement = $this->db->prepare('DELETE FROM contact WHERE id = :id');
        
        // Exécuter la requête avec l'ID du contact
        $statement->execute([':id' => $id]);

        if ($statement->rowCount() > 0) {
            echo "Le contact avec l'ID $id a été supprimé avec succès." . PHP_EOL;
        } else {
            echo "Aucun contact trouvé avec l'ID $id." . PHP_EOL;
        }
    } catch (PDOException $e) {
        echo 'Erreur lors de la suppression du contact : ' . $e->getMessage() . PHP_EOL;
    }
}

public function modifyContact(int $id, string $name, string $email, string $phone_number): void {
    try {
        // Préparer la requête de mise à jour
        $statement = $this->db->prepare(
            'UPDATE contact SET name = :name, email = :email, phone_number = :phone WHERE id = :id'
        );
        
        // Exécuter la requête avec les paramètres fournis
        $statement->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone_number,
            ':id' => $id
        ]);

        if ($statement->rowCount() > 0) {
            echo "Le contact avec l'ID $id a été mis à jour avec succès." . PHP_EOL;
        } else {
            echo "Aucun contact trouvé avec l'ID $id." . PHP_EOL;
        }
    } catch (PDOException $e) {
        echo 'Erreur lors de la mise à jour du contact : ' . $e->getMessage() . PHP_EOL;
    }
}

}





















// // Bloc de test pour vérifier le bon fonctionnement de la méthode findAll()
// try {
//     // Création d'une instance de ContactManager
//     $contactManager = new ContactManager();

//     // Appel de la méthode findAll() pour récupérer tous les contacts
//     $contacts = $contactManager->findAll();
    
//     // Affiche les objets Contact récupérés pour vérifier qu'ils ont bien été chargés
//     var_dump($contacts);
// } catch (Exception $e) {
//     // En cas d'erreur, affiche le message d'erreur
//     echo 'Erreur : ' . $e->getMessage();
// }
// 
