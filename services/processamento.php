<?php
    $user = new Usuario();

    if(isset($_POST['nome'])){
        $nome = addslashes($_POST['nome']);
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        if(!empty($nome) && !empty($email) && !empty($senha)){
            $user->connect("projeto_tcc", "localhost", "root", "sonnewend2006");
            if($user->msgErro == ""){
                if($user->create($nome, $email, $senha)){
                    echo "Cadastro realizado!";
                }
            }
            else
                echo "cadastro já existe.";
        }
        else
            echo("preencha todos os campos!");
    }
?>