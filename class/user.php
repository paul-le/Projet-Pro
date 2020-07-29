<?php

    class user extends bdd
    {

        private $id = NULL;
        private $login = NULL;
        private $password = NULL;

        public function inscription($login, $password, $confPassword, $adresse, $bdd)
        {
            if (strlen($login) != 0 && strlen($password) != 0) 
            {
                if ($password == $confPassword ) 
                {

                    $user = $bdd->execute("SELECT login FROM utilisateurs WHERE login = '$login'");
                    

                    if (empty($user)) 
                    {
                        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                        $newUser = $bdd->executeonly("INSERT INTO utilisateurs (login, password, adresse) VALUES ('$login', '$password', '$adresse')");
                       
                        return "userCheck";

                    }
                    else
                    {
                        return "userExist";
                    }
                    
                    return "mdpFaux";
                }
                return "logVide";
            }
        }

        public function connexion($login,$password, $bdd)
        {
           
            $log = $bdd->execute("SELECT * FROM utilisateurs WHERE login = '$login'");
            
            

            if(!empty($log))
            {
                if($login == $log[0][1])
                {
                    if(password_verify($password,$log[0][2]))
                    {
                        $_SESSION['id'] = $log[0][0];
                        $_SESSION['login'] = $log[0][1] ; 

                        header('Location:index.php');
                    }
                    else
                    {
                        echo "ERREUR";
                    }
                }
                else
                {
                    echo "ERREUR";
                }
            }
            else
            {
                return false;
            }
        }

        public function addPreferenceGout($idUser, $boeuf, $poulet, $dinde, $saumon, $thon, $calamar, $haricots, $pommeDeTerre, $brocolis, $avocat, $choux, $salade, $poivrons, $champignons, $lentilles, $bdd)
        {

            $gout = $bdd->executeonly("INSERT INTO goututilisateurs (id_utilisateur, boeuf, poulet, dinde, saumon, thon, calamar, haricots, pommeDeTerre, brocolis, avocat, choux, salade, poivrons, champignons, lentilles) VALUES ('$idUser', '$boeuf', '$poulet', '$dinde', '$saumon', '$thon', '$calamar', '$haricots', '$pommeDeTerre', '$brocolis', '$avocat', '$choux', '$salade', '$poivrons', '$champignons', '$lentilles')");
            echo "INSERT INTO goututilisateurs (id_utlisateur, boeuf, poulet, dinde, saumon, thon, calamar, haricots, pommeDeTerre, brocolis, avocat, choux, salade, poivrons, champignons, lentilles) VALUES ('$idUser', '$boeuf', '$poulet', '$dinde', '$saumon', '$thon', '$calamar', '$haricots', '$pommeDeTerre', '$brocolis', '$avocat', '$choux', '$salade', '$poivrons', '$champignons', '$lentilles')";
        }

        

        public function disconnect()
        {
            session_unset();
            session_destroy();
            header('location:index.php');
        }

    }
?>

