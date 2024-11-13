<?php
    // Active le typage strict
    declare(strict_types=1);

    // Déclaration de la classe Contact pour gérer les informations d'un contact
    class Contact {
        // Propriétés / attributs privés représentant les champs de la base de données, `?` indique que chaque attribut peut être null
        private ?int $id;
        private ?string $name;
        private ?string $email;
        private ?string $phone_number;

        // Constructeur pour initialiser les attributs de Contact
        public function __construct(?string $name = null, ?string $email = null, ?string $phone_number = null) {
            $this->name = $name;
            $this->email = $email;
            $this->phone_number = $phone_number;
            // Initialise l'ID à null, qui sera affecté après l'insertion en base de donnée
            $this->id = null; 
        }

        // Assesseur pour l'ID
        public function getId(): ?int {
            return $this->id;
        }

        // Mutateur pour l'ID
        public function setId(int $id): void {
            $this->id = $id;
        }


        // Assesseur pour le nom
        public function getName(): ?string {
            return $this->name;
        }

        // Mutateur pour le nom
        public function setName(?string $name): void {
            $this->name = $name;
        }

        // Assesseur pour l'email
        public function getEmail(): ?string {
            return $this->email;
        }

        // Mutateur pour l'email
        public function setEmail(?string $email): void {
            $this->email = $email;
        }

        // Assesseur pour le numéro de téléphone
        public function getPhone(): ?string {
            return $this->phone_number;
        }

        // Mutateur pour le numéro de téléphone
        public function setPhone(?string $phone_number): void {
            $this->phone_number = $phone_number;
        }

        // Méthode magique toString pour afficher l'objet Contact sous forme de chaîne
        public function __toString(): string {
            return "{$this->id}, {$this->name}, {$this->email}, {$this->phone_number}";
        }

    }


