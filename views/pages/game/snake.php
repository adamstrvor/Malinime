<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake game</title>


    <style>
        body
        {
            background-color: black /* rgb(57, 89, 119)*/;
            margin: 0;padding: 0;
            color: white;
        }
        div.header
        {
            padding: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: bolder;
            color: white;
            background-color: violet;
            /* box-shadow: 0px 0px 20px black; */
        }
        div.canvas
        {
            display: none;
            justify-content: center;
        }
        canvas
        {
            border: 2px solid grey;
            /* box-shadow: 0px 0px 10px yellow ; */
            background-color: rgb(30, 94, 5);
        }

        div.loginBox
        {
            width: 100%;
            height: 500px;
            align-items: center;
            display: flex;
            justify-content: center;
        }
        div.loginBox .login
        {
            width: 300px;
            border-radius: 15px;
            border: 5px solid cornflowerblue;
            /* box-shadow: 0px 0px 10px black; */
            background-color: white;

        }

        div.loginBox input:focus
        {
            outline: none;
        }

        div.loginBox .login input, div.loginBox .login button
        {
            border-radius: 20px;
            border: none;
            font-size: 18px;
            padding: 5px;
        }
        input:focus
        {
            border: none;
            outline: none;
        }
        div.loginBox .login button
        {
            color: white;
            transition: 0.2s;
            background-color: green;
        }
        div.loginBox .login button:hover
        {
            cursor: pointer;
            background-color: rgb(12, 180, 12);
        }
        div.playerBox
        {
            display: none;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            color: #ccc;
        }
        div.playerBox span
        {
            font-weight: bolder;
        }
        div.playerBox button
        {
            padding: 5px;
            border: none;
            border-radius: 10px;
            /* box-shadow: 0px 0px 5px black; */
            color: white;
            font-weight: bold;
            transition: 0.3s;
            font-size: 20px;
        }
        div.playerBox button:hover
        {
            cursor: pointer;
            /* box-shadow: 0px 0px 20px black; */
        }
        div.playerBox button#start
        {
            background-color: rgb(8, 153, 8);
            border: 2px solid #ccc;
        }
        div.playerBox button#start:hover
        {
            background-color: rgb(7, 197, 7);
            border: 2px solid green;
        }
        div.playerBox button#pause
        {
            background-color: rgb(202, 183, 8);
            border: 2px solid #ccc;
        }
        div.playerBox button#pause:hover
        {
            background-color: rgb(228, 206, 10);
            border: 2px solid yellow;
        }
        div.playerBox button#restart
        {
            background-color: rgb(189, 11, 11);
            border: 2px solid #ccc;
        }
        div.playerBox button#restart:hover
        {
            background-color: rgb(209, 9, 9);
            border: 2px solid red;
        }
    </style>

</head>
<body>
    <div class="header">SNAKE GAME 1.0</div>
    <div class="loginBox">
        <div class="login">
            <input type="text" id="username" name="username" placeholder="Nom du joueur">
            <button onclick="return login(this)">Enter</button>
        </div>
    </div>
    <div class="playerBox">
        <p>Player: <span id="playerName"></span> Scoore: <span id="playerScoore"></span> </p>
        <button id="start" onclick="start()">Start</button>
        <button id="restart" onclick="restart()">Restart</button>
    </div>
    <div class="canvas"><canvas id="gc"  width="400" height="400"></canvas></div>

    <script>
        //|===> [ LOGIN ] |=============================================
var scoore=0,i=0,loop=1000;
function login(id)
{
    var username = document.getElementById('username').value;
    if(username != "")
    {
        scoore=0;
        var login = document.querySelector('div.loginBox');
        var canvasBox = document.querySelector('div.canvas');
        var playerBox = document.querySelector('div.playerBox');
        var playerName = document.querySelector('#playerName');
        var playerScoore = document.querySelector('#playerScoore');
        login.style.display = 'none';
        canvasBox.style.display = 'flex';
        playerBox.style.display = 'block';
        playerName.innerHTML = username;
        playerScoore.innerHTML = scoore;
    }
    return false;
}

//|===> [ GAME START ] |=============================================

function start()
{
    canv=document.getElementById("gc");
    ctx=canv.getContext("2d");
    document.addEventListener("keydown",keyPush);
    setInterval(game,1000/15);
}

px=py=10; // position du serpent 
gs=tc=20; // taille du cube et de la paroie
ax=ay=15; // position de la proie
xv=yv=0; // direction du serpent 
trail=[];
tail = 5;

function game() {
    px+=xv;
    py+=yv;
    if(px<0) {
        px= tc-1;
    }
    if(px>tc-1) {
        px= 0;
    }
    if(py<0) {
        py= tc-1;
    }
    if(py>tc-1) {
        py= 0;
    }
    ctx.fillStyle="black";
    ctx.fillRect(0,0,canv.width,canv.height);
 
    ctx.fillStyle="lime";
    for(var i=0;i<trail.length;i++) {
        ctx.fillRect(trail[i].x*gs,trail[i].y*gs,gs-2,gs-2);
        if(trail[i].x==px && trail[i].y==py) {
            tail = 5;
            scoore=0;
            playerScoore.innerHTML = scoore;
        }
    }
    trail.push({x:px,y:py});
    while(trail.length>tail) {
    trail.shift();
    }

    if(ax==px && ay==py) {
        tail++;
        ax=Math.floor(Math.random()*tc);
        ay=Math.floor(Math.random()*tc);
        scoore++;
        playerScoore.innerHTML = scoore;
    }
    ctx.fillStyle="red";
    ctx.fillRect(ax*gs,ay*gs,gs-2,gs-2);
}


function keyPush(evt) {
    switch(evt.keyCode) {
        case 37:
            xv=-1;yv=0;
            break;
        case 38:
            xv=0;yv=-1;
            break;
        case 39:
            xv=1;yv=0;
            break;
        case 40:
            xv=0;yv=1; // bas 
            break;
    }
}

//|===> [ GAME RESTART ] |=============================================

function restart()
{
    location.reload();
}

    </script>

</body>
</html>