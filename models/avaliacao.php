<?php
    Class Avaliacao{
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

        public function create($nome, $jogo, $avaliacao, $pontuacao, $level){
            global $pdo;

            $sql = $pdo->prepare("INSERT INTO avaliacao (nome_usuario, nome_jogo, auto_avaliacao, pontuacao, nivel) VALUES (:u, :j, :a, :p, :n)");

            $sql->bindValue(":u", $nome);
            $sql->bindValue(":j", $jogo);
            $sql->bindValue(":a", $avaliacao);
            $sql->bindValue(":p", $pontuacao);
            $sql->bindValue(":n", $level);
            $sql->execute();
            
            return true;
        }

        public function getAvaliacoes(){
            global $pdo;

            $sql = $pdo->prepare("SELECT * FROM avaliacao");
            
            $sql->execute();
            
            return $sql;
        }

        public function getAvaliacaoById($id_avaliacao){
            global $pdo;

            $sql = $pdo->prepare("SELECT * FROM avaliacao WHERE id_avaliacao = :id");
            $sql->bindValue(":id", $id_avaliacao);
            $sql->execute();
            return $sql;
        }
    }
?>