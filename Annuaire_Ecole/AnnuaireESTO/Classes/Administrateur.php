<?php

    class Administrateur extends User {

        //CONSTRUCTORS

        public function __construct()
        {
            parent::__construct();
            $this->setDescription('Administrateur');
        }


        //METHODS///
        //Les nouveaux utilisateurs
        public function getNewUser() {

            $allUser = User::findAll();
            $newsUser= array();

            if($allUser == null) return $newsUser;

            foreach($allUser as $User) {
                if($User->getAcceptation()==0) {
                    array_push($newsUser, $User);
                }
            }

            return $newsUser;

        }
        // Afficher les utilisateurs
        public function getALLuser() {

            $allUser = User::findAll();
            $afficher_user= array();

            if($allUser == null) return $afficher_user;

            foreach($allUser as $User) {
                if($User->getDescription()!="Administrateur"){
                    array_push($afficher_user, $User);

                    }
            }

            return $afficher_user;

        }

    }

?>
