/**
 * Created by ekrem on 19.11.2016.
 */

var canvas,
ctx, /* context */
width,
height,
floorPosition = 0,
okbtn,
howToPlayButton,
frames = 0,
score = 0,
currentState,
bestScore = 0,

states = {Menu: 0, Game : 1, FinalScreen :2 , HowToPlay: 3};

function getHighScore(){
    $.ajax({
        url:'GetHighScoreQuery.php',
        dataType:'json'}).done(function(data){
            bestScore = data;
    });
}

function updateHighScore(){
    $.ajax({
        url:'UpdateHighScoreQuery.php',
        type:'post',
        data: 'bestScore='+bestScore,
        success: function(output){}
    });
}

/* eventListener function */
function onpress(event) {
    switch(currentState){
        case states.Menu:
            var mx = event.offsetX, my = event.offsetY;

            if(howToPlayButton.x < mx && mx < howToPlayButton.x + howToPlayButton.width &&
                howToPlayButton.y < my && my < howToPlayButton.y + howToPlayButton.height)
            {

                currentState = states.HowToPlay;
                Item.reset();
                score = 0;
            }
            else {
                currentState = states.Game;
                bird.jump();
                getHighScore();
            }
            break;
        case states.Game:
            bird.jump();
            break;
        case states.FinalScreen:

            var mx = event.offsetX, my = event.offsetY;

            if(okbtn.x < mx && mx < okbtn.x + okbtn.width &&
                okbtn.y < my && my < okbtn.y + okbtn.height)
            {

                currentState = states.Menu;
                Item.reset();
                score = 0;
            }
            break;

        case states.HowToPlay:
            currentState = states.Menu;
            Item.reset();
            score = 0;
            break;
    }
}

function main() {
    canvas = document.createElement("canvas");

    width = window.innerWidth;
    height = window.innerHeight;

    var event = "touchstart";
    if(width >= 500){ /* Decrease the window size in case it's too big */
        width = 320;
        height = 480;
        canvas.style.border = "1px solid #000000";
        event = "mousedown";
    }
    document.addEventListener(event,onpress);


    canvas.width = width;
    canvas.height = height;
    ctx = canvas.getContext("2d");

    currentState = states.Menu;

    document.body.appendChild(canvas);

    /* Loading sprite */
    var img = new Image();
    img.onload = function() {
        initEnvironment(this);

        okbtn = {

            x: (width - okImage.width)/2,
            y: height - 200,
            width: okImage.width,
            height: okImage.height
        };

        howToPlayButton = {

            x: (width - howToPlayImage.width)/2,
            y: height - 200,
            width: howToPlayImage.width,
            height: howToPlayImage.height
        };

        run();
    };

    img.src = "res/imageSprite.png";
}

function run() {
    var loop = function(){
        update();
        render();
        window.requestAnimationFrame(loop,canvas);
    };
    window.requestAnimationFrame(loop,canvas);
}

function update() {
    frames ++;
    if(currentState !== states.FinalScreen) {
        floorPosition = (floorPosition - 2) % 70;
        /* This is used for moving the floor in Menu and Game states */
    }
    if(currentState === states.Game){
        Item.update();
    }
    bird.update();
}

function render() {
    backgroundImage.draw(ctx,0,0);
    bird.draw(ctx);
    Item.draw(ctx);
    floorImage.draw(ctx,floorPosition,320);

    if(currentState === states.Menu){

        thugBirdImage.draw(ctx,(width/2)- thugBirdImage.width/2,height-420);
        tapToPlayImage.draw(ctx,(width/2)- tapToPlayImage.width/2,height-330);
        howToPlayImage.draw(ctx,howToPlayButton.x,howToPlayButton.y);
    }

    else if(currentState === states.HowToPlay){

        howToPlayShowImage.draw(ctx,(width/2)- howToPlayShowImage.width/2,height-330);

    }

    else if(currentState === states.FinalScreen){

        GameOverImage.draw(ctx,(width/2)- GameOverImage.width/2,height-400);
        scoreBoardImage.draw(ctx,(width/2)- scoreBoardImage.width/2,height-340);
        okImage.draw(ctx,okbtn.x,okbtn.y);
        if(bestScore < score) {
            bestScore = score;
            updateHighScore();
        }

        smallNumberImage.draw(ctx,width/2 - 57,height-299,score,null,10);
        smallNumberImage.draw(ctx,width/2 - 57,height-260,bestScore,null,10);

        if(score <= 10){

            medalOneImage.draw(ctx,width/2 - 92,height-295);
        }
        else if(score > 10 && score <= 20){

            medalTwoImage.draw(ctx,width/2 - 92,height-295);

        }
        else if(score > 20 && score <= 30){

            medalThreeImage.draw(ctx,width/2 - 92,height-295);

        }
        else if(score > 30 ){

            medalFourImage.draw(ctx,width/2 - 92,height-295);

        }


    }

    else{
        bigNumberImage.draw(ctx,null,20,score,width/2);
    }
}
main();


