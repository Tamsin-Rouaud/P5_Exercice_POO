<?php
while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";
    if($line == "list"){
        echo "Affichage de la liste.\n";
    }
}