<?php

    class Enseignant extends User {

        //CONSTRUCTORS

        public function __construct()
        {
            parent::__construct();
            $this->setDescription('Enseignant');

        }

    }

?>
