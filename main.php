<?php
// Inclure les fichiers nécessaires pour pouvoir utiliser les classes ContactManager et Contact
require_once 'ContactManager.php';  // Assure-toi que le chemin est correct
require_once 'Contact.php';         // Assure-toi que le chemin est correct

while (true) {
    // Lire l'entrée de l'utilisateur
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    // Vérifier si la commande est 'list'
    if ($line == "list") {
        echo "Affichage de la liste des contacts :\n";
        
        // Instancier la classe ContactManager pour récupérer les contacts
        $contactManager = new ContactManager();
        
        // Récupérer tous les contacts avec la méthode findAll()
        $contacts = $contactManager->findAll();
        
        // Boucler sur les contacts récupérés et afficher chaque contact en utilisant la méthode toString()
        foreach ($contacts as $contact) {
            echo $contact->toString() . "\n";  // Utilisation de la méthode toString() pour afficher le contact
        }
    }
}
