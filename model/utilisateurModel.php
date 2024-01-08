<?php



class Utilisateur
{
        private $email;
        private $nom;
        private $pswd;
        private $role;
        public function __construct($email,$nom,$pswd,$role)
        {
                $this->email = $email;         
                $this->nom = $nom;         
                $this->pswd = $pswd;         
                $this->role = $role;         
        }
     

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Get the value of nom
         */ 
        public function getNom()
        {
                return $this->nom;
        }

        /**
         * Get the value of pswd
         */ 
        public function getPswd()
        {
                return $this->pswd;
        }

        /**
         * Get the value of role
         */ 
        public function getRole()
        {
                return $this->role;
        }
}
?>