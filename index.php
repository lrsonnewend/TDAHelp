<!DOCTYPE html>
<?php
    require_once './models/usuario.php';
    $user = new Usuario;
?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body style="background-image: url('./images/fruit.jpg'); background-size: 200px 150px;" >
    <div id="corpo">
        <h1 style="font-family: 'Bree Serif', serif;" class="text-center">T.D.A.Help</h1>
        <hr>
        <form method="post">
            <div class="form-group col-md-12">
                <input type="text" name="email" class="form-control" id="inputEmail4" placeholder="Email">
            </div>
            <div class="form-group col-md-12 mt-3">
                <input type="password" name="senha" class="form-control" id="inputPassword4" placeholder="Senha">
            </div>
            <div class="form-group col-md-12">
                <button class="btn btn-success" type="submit">Acessar</button>
            </div>
            <div><a  style="color: white; font-size: large;" href="./pages/createUser.php">Cadastre-se aqui!</a></div>
            <div><a style="color: white; font-size: large;" href="./pages/avaliador.php">Fazer login como administrador</a></div>            
        </form>
    </div>
    <?php
    
    if(isset($_POST['email'])){
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        if(!empty($email) && !empty($senha)){
            $user->connect("projeto_tcc", "localhost", "root", "sonnewend2006");
            
            if($user->msgErro == ""){
                $result = $user->login($email, $senha);
                if($result != 0){
                    header("location: ./pages/games.php?id={$result}");
                }

                else{
                    echo "Dados informados estão incorretos.";
                }
            }
            else
                echo "Erro: ".$user->msgErro;
        }
        else
            echo("Preencha todos os campos!");
    }
    ?>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
crossorigin="anonymous"></script>