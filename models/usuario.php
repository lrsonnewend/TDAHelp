<?php

Class Usuario{
    
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

        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");

        $sql->bindValue(":e", $email);
        
        $sql->execute();

        if ($sql->rowCount() > 0)
            return false;

        else{
            $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)");

            $sql->bindValue(":n", $nome);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5($senha));
            $sql->execute();
        }
        return true;
    }

    public function login($email, $senha){
        global $pdo;

        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", md5($senha));
        $sql->execute();

        if ($sql->rowCount() > 0){
            $dados = $sql->fetch();
            
            session_start();

            $_SESSION['id_usuario'] = $dados['id_usuario']; 
        }

        return $dados['id_usuario'];
    }

    public function getUserByID($id){
        global $pdo;

        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        return $sql;
    }
}
?>