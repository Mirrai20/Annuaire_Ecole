<?php

    class Fonctionnaire extends User {

        //CONSTRUCTORS

        public function __construct()
        {
            parent::__construct();
            $this->setDescription('Fonctionnaire');
        }


    }

?>
