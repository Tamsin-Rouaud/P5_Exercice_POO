<?php
    // Active le typage strict pour exiger que les types de données passées respectent les types déclarés
    declare(strict_types=1);

    // Inclusion des fichiers nécessaires pour pouvoir utiliser les classes ContactManager, Contact et Command.
    // Ce qui rendra disponibles toutes les fonctions et propriétés définies dans les classes de ces fichiers.
    // require_once 'ContactManager.php'; 
    // require_once 'Contact.php';
    // require_once 'Command.php';

    // COntinuer avec require_once ou spl_autoload_register?
    spl_autoload_register();

    // Création d'une nouvelle instance de la classe Command, qui contient les fonctions permettant de gérer les commandes utilisateur.
    $commandOrder = new Command();

    // Boucle infinie qui garde le programme actif jusqu'à ce que l'utilisateur entre "quit" pour quitter.
    while (true) {
        echo "Attention à la syntaxe des commandes, les espaces et virgules sont importants" . PHP_EOL;

        // Lecture de la commande de l'utilisateur depuis la console.
        $line = readline("Entrez votre commande : (help, list, detail, create, modify, delete, quit) :");

        // Vérifie si la commande est "list".
        if ($line == "list") {
            // Appelle la méthode list() dans l'objet commandOrder pour lister tous les contacts.
            $commandOrder->list();
        } 
        
        // Vérifie si la commande est "detail" suivie d'un nombre.
        elseif (preg_match('/^detail (\d+)$/', $line, $matches)) {
            // Récupère l'ID à partir du premier groupe capturé dans le tableau $matches, si la commande a passé la vérification de la RegEx et que la fonction preg_match() retourne true.
            $id = (int)$matches[1];
            // Appelle la méthode detail() avec cet ID pour afficher les détails du contact.
            $commandOrder->detail($id);
        } 
        
        // Vérifie si la commande est "create" suivie du nom, email, et numéro de téléphone, séparés par des virgules.
        elseif (preg_match('/^create ([^,]+),\s*([^,]+),\s*(.+)$/', $line, $matches)) {
            // Récupère le nom, l'email, et le numéro de téléphone depuis la commande en supprimant les espaces inutiles.
            $name = trim($matches[1]);
            $email = trim($matches[2]);
            $phone_number = trim($matches[3]);
            // Appelle la méthode create() pour ajouter un nouveau contact avec les informations fournies.
            $commandOrder->create($name, $email, $phone_number);
        } 
        
        // Vérifie si la commande est "delete" suivie d'un ID.
        elseif (preg_match('/^delete (\d+)$/', $line, $matches)) {
            // Récupère l'ID à partir du premier groupe capturé dans le tableau $matches, si la commande a passé la vérification de la RegEx et que la fonction preg_match() retourne true.
            $id = (int)$matches[1];
            // Appelle la méthode delete() pour supprimer le contact correspondant à cet ID.
            $commandOrder->delete($id);
        }
        
        // Vérifie si la commande est "help".
        elseif ($line == "help") {
            // Appelle la méthode help() pour afficher une liste d'aide des commandes disponibles.
            $commandOrder->help();
        }
        
        // Vérifie si la commande est "modify" suivie d'un ID, nom, email, et numéro de téléphone, séparés par des virgules.
        elseif (preg_match('/^modify (\d+),\s*([^,]+),\s*([^,]+),\s*(.+)$/', $line, $matches)) {
            // Récupère l'ID, le nom, l'email, et le numéro de téléphone à partir de la commande.
            $id = (int)$matches[1];
            $name = trim($matches[2]);
            $email = trim($matches[3]);
            $phone_number = trim($matches[4]);
            // Appelle la méthode modify() pour modifier le contact avec les nouvelles informations fournies.
            $commandOrder->modify($id, $name, $email, $phone_number);
        }

        // Vérifie si la commande est "quit".
        elseif ($line == "quit") {
            // Message de départ, puis sortie de la boucle pour terminer le programme.
            echo "Au revoir !" . PHP_EOL;
            break;
        }
        
        // Si la commande ne correspond à aucune des commandes attendues.
        else {
            // Définition d'un message d'erreur.
            echo "Commande non reconnue. Veuillez réessayer ou consulter l'aide via la commande help." . PHP_EOL;
        }
    }

    // readline() sert à afficher un message d'invite, lire une entrée du user dans la console (ou un terminal de cmd, très puissant mais limité au contexte CLI) et stocke cette entrée dans une variable pour un traitement ultérieur. Cette fontion est très utile pour interagir avec le user dans les scripts php executés en ligne de commande.

    // CLI => Command Line Interface (Interface en Ligne de Commande) 

    //preg_match() sert à comparer des correspondances de textes basés sur des expressions régulières (regex) et un modèle spécifique définit dans les parenthèses. Dans le cas de "detail", il teste si la chaîne $line saisi par le user est évaluée à true, correspondant ainsi à la RegEx saisi et dans ce cas, remplit le tableau $matches avec les valeurs capturées. Ex : ()'/^detail (\d+)$:'):
    //      * '/'       => (délimiteurs) délimitation de l'expression régulière on peut aussi utilisé '#' ou '~';
    //      * '^'       => indique le début de la chaîne de caractère ;
    //      * 'detail'  => représente le premier mot de la chaîne de caractère ;
    //      * '(\d+)'    => Les '()' capturent une partie spécifique du texte, '\d' pour digit soit un chiffre entre 0 et 9 et enfin '+' pour indiquer une suite d'un ou plusieurs chiffres consécutifs ;
    //      * '$' indique la fin de la chaîne de caractère ;
    // Dans le cas de Create on retrouve cet exemple '[^,]' : Correspondant à n'importe quel caractère sauf une virgule. ',\s*' correspond à une virgule suivi de possibles espaces, '(.+)' le point correspond à n'importe quelle chaîne de caractère et le '+' à un nombre illimité de caractères.
    // Si on voulait pousser plus loin la RegEx pour create, on pourrait définir preg_match() de la sorte : => preg_match(/^create ([^,]+),\s*([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}),\s*(\d+)$/);
    // Pour pousser plus loin la RegEx de Modifiy, on pourrait écrire preg_match() de tel façon => preg_match(/^modify (\d+),\s*([^,]+),\s*([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}),\s*(\d+)$/)

