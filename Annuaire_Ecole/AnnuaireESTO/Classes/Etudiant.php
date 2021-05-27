<?php

    class Etudiant extends User {

        //ATTRIBUTES
        protected $filiere;

        //CONSTRUCTORS

        public function __construct()
        {
            parent::__construct();
            $this->setDescription('Etudiant');
            if(isset($_POST['signup_fil'])) {
            $this->filiere=$_POST['signup_fil'];
          }else {
            $this->filiere='null';
          }
        }

        //SETTERS

        public function setFiliere($filiere) : void { $this->filiere = $filiere; }

        //GETTERS

        public function getFiliere() : string { return $this->filiere; }

    
    }

?>
