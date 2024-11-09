<?php

declare(strict_types=1);

class Command {
    private $contactManager;

    public function __construct()
    {
        $this->contactManager = new ContactManager();
    }

    public function list(): void {
        $contacts = $this->contactManager->findAll();

        if (empty($contacts)) {
            echo "Aucun contact n'est enregistré" . PHP_EOL;
            return;
        }
        echo "Liste des contacts :" . PHP_EOL;
        echo "Id, name, email, phone_number" . PHP_EOL;

        foreach ($contacts as $contact) {
            echo $contact . PHP_EOL;
        }
    }

    public function detail(int $id): void {
        $contact = $this->contactManager->findById($id);

        if ($contact) {
            echo "Détails du contact :" . PHP_EOL;
            echo $contact . PHP_EOL;
        } else {
            echo "Aucun contact trouvé avec l'ID $id." . PHP_EOL;
        }
    }

    public function create(string $name, string $email, string $phone_number): void {
    $this->contactManager->createContact($name, $email, $phone_number);
}

public function delete(int $id): void {
    $this->contactManager->deleteContact($id);
}
public function help(): void {
    echo "Commandes disponibles :" . PHP_EOL;
    echo "  help          - Affiche cette liste de commandes." . PHP_EOL;
    echo "  list          - Affiche la liste de tous les contacts." . PHP_EOL;
    echo "  detail [id]   - Affiche les détails d'un contact spécifique par ID." . PHP_EOL;
    echo "  create [name], [email], [phone_number] - Crée un nouveau contact." . PHP_EOL;
    echo "  delete [id]   - Supprime un contact par ID." . PHP_EOL;
    echo "  modify [id], [name], [email], [phone_number] - Modifie un contact par ID." . PHP_EOL;
    echo "  quit          - Quitte le programme." . PHP_EOL;
}

public function modify(int $id, string $name, string $email, string $phone_number): void {
    $this->contactManager->modifyContact($id, $name, $email, $phone_number);
}

}
