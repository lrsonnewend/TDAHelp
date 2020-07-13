//variáveis do jogo
var canvas, ctx, height, width, maxJump = 3, velocity = 6, stateNow, img,

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

        atualizaChao: function(){
            this.x -= velocity;
            if(this.x <= -30)
                this.x = 0;
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
        heightB: 50,
        widthB: 50,
        color: "#8B0000",
        gravity: 1.2,
        velocity: 0,
        strongJump: 15,
        qntJump: 0,
        score: 0,
        rotacao: 0,

        updateBloco: function () {
            this.velocity += this.gravity;
            this.y += this.velocity;
            this.rotacao += (Math.PI/180) * velocity;
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

        resetBloco(){
            this.velocity = 0;
            this.y = 0;
            if(this.score > record){
                localStorage.setItem("record", this.score);
                record = this.score;
            }
            this.score = 0;
        },


        desenhaBloco: function () {
            ctx.save();
            ctx.translate((this.x + this.widthB) / 2, (this.y + this.heightB) / 2);
            ctx.rotate(this.rotacao);
            spriteBoneco.desenha(-this.widthB / 2, -this.heightB / 2);
            ctx.restore();
        }
    },

    obstaculos = {
        obs: [],

        colors: ["#f7786b", "#92a8d1", "#82b74b", "#b9936c",
            "#c4b7a6", "#cab577", "#838060", "#feb236", "#ff7b25"
        ],

        insertTime: 0,

        insert: function () {
            this.obs.push({
                x: width,
                widthObs: 50,
                heightObs: 30 + Math.floor(120 * Math.random()),
                colorObs: this.colors[Math.floor(9 * Math.random())],
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
                
                if(bloco.x < (obst.x + obst.widthObs) && 
                (bloco.x + bloco.widthB) >= obst.x &&
                (bloco.y + bloco.heightB) >= (chao.y - obst.heightObs))
                {
                    stateNow = estados.perdeu;
                }

                else if(obst.x == 0)
                    bloco.score++;

                else if (obst.x <= -(obst.widthObs)) {
                    this.obs.splice(i, 1);
                    size--;
                    i--;
                }
            }
        },

        limpaObs: function(){
            this.obs = [];
        },

        desenhaObs: function () {
            for (let i = 0, size = this.obs.length; i < size; i++) {
                var obst = this.obs[i];

                ctx.fillStyle = obst.colorObs;

                ctx.fillRect(obst.x, (chao.y - obst.heightObs), obst.widthObs, obst.heightObs);
            }
        }
    }


function click(event) {
    if(stateNow == estados.jogando)
        bloco.jumpBloco();

    else if(stateNow == estados.jogar){
        stateNow = estados.jogando;
    }

    else if(stateNow == estados.perdeu){
        stateNow = estados.jogar;
        obstaculos.limpaObs();
        bloco.resetBloco();
    }    
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

    if(record == null)
        record = 0;
    
    img = new Image();
    img.src = "./images/sheet.png";

    execute();
}

function update() {    
    chao.atualizaChao();
    
    bloco.updateBloco();

    if(stateNow == estados.jogando)
        obstaculos.atualizaObs();    
}

function draw() {
    bg.desenha(0,0);

    ctx.fillStyle="#fff";
    ctx.font = "50px Arial";
    ctx.fillText(bloco.score, 30, 68);

    if(stateNow == estados.jogando)
        obstaculos.desenhaObs();

    chao.desenhaChao();
    bloco.desenhaBloco();
    
    if(stateNow == estados.jogar)
        jogar.desenha((width/2) - (jogar.largura/2), (height/2) - (jogar.altura/2));

    if(stateNow == estados.perdeu){
        perdeu.desenha(
            (width/2) - (perdeu.largura/2),
            (height/2) - (perdeu.altura/2) - (spriteRecord.altura/2));
    }

}

function execute() {
    update();

    draw();

    window.requestAnimationFrame(execute);
}

//inicia o jogo
// main();