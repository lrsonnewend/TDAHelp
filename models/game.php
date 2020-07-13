<?php
    Class Jogo{
        private $pdo;
        private $msgErro = "";

        public function connect($nome, $host, $usuario, $senha){
            global $pdo;
            global $msgErro;
            try {
                $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
                echo $pdo->connection_status;
                
            } catch (PDOException $e) {
                $msgErro = $e->getMessage();
            }   
        }

        public function getGame(){
            global $pdo;

            $sql = $pdo->prepare("SELECT * FROM jogos");
            
            $sql->execute();
            
            return $sql;
        }

        public function getGameById($id_jogo){
            global $pdo;

            $sql = $pdo->prepare("SELECT * FROM jogos WHERE id_jogo = :id");
            
            $sql->bindValue(":id", $id_jogo);
            
            $sql->execute();
            
            return $sql;
        }

    }
?>