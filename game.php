<!DOCTYPE html>
<?php
    session_start();
    require_once './models/usuario.php';
    $user = new Usuario;
    
    $id_jogo = $_GET['id'];
    

    $user->connect("projeto_tcc", "localhost", "root", "sonnewend2006");

    if(!isset($_SESSION['id_usuario'])){
        header("location: index.php");
        exit;
    }
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo</title>
    <link rel="stylesheet" href="./css/canvas.css">
    <!-- <link rel="stylesheet" href="./css/login.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
    <script type="text/javascript" src="./js/sprite.js"></script>

</head>

<body style="background-image: url('./images/cloud.jpg');">
    <script>
        //variáveis do jogo
        var canvas, ctx, height, width, maxJump = 3, velocity = 6, stateNow, img,
        pontosNovaFase = [5, 10, 15, 20],
        faseAtual = 0,
        
        labelNovaFase = {
            texto: "",
            opacidade: 0.0,

            fadeIn: function(dt){
                var fadeInId = setInterval(function(){
                    if(labelNovaFase.opacidade < 1.0)
                        labelNovaFase.opacidade += 0.01;
                    
                    else
                        clearInterval(fadeInId);
                    
                }, 10 * dt);
            },

            fadeOut: function(dt){
                var fadeOutId = setInterval(function(){
                    if(labelNovaFase.opacidade > 0.0)
                        labelNovaFase.opacidade -= 0.01;
                    
                    else
                        clearInterval(fadeOutId);
                }, 10 * dt);
            }
        },

        estados = {
            jogar: 0,
            jogando: 1,
            perdeu: 2
        },

        chao = {
            x: 0,
            y: 550,
            heightC: 50,
            color: "#ADFF2F",

            atualizaChao: function () {
                this.x -= velocity;
                if (this.x <= -30)
                    this.x += 30;
            },

            desenhaChao: function () {
                spriteChao.desenha(this.x, this.y);
                spriteChao.desenha(this.x + spriteChao.largura, this.y);
                spriteChao.desenha(this.x + spriteChao.largura, this.y);
            }
        },

        bloco = {
            x: 50,
            y: 0,
            heightB: spriteBoneco.altura,
            widthB: spriteBoneco.largura,
            color: "#8B0000",
            gravity: 0.9,
            velocity: 0,
            strongJump: 17,
            qntJump: 0,
            score: 0,
            rotacao: 0,
            vidas: 2,
            colidindo: false,

            updateBloco: function () {
                this.velocity += this.gravity;
                this.y += this.velocity;
                this.rotacao += (Math.PI / 180) * velocity;
                if (this.y > (chao.y - this.heightB) && stateNow != estados.perdeu) {
                    this.y = chao.y - this.heightB;
                    this.qntJump = 0;
                    this.velocity = 0;
                }
            },

            jumpBloco: function () {
                if (this.qntJump < maxJump) {
                    this.velocity = -(this.strongJump);
                    this.qntJump++;
                }
            },

            resetBloco() {
                this.velocity = 0;
                this.y = 0;
                if (this.score > record) {
                    localStorage.setItem("record", this.score);
                    record = this.score;
                }

                this.vidas = 2;
                this.score = 0;
                velocity = 6;
                faseAtual = 0;
                this.gravity = 1.2;
                
            },


            desenhaBloco: function () {
                ctx.save();
                ctx.translate(this.x + (this.widthB / 2), this.y + (this.heightB / 2));
                ctx.rotate(this.rotacao);
                spriteBoneco.desenha(-this.widthB / 2, -this.heightB / 2);
                ctx.restore();
            }
        },

        obstaculos = {
            obs: [],
            
            scored: false,

            sprites:[redObstacle, blueObstacle, greenObstacle, yellowObstacle],

            insertTime: 0,

            insert: function () {
                this.obs.push({
                    x: width,
                    y: chao.y - Math.floor(20 + (Math.random() * 100)),
                    widthObs: 50,
                    heightObs: 30 + Math.floor(120 * Math.random()),
                    spriteObs: this.sprites[Math.floor(this.sprites.length * Math.random())],
                });

                this.insertTime = 50 + Math.floor(21 * Math.random());
            },

            atualizaObs: function () {
                if (this.insertTime == 0)
                    this.insert();

                else
                    this.insertTime--;

                for (let i = 0, size = this.obs.length; i < size; i++) {
                    var obst = this.obs[i];

                    obst.x -= velocity;

                    if (!bloco.colidindo &&  bloco.x < (obst.x + obst.widthObs) &&
                        (bloco.x + bloco.widthB) >= obst.x &&
                        (bloco.y + bloco.heightB) >= obst.y) {
                        
                        bloco.colidindo = true;
                        
                        setTimeout(function(){
                            bloco.colidindo = false;
                        }, 500);

                        if(bloco.vidas >= 1)
                            bloco.vidas--;
                        
                        else
                            stateNow = estados.perdeu;
                    }

                    else if (obst.x <= 0 && !obst.scored){
                        bloco.score++;
                        obst.scored = true;

                        if(faseAtual < pontosNovaFase.length && bloco.score == pontosNovaFase[faseAtual])
                            passaFase();
                    }

                    else if (obst.x <= -(obst.widthObs)) {
                        this.obs.splice(i, 1);
                        size--;
                        i--; }
                    
                }
            },

            limpaObs: function () {
                this.obs = [];
            },

            desenhaObs: function () {
                for (let i = 0, size = this.obs.length; i < size; i++) {
                    var obst = this.obs[i];

                    obst.spriteObs.desenha(obst.x, obst.y);
                }
            }
        }


    function click(event) {
        if (stateNow == estados.jogando)
            bloco.jumpBloco();

        else if (stateNow == estados.jogar) {
            stateNow = estados.jogando;
        }

        else if (stateNow == estados.perdeu) {
            stateNow = estados.jogar;
            obstaculos.limpaObs();
            bloco.resetBloco();
        }
    }

    function passaFase(){
        velocity++;
        faseAtual++;
        bloco.vidas++;

        if(faseAtual == 4)
            bloco.gravity *= 0.6;
        
        labelNovaFase.texto = "Level: "+faseAtual;
        
        labelNovaFase.fadeIn(0.4);
        
        setTimeout(function() {
            labelNovaFase.fadeOut(0.4);    
        }, 800);
        
    }

    function main() {
        height = window.innerHeight;

        width = window.innerWidth;

        if (width >= 500) {
            width = 600;
            height = 600;
        }

        canvas = document.createElement("canvas");
        canvas.width = width;
        canvas.height = height;
        canvas.style.border = "1px solid #000";

        ctx = canvas.getContext("2d");

        document.body.appendChild(canvas);

        document.addEventListener("mousedown", click);

        stateNow = estados.jogar;

        record = localStorage.getItem("record");

        if (record == null)
            record = 0;

        img = new Image();
        img.src = "./images/sheet.png";

        execute();
    }

    function update() {
        chao.atualizaChao();

        bloco.updateBloco();

        if (stateNow == estados.jogando)
            obstaculos.atualizaObs();
    }

    function draw() {
        bg.desenha(0, 0);

        ctx.fillStyle = "#fff";
        ctx.font = "50px Arial";
        ctx.fillText(bloco.score, 30, 68);
        ctx.fillText(bloco.vidas, 540, 68);
        
        ctx.fillStyle = "rgba(0, 0, 0, "+labelNovaFase.opacidade+")";
        ctx.fillText(
            labelNovaFase.texto,
            (canvas.width/2) - ctx.measureText(labelNovaFase.texto).width/2,
            canvas.height/3);

        if (stateNow == estados.jogando)
            obstaculos.desenhaObs();

        chao.desenhaChao();
        bloco.desenhaBloco();

        if (stateNow == estados.jogar)
            jogar.desenha((width / 2) - (jogar.largura / 2), (height / 2) - (jogar.altura / 2));

        if (stateNow == estados.perdeu) {
            perdeu.desenha(
                (width / 2) - (perdeu.largura / 2),
                (height / 2) - (perdeu.altura / 2) - (spriteRecord.altura / 2));
            
            spriteRecord.desenha(
                (width/2) - (spriteRecord.largura/2),
                (height/2) + (perdeu.altura/2) - (spriteRecord.altura/2) - 25);
            
            ctx.fillStyle = "#fff";
            ctx.fillText(bloco.score, 375, 390);

            if(bloco.score > record){
                    novo.desenha((width/2) - 180, (height/2) + 30);
                    ctx.fillText(bloco.score, 420, 470);
            }

            else
                ctx.fillText(record, 420, 470);
        }

    }

    function execute() {
        update();

        draw();

        window.requestAnimationFrame(execute);
    }

    //inicia o jogo
    main();
    </script>
    
    <br>
    <?php
        $result = $user->getUserByID($_SESSION['id_usuario']);
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
    ?>
    <a style="margin-right: 60em; margin-left: 10px;" href="./pages/games.php">
        <button class="btn btn-info">Sair do jogo</button>
    </a>
    <br>
    <br>
    <a style="margin-right: 60em; margin-left: 10px;" href="<?php echo "./pages/feedback.php?id={$id_jogo}&nomeUser={$row['nome']}"; ?>">
        <button class="btn btn-info">Dar feedback</button>
    </a>
</body>
<?php } ?>
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