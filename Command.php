<?php
// Active le typage strict pour exiger que les types de données passées respectent les types déclarés
declare(strict_types=1);

// Déclaration de la classe Command, qui gère les différentes commandes de l'utilisateur
class Command {
    // Propriété privée qui va contenir l'instance de ContactManager pour interagir avec les contacts
    private $contactManager;

    // Constructeur de la classe Command, qui crée une instance de ContactManager
    public function __construct()
    {
        // Initialisation de l'objet ContactManager
        $this->contactManager = new ContactManager();
    }

    // Méthode pour lister tous les contacts
    public function list(): void {
        // Récupère tous les contacts via ContactManager
        $contacts = $this->contactManager->findAll();

        // Si aucun contact n'est trouvé, on affiche un message
        if (empty($contacts)) {
            echo "Aucun contact n'est enregistré" . PHP_EOL;
            return;
        }

        // Sinon, on affiche la liste des contacts
        echo "Liste des contacts :" . PHP_EOL;
        echo "Id, name, email, phone_number" . PHP_EOL;

        // On parcourt chaque contact et on l'affiche
        foreach ($contacts as $contact) {
            echo $contact . PHP_EOL;
        }
    }

    // Méthode pour afficher les détails d'un contact spécifique par son ID
    public function detail(int $id): void {
        // Récupère le contact via l'ID
        $contact = $this->contactManager->findById($id);

        // Si le contact est trouvé, on affiche ses détails
        if ($contact) {
            echo "Détails du contact :" . PHP_EOL;
            echo $contact . PHP_EOL;
        } else {
            // Si aucun contact n'est trouvé avec cet ID, on affiche un message d'erreur
            echo "Aucun contact trouvé avec l'ID $id." . PHP_EOL;
        }
    }

    // Méthode pour créer un nouveau contact
    public function create(string $name, string $email, string $phone_number): void {
        // Appelle la méthode du ContactManager pour créer un contact
        $this->contactManager->createContact($name, $email, $phone_number);
    }

    // Méthode pour supprimer un contact par son ID
    public function delete(int $id): void {
        // Appelle la méthode du ContactManager pour supprimer un contact
        $this->contactManager->deleteContact($id);
    }
    
    // Méthode pour afficher l'aide sur les commandes disponibles
    public function help(): void {
        echo "Commandes disponibles :" . PHP_EOL;
        echo "help : affiche cette aide" . PHP_EOL;
        echo "list : liste les contacts" . PHP_EOL;
        echo "detail id : Affiche les détails d'un contact spécifique par son ID." . PHP_EOL;
        echo "create name, email, phone number : crée un contact" . PHP_EOL;
        echo "delete id : supprime un contact" . PHP_EOL;
        echo "modify id, name, email, phone_number : Modifie un contact par son ID." . PHP_EOL;
        echo "quit : quitte le programme" . PHP_EOL;
    }

    // Méthode pour modifier un contact existant
    public function modify(int $id, string $name, string $email, string $phone_number): void {
        // Appelle la méthode du ContactManager pour modifier un contact
        $this->contactManager->modifyContact($id, $name, $email, $phone_number);
    }

}
