<?php
    // Active le typage strict
    declare(strict_types=1);

    spl_autoload_register();
    // // Inclusion du fichier contenant la classe DBConnect pour gérer la connexion à la base de données
    // require_once 'DBConnect.php';
    // // Inclusion du fichier contenant la classe Contact pour pouvoir l'utiliser dans ContactManager
    // require_once 'Contact.php';

    // Déclaration de la classe ContactManager pour gérer les opérations CRUD (Create, Read, Update, Delete) sur les contacts

    class ContactManager {
        // Propriété privée $db qui va contenir la connexion PDO à la base de données
        private $db;

        // Le constructeur initialise la connexion PDO via le singleton DBConnect
        public function __construct() {
            // Récupère l'instance de la connexion PDO à la base de données via le singleton pattern de DBConnect
            $this->db = DBConnect::getInstance()->getPDO();
        }

        
        // Méthode pour récupérer tous les contacts de la base de données avec une requête préparée
        public function findAll(): array {
            $contacts = []; // Tableau vide pour stocker les contacts

            try {
                // Prépare une requête SQL pour récupérer tous les contacts
                $statement = $this->db->prepare('SELECT * FROM contact');
                $statement->execute(); // Exécute la requête préparée

                // Parcourt les résultats de la requête ligne par ligne
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    // Crée un objet Contact pour chaque ligne de résultat
                    $contact = new Contact($row['name'], $row['email'], $row['phone_number']);
                    // Assigne l'ID à l'objet Contact
                    $contact->setId($row['id']); 
                    // Ajoute l'objet Contact au tableau $contacts
                    $contacts[] = $contact; 
                }
            } catch (PDOException $e) {
                // En cas d'erreur lors de la récupération des contacts, affiche un message d'erreur
                echo 'Erreur lors de la récupération des contacts : ' . $e->getMessage();
            }

            // Retourne le tableau des contacts récupérés
            return $contacts;
        }

        // Méthode pour récupérer un contact par son ID
        public function findById(int $id): ?Contact {
            try {
                // Prépare une requête SQL pour récupérer un contact en fonction de son ID
                $statement = $this->db->prepare('SELECT * FROM contact WHERE id = :id');
                // Exécute la requête en passant l'ID du contact en paramètre
                $statement->execute(['id' => $id]);

                // Récupère la première ligne de résultat
                $row = $statement->fetch(PDO::FETCH_ASSOC);

                // Si le contact est trouvé, crée un objet Contact et l'initialise avec les données récupérées
                if ($row) {
                    $contact = new Contact($row['name'], $row['email'], $row['phone_number']);
                    $contact->setId($row['id']); // Définit l'ID du contact
                    return $contact; // Retourne l'objet Contact
                } else {
                    // Si aucun contact n'est trouvé avec cet ID, retourne null
                    return null;
                }
            } catch (PDOException $e) {
                // En cas d'erreur lors de la recherche, affiche un message d'erreur
                echo 'Erreur lors de la recherche du contact : ' . $e->getMessage();
                return null; // Retourne null en cas d'erreur
            }
        }

        // Méthode pour créer un nouveau contact dans la base de données
        public function createContact(string $name, string $email, string $phone_number): void {
            try {
                // Prépare une requête SQL pour insérer un nouveau contact dans la table "contact"
                $statement = $this->db->prepare('INSERT INTO contact (name, email, phone_number) VALUES (:name, :email, :phone)');

                // Exécute la requête en passant les valeurs des paramètres
                $statement->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':phone' => $phone_number,
                ]);

                // Affiche un message de succès si le contact a été créé
                echo "Le contact a été créé avec succès." . PHP_EOL;
            } catch (PDOException $e) {
                // En cas d'erreur lors de la création du contact, affiche un message d'erreur
                echo 'Erreur lors de la création du contact : ' . $e->getMessage() . PHP_EOL;
            }
        }

        // Méthode pour supprimer un contact en fonction de son ID
        public function deleteContact(int $id): void {
            try {
                // Prépare une requête SQL pour supprimer un contact en fonction de son ID
                $statement = $this->db->prepare('DELETE FROM contact WHERE id = :id');

                // Exécute la requête en passant l'ID du contact
                $statement->execute([':id' => $id]);

                // Si une ligne a été affectée par la requête (contact supprimé), affiche un message de succès
                if ($statement->rowCount() > 0) {
                    echo "Le contact avec l'ID $id a été supprimé avec succès." . PHP_EOL;
                } else {
                    // Si aucun contact n'a été supprimé (ID incorrect par exemple), affiche un message d'erreur
                    echo "Aucun contact trouvé avec l'ID $id." . PHP_EOL;
                }
            } catch (PDOException $e) {
                // En cas d'erreur lors de la suppression du contact, affiche un message d'erreur
                echo 'Erreur lors de la suppression du contact : ' . $e->getMessage() . PHP_EOL;
            }
        }

        // Méthode pour modifier un contact en fonction de son ID
        public function modifyContact(int $id, string $name, string $email, string $phone_number): void {
            try {
                // Prépare une requête SQL pour mettre à jour les informations d'un contact
                $statement = $this->db->prepare(
                    'UPDATE contact SET name = :name, email = :email, phone_number = :phone WHERE id = :id'
                );

                // Exécute la requête en passant les nouveaux paramètres
                $statement->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':phone' => $phone_number,
                    ':id' => $id
                ]);

                // Si une ligne a été affectée par la requête (contact mis à jour), affiche un message de succès
                if ($statement->rowCount() > 0) {
                    echo "Le contact avec l'ID $id a été mis à jour avec succès." . PHP_EOL;
                } else {
                    // Si aucun contact n'a été mis à jour (ID incorrect par exemple), affiche un message d'erreur
                    echo "Aucun contact trouvé avec l'ID $id." . PHP_EOL;
                }
            } catch (PDOException $e) {
                // En cas d'erreur lors de la mise à jour du contact, affiche un message d'erreur
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
