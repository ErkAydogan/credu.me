/**
 * Created by ekrem on 19.11.2016.
 */

var backgroundImage,
    floorImage,
    GameOverImage,
    birdImage,
    okImage,
    redPointImage,
    pointImage,
    tenPointImage,
    thugBirdImage,
    scoreBoardImage,
    tapToPlayImage,
    smallNumberImage,
    bigNumberImage,
    rateImage,
    scoreImage,
    howToPlayImage,
    startImage,
    shareImage,
    closeButtonImage,
    pauseButtonImage,
    medalOneImage,
    medalTwoImage,
    medalThreeImage,
    medalFourImage,
    goldBombImage,
    redBombImage,
    blueBombImage,
    greenBombImage,
    howToPlayShowImage,
    bombImage;

/* This is used for retrieving images from single PNG file */
/* x,y values stand for the starting coordinate of the image */
/* width-height stand for the width and height of the image */

function Environment(img,x,y,width,height){
    this.img = img;
    this.x = x;
    this.y = y;
    this.width = width;
    this.height = height;
}

Environment.prototype.draw = function(ctx,x,y){
    ctx.drawImage(this.img,this.x,this.y,this.width,this.height,x,y,this.width,this.height);
};

function initEnvironment(img) {
    backgroundImage = new Environment(img, 0, 0, 320,490);
    floorImage = new Environment(img,0,510,400,161);
    birdImage = new Environment(img,0,701,30,30);
    redPointImage = new Environment(img,30,701,30,32);
    tenPointImage = new Environment(img,61,701,30,32);
    pointImage = new Environment(img,123,701,30,32);
    bombImage = new Environment(img,91,701,31,31);
    thugBirdImage = new Environment(img,6,752,150,50);
    GameOverImage = new Environment(img,6,817,180,45);
    scoreBoardImage = new Environment(img,0,864,226,119);
    tapToPlayImage = new Environment(img,0,1058,120,66);

    smallNumberImage = new Environment(img, 0, 1157, 12, 15);
    bigNumberImage = new Environment(img, 0, 1179, 14, 22);

    howToPlayShowImage = new Environment(img,182,1067,265,133);

    goldBombImage = new Environment(img,154,700,31,31);
    redBombImage = new Environment(img,185,700,31,31);
    blueBombImage = new Environment(img,247,700,31,31);
    greenBombImage = new Environment(img,215,700,31,31);

    okImage = new Environment(img,79,1029,83,28);
    rateImage = new Environment(img,0,1001,81,28);
    scoreImage = new Environment(img,0,1029,81,28);
    howToPlayImage = new Environment(img,79,1001,83,28);
    startImage = new Environment(img,159,1001,83,28);
    shareImage = new Environment(img,159,1029,83,28);
    closeButtonImage = new Environment(img,241,1001,28,28);
    pauseButtonImage = new Environment(img,241,1029,28,28);

    medalOneImage = new Environment(img,227,864,45,47);
    medalTwoImage = new Environment(img,227,911,45,47);
    medalThreeImage = new Environment(img,274,864,45,47);
    medalFourImage = new Environment(img,274,911,45,47);


    // Below function is for writing score to the screen and converting numbers to image
    smallNumberImage.draw = bigNumberImage.draw = function(ctx, x, y, num, center, offset) {
        num = num.toString();

        var step = this.width + 2;

        if (center) {
            x = center - (num.length*step-2)/2;
        }
        if (offset) {
            x += step*(offset - num.length);
        }

        for (var i = 0, len = num.length; i < len; i++) {
            var n = parseInt(num[i]);
            ctx.drawImage(img, step*n, this.y, this.width, this.height, x, y, this.width, this.height);
            x += step;
        }
    }

}
