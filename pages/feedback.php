<!DOCTYPE html>
<?php
    require_once '../models/avaliacao.php';
    $avaliacao = new Avaliacao;

    require_once '../models/game.php';
    $game = new Jogo;

    $id_jogo = $_GET['id'];
    $nome = $_GET['nomeUser'];
    
    $game->connect("projeto_tcc", "localhost", "root", "sonnewend2006");

    $result = $game->getGameById($id_jogo);

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../css/login.css"> -->
    <title>Feedback Jogo</title>
</head>
<style>
</style>
<body style="background-image: url('../images/fruit.jpg'); background-size: 210px 150px;">
    <div class="container mt-3">
        <h2>Feedback do jogo</h2> <br>
        <hr>
        <form method="POST">
            <label for="nome_user"><b>Nome</b></label>
            <div class="form-group col-md-12">
                <input type="hidden" name="nome_usuario" class="form-control"
                value="<?php echo $nome; ?>">

                <input type="text" name="nome_usuario" class="form-control" disabled
                value="<?php echo $nome; ?>">
            </div>

            <label for="nome_jogo"><b>Nome do jogo que você acabou de jogar</b></label>
            <div class="form-group col-md-12"> 
                <input type="hidden" name="nome_jogo" class="form-control"
                value="<?php echo $row['nome']; ?>">

                <input type="text" name="nome_jogo" class="form-control" disabled
                value="<?php echo $row['nome']; ?>">
            </div>
            
            <label for="auto_avaliacao">
                    <b>Dê sua opinião sobre o jogo!</b><br>
                    <b>Quais foram os benefícios para você?</b>    
            </label>
            <div class="form-group col-md-2">
                <textarea style="width: 40em;" name="auto_avaliacao" cols="30" rows="10"></textarea>
            </div>

            <label for="pontuacao"><b>Quantos pontos você conseguiu fazer?</b></label>
            <div class="form-group col-md-12">
                <input type="number" name="pontuacao" class="form-control" placeholder="10" min="0" max="999">
            </div>

            <label for="nivel"><b>Qual o nível máximo que você conseguiu chegar?</b></label>
            <div class="form-group col-md-12">
                <input type="number" name="nivel" class="form-control" placeholder="4" min="1" max="4">
            </div>

            <div class="form-group col-md-12">
                <button class="btn btn-success" type="submit">Enviar avaliação</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="../game.php">
                    <button class="btn btn-info" type="button">Voltar</button>
                </a>
                
            </div>
        </form>
    </div>
    <?php
    }
    
    if(isset($_POST['nome_usuario'])){
        $nome_usuario = addslashes($_POST['nome_usuario']);
        $nome_jogo = addslashes($_POST['nome_jogo']);
        $auto_avaliacao = addslashes($_POST['auto_avaliacao']);
        $pontuacao = addslashes($_POST['pontuacao']);
        $nivel = addslashes($_POST['nivel']);

        if(!empty($nome_usuario) && 
            !empty($nome_jogo) &&
            !empty($auto_avaliacao) &&
            !empty($pontuacao) &&
            !empty($nivel))
        {
            $avaliacao->connect("projeto_tcc", "localhost", "root", "sonnewend2006");
            
            
            if($avaliacao->create($nome_usuario, $nome_jogo, $auto_avaliacao, $pontuacao, $nivel)){
                echo "Feedback enviado!";
                header("location: ./games.php");
            }

            else{
                echo "Erro ao enviar feedback.";
            }           
        }
        else
            echo("preencha todos os campos!");
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