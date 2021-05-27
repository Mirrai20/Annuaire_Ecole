<?php

    class User extends Model {

        //ATTRIBUTES

        protected $user_id;
        protected $nom;
        protected $prenom;
        protected $telephone;
        protected $email;
        protected $password;
        protected $description;
        protected $acceptation;

        /////////////////////////////////////////////////////////////////////////////////////
        //CONSTRUCTORS

        public function __construct()
        {
            $this->user_id = null;
            $this->nom = null;
            $this->prenom = null;
            $this->telephone = null;
            $this->email = null;
            $this->password = null;
            $this->description=null;
            $this->acceptation = 0;
        }

        /////////////////////////////////////////////////////////////////////////////////////
        //SETTERS

        public function setUser_id($user_id) : void { $this->user_id = $user_id; }
        public function setNom($nom) : void { $this->nom = $nom; }
        public function setPrenom($prenom) : void { $this->prenom = $prenom; }
        public function setTelephone($telephone) : void { $this->telephone = $telephone; }
        public function setEmail($email) : void { $this->email = $email; }
        public function setPassword($password) : void { $this->password = $password; }
        public function setAcceptation($acceptation) : void { $this->acceptation = $acceptation; }
        public function setDescription($description) : void { $this->description = $description; }

        /////////////////////////////////////////////////////////////////////////////////////
        //GETTERS

        public function getUser_id() : string { return $this->user_id; }
        public function getNom() : string { return $this->nom; }
        public function getPrenom() : string { return $this->prenom; }
        public function getTelephone() : string { return $this->telephone; }
        public function getEmail() : string { return $this->email; }
        public function getPassword() : string { return $this->password; }
        public function getAcceptation() : int { return $this->acceptation; }
        public function getDescription() : string { return $this->description; }

        /////////////////////////////////////////////////////////////////////////////////////
        //METHODS

        //Get User By id
        public static function findBy($value, $column = 'user_id', $table_name = 'user') {
            $data = parent::findBy($value, $column, $table_name);

              if($data != null) {

                switch($data['description']) {
                    case 'Administrateur':
                        $user = new Administrateur();
                        break;
                    case 'Enseignant':
                        $user = new Enseignant();
                        break;
                    case 'Fonctionnaire':
                        $user = new Fonctionnaire();
                        break;
                    case 'Etudiant':
                        $user = new Etudiant();
                        if($user->getFiliere()=='null'){
                          $dt = parent::findBy($data['user_id'],'CNE','Etudiant');
                          $user->setFiliere($dt['FILIERE']);
                        }
                        break;
                }

                $user->setUser_id($data['user_id']);
                $user->setNom($data['nom']);
                $user->setPrenom($data['prenom']);
                $user->setTelephone($data['telephone']);
                $user->setEmail($data['email']);
                $user->setPassword($data['password']);
                $user->setAcceptation($data['acceptation']);

                return $user;

            } else {
                return null;
            }
        }

        //Get all users
        public static function findAll($table_name = 'user') {
            $data = parent::findAll($table_name);

            if($data != null) {

                $users = array(count($data));

                for($i = 0; $i < count($data); $i++) {

                    $info = $data[$i];
                    switch($info['description']) {
                        case 'Enseignant':
                          $user = new Enseignant();
                          break;
                        case 'Fonctionnaire':
                          $user = new Fonctionnaire();
                          break;
                        case 'Administrateur':
                          $user = new Administrateur();
                          break;
                        case 'Etudiant':
                            $user = new Etudiant();
                                $dt = parent::findBy($info['user_id'],'CNE','Etudiant');
                                $user->setFiliere($dt['FILIERE']);
                          break;
                    }

                    $user->setUser_id($info['user_id']);
                    $user->setNom($info['nom']);
                    $user->setPrenom($info['prenom']);
                    $user->setTelephone($info['telephone']);
                    $user->setEmail($info['email']);
                    $user->setPassword($info['password']);
                    $user->setAcceptation($info['acceptation']);

                    $users[$i] = $user;
                }

                return $users;

            } else {
                return null;
            }
        }

        //Add new user
        public static function addUser($user) : bool {
            $query = 'insert into user (user_id,nom,prenom,telephone,email,password,acceptation,description) values (?, ?, ?, ?, ?, ?, ?, ?)';
            $params = [
                $user->getUser_id(),
                $user->getNom(),
                $user->getPrenom(),
                $user->getTelephone(),
                $user->getEmail(),
                $user->getPassword(),
                $user->getAcceptation(),
                $user->getDescription()
            ];

            $addToUser = parent::submitData($query, $params);
            if($user->getDescription() == 'Enseignant') {

                //Insert user in Enseignant table
                $addToObject = parent::submitData(
                    'insert into Enseignant (PPR) values (?)',
                    [
                        self::findBy($user->getEmail(), 'email')->getUser_id()
                    ]
                );

            } else {

                //Insert user in Fonctionnaire
                if($user->getDescription() == 'Fonctionnaire'){
                  $addToObject = parent::submitData(
                      'insert into fonctionnaire (PPR) values (?)',
                      [
                          self::findBy($user->getEmail(), 'email')->getUser_id()
                      ]
                  );
              }else{
                //Insert user in Etudiant
                $addToObject = parent::submitData(
                    'insert into etudiant (CNE,FILIERE) values (? ,?)',
                    [
                        self::findBy($user->getEmail(), 'email')->getUser_id(),
                        self::findBy($user->getEmail(), 'email')->getFiliere()

                    ]
                );

              }


            }
            return $addToUser && $addToObject;

        }
        //Update User
       public static function updateUser($user) : bool {
           $query = "update user set nom = ?, prenom = ?, email = ?, password = ?, telephone = ? where user_id = ?";
           $params = [
               $user->getNom(),
               $user->getPrenom(),
               $user->getEmail(),
               $user->getPassword(),
               $user->getTelephone(),
               $user->getUser_id()
           ];
           $UPDToUser = parent::submitData($query, $params);
           if($user->getDescription()=="Etudiant"){
             $UPDObject = parent::submitData(
                 'update etudiant set FILIERE = ? where CNE = ?',
                 [
                     $user->getFiliere(),
                     $user->getUser_id()

                 ]
             );
             return $UPDToUser && $UPDObject;
           }
          return $UPDToUser;
       }
       //Accepter demandes
       public static function AcceptUser($user) : bool {
           $query = "update user set acceptation = 1 where user_id = ?";
           $params = [
              $user->getUser_id()
           ];
           $UPDToUser = parent::submitData($query, $params);

          return $UPDToUser;
       }
       //Update description
       //Update User
      public static function updateDesc($user,$olddesc) : bool {
        //delete user from his old table
          $query = "delete from ".$olddesc." where PPR = ?";
          $params = [
              $user->getUser_id()
          ];
          $UPDToUser = parent::submitData($query, $params);
          //UPDATE user description from user table
          $query = "update user set description = ? where user_id = ?";
          $params = [
             $user->getDescription(),
              $user->getUser_id()
          ];
          $UPDToUser = parent::submitData($query, $params);
          //ADD user to his new table
          $query = "insert into ".$user->getDescription()."(PPR) values (?)";
          $params = [
              $user->getUser_id()
          ];
          $UPDToUser = parent::submitData($query, $params);
         return $UPDToUser;
      }
      //Delete User
     public static function DELUser($user) : bool {
       //delite user from his original table
       if($user->getDescription()=="Etudiant"){
         $query = "delete from ".$user->getDescription()." where CNE = ?";
         $params = [
             $user->getUser_id()
         ];
       }else{
         $query = "delete from ".$user->getDescription()." where PPR = ?";
         $params = [
             $user->getUser_id()
         ];
       }
         $UPDToUser = parent::submitData($query, $params);

         //delite user from USER table
         $query = "delete from user where user_id = ?";
         $params = [
             $user->getUser_id()
         ];
         $UPDToUser = parent::submitData($query, $params);
        return $UPDToUser;
     }

     //Annuaire Simple
     public function AnnuaireSimple($email,$tele) {

         $allUser = self::findAll();
         $afficher_user= array();

         if($allUser == null) return $afficher_user;

         foreach($allUser as $User) {
           if($User->getDescription()!='Administrateur'){
             $User->setEmail(strtoupper($User->getEmail()));
                 if(!empty($email) && !empty($tele)){
                   if($User->getEmail()==$email && $User->getTelephone()==$tele) {
                       array_push($afficher_user, $User);
                   }
                 }else{
                   if(!empty($email)){
                     if($User->getEmail()==$email) {
                         array_push($afficher_user, $User);
                     }
                   }else{
                     if($User->getTelephone()==$tele) {
                         array_push($afficher_user, $User);
                     }
                   }
                 }
              }
         }
         return $afficher_user;
     }
     //Annuaire Inversée
     public function AnnuaireInver($nom,$prenom,$description,$filiere) {

         $allUser = self::findAll();
         $afficher_user= array();

         if($allUser == null) return $afficher_user;

         if($filiere=="Filiere"){unset($filiere);}
         if(!empty($filiere)){$description="Etudiant";}
         if($description=="Enseignant" || $description=="Fonctionnaire"){unset($filiere);}
         if($description=="Description"){unset($description);}

         foreach($allUser as $User) {
           $User->setNom(strtoupper($User->getNom()));
           $User->setPrenom(strtoupper($User->getPrenom()));
           if($User->getDescription()!='Administrateur'){
                 if(!empty($nom) && !empty($prenom) && !empty($description) && !empty($filiere)){
                   if($User->getNom()==$nom && $User->getPrenom()==$prenom && $User->getDescription()==$description && $User->getFiliere()==$filiere) {
                       array_push($afficher_user, $User);
                   }
                 }else{
                   if(!empty($nom) && !empty($prenom) && !empty($description)){
                     if($User->getNom()==$nom && $User->getPrenom()==$prenom && $User->getDescription()==$description) {
                         array_push($afficher_user, $User);
                     }
                   }else{
                    if(!empty($nom) && !empty($prenom) && !empty($filiere)){
                         if($User->getNom()==$nom && $User->getPrenom()==$prenom && $User->getFiliere()==$filiere){
                            array_push($afficher_user, $User);
                         }
                     }else{
                        if(!empty($nom) && !empty($description) && !empty($filiere)){
                            if($User->getNom()==$nom && $User->getDescription()==$description && $User->getFiliere()==$filiere){
                              array_push($afficher_user, $User);
                            }
                        }else{
                          if(!empty($prenom) && !empty($description) && !empty($filiere)){
                              if($User->getPrenom()==$prenom && $User->getDescription()==$description && $User->getFiliere()==$filiere){
                                array_push($afficher_user, $User);
                              }
                            }else {
                              if(!empty($nom) && !empty($prenom)){
                                  if($User->getNom()==$nom && $User->getPrenom()==$prenom){
                                    array_push($afficher_user, $User);
                                  }
                                }else{
                                  if(!empty($nom) && !empty($description)){
                                      if($User->getNom()==$nom && $User->getDescription()==$description){
                                        array_push($afficher_user, $User);
                                      }
                                    }else {
                                      if(!empty($nom) && !empty($filiere)){
                                          if($User->getNom()==$nom && $User->getFiliere()==$filiere){
                                            array_push($afficher_user, $User);
                                          }
                                        }else{
                                          if(!empty($prenom) && !empty($description)){
                                              if($User->getPrenom()==$prenom && $User->getDescription()==$description){
                                                array_push($afficher_user, $User);
                                              }
                                            }else{
                                              if(!empty($prenom) && !empty($filiere)){
                                                  if($User->getPrenom()==$prenom && $User->getFiliere()==$filiere){
                                                    array_push($afficher_user, $User);
                                                  }
                                                }else {
                                                  if(!empty($description) && !empty($filiere)){
                                                      if($User->getDescription()==$description && $User->getFiliere()==$filiere){
                                                        array_push($afficher_user, $User);
                                                      }
                                                    }else{
                                                      if(!empty($nom)){
                                                          if($User->getNom()==$nom){
                                                            array_push($afficher_user, $User);
                                                          }
                                                        }else{
                                                          if(!empty($prenom)){
                                                              if($User->getPrenom()==$prenom){
                                                                array_push($afficher_user, $User);
                                                              }
                                                            }else{
                                                              if(!empty($description)){
                                                                  if($User->getDescription()==$description){
                                                                    array_push($afficher_user, $User);
                                                                  }
                                                                }else{
                                                                  if(!empty($filiere)){
                                                                      if($User->getFiliere()==$filiere){
                                                                        array_push($afficher_user, $User);
                                                                      }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
         return $afficher_user;
        }
}
 ?>
