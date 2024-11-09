<?php
// Inclure les fichiers nécessaires pour pouvoir utiliser les classes ContactManager et Contact
require_once 'ContactManager.php'; 
require_once 'Contact.php';
require_once 'Command.php';

$commandOrder = new Command();

while (true) {
    echo "Attention à la syntaxe des commandes, les espaces et virgules sont importants" . PHP_EOL;
    $line = readline("Entrez votre commande : (help, list, detail, create, delete, quit) :");

    if ($line == "list") {
        $commandOrder->list();
    } 
    elseif (preg_match('/^detail (\d+)$/', $line, $matches)) {
        $id = (int)$matches[1];
        $commandOrder->detail($id);
    } 
    elseif (preg_match('/^create ([^,]+),\s*([^,]+),\s*(.+)$/', $line, $matches)) {
        $name = trim($matches[1]);
        $email = trim($matches[2]);
        $phone_number = trim($matches[3]);
        $commandOrder->create($name, $email, $phone_number);
    } 
    elseif (preg_match('/^delete (\d+)$/', $line, $matches)) {
        $id = (int)$matches[1];
        $commandOrder->delete($id);
    }
    elseif ($line == "help") {
    $commandOrder->help();
}
elseif (preg_match('/^modify (\d+),\s*([^,]+),\s*([^,]+),\s*(.+)$/', $line, $matches)) {
    $id = (int)$matches[1];
    $name = trim($matches[2]);
    $email = trim($matches[3]);
    $phone_number = trim($matches[4]);
    $commandOrder->modify($id, $name, $email, $phone_number);
}

    elseif ($line == "quit") {
        echo "Au revoir !" . PHP_EOL;
        break;
    }
    else {
        echo "Commande non reconnue. Veuillez réessayer." . PHP_EOL;
    }
    
}










// // Instancier la classe ContactManager pour récupérer les contacts
        // $contactManager = new ContactManager();
        
        // // Récupérer tous les contacts avec la méthode findAll()
        // $contacts = $contactManager->findAll();
        
        // // Boucler sur les contacts récupérés et afficher chaque contact en utilisant la méthode toString()
        // foreach ($contacts as $contact) {
        //     echo $contact->toString();  // Utilisation de la méthode toString() pour afficher le contact
        // }