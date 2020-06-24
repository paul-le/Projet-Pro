<?php 
    class bdd 
    { 
        private $isConnected = false; 
        private $connexion = ""; 

        public function connect() 
        { 
            $connect = mysqli_connect('localhost', 'root', '','projetpro');
            $this->connexion = $connect;
            return $this->connexion ;
        } 

        public function close() 
        { 
            mysqli_close($this->connexion); 
            $this->isConnected = false; 
        } 

        public function execute($query) 
        { 
            $requete = $query; 
            $query = mysqli_query($this->connexion, $requete); 
            $resultat = mysqli_fetch_all($query); 
            return $resultat;
        } 

        public function executeonly($query) 
        { 
            $requete = $query; 
            $query = mysqli_query($this->connexion, $requete); 
            return $query; 
        } 

        public function executeassoc($query) 
        { 
            $requete = $query; $query = mysqli_query($this->connexion, $requete); 
            $resultat = mysqli_fetch_all($query,MYSQLI_ASSOC); 
            return $resultat; 
        } 
    }
?>