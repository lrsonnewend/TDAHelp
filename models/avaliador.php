<?php

Class Avaliador{
    
    private $pdo;
    public $msgErro = "";

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

    public function create($nome, $email, $senha){
        global $pdo;

        $sql = $pdo->prepare("SELECT id_avaliador FROM usuarios WHERE email = :e");

        $sql->bindValue(":e", $email);
        
        $sql->execute();

        if ($sql->rowCount() > 0)
            return false;

        else{
            $sql = $pdo->prepare("INSERT INTO avaliador (nome, email, senha) VALUES (:n, :e, :s)");

            $sql->bindValue(":n", $nome);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5($senha));
            $sql->execute();
        }
        return true;
    }

    public function login($email, $senha){
        global $pdo;

        $sql = $pdo->prepare("SELECT id_avaliador FROM avaliador WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", md5($senha));
        $sql->execute();

        if ($sql->rowCount() > 0){
            $dados = $sql->fetch();
            
            session_start();

            $_SESSION['id_avaliador'] = $dados['id_avaliador'];
            
            return true;
        }

        else
            return false;        
    }
}
?>