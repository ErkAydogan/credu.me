/**
 * Created by ekrem on 19.11.2016.
 */
var Item = {

    bombs : [],
    points : [],
    redPoints: [],
    tenPoints: [],
    redPoints: [],
    goldBombs: [],
    redBombs: [],
    blueBombs: [],
    greenBombs: [],


    reset : function() {
        this.bombs = [];
        this.points = [];
        this.redPoints = [];
        this.tenPoints = [];
        this.redPoints = [];
        this.goldBombs = [];
        this.redBombs = [];
        this.blueBombs = [];
        this.greenBombs = [];
    },

    update : function(){

        /* Send bombs - points per 100 frame */
        if (frames % 100 === 0) {
            var bombPosition = 20 + 250 * Math.random();
            this.bombs.push({
                x: 500 + 100 * Math.random(),
                y: bombPosition,
                width : bombImage.width,
                height : bombImage.height
            });
            var pointPosition = 20 + 250 * Math.random();
            this.points.push({
                x: 500 + 100 * Math.random(),
                y: pointPosition,
                width : pointImage.width,
                height : pointImage.height
            });
            var tenPointPosition = 20 +150 * Math.random();
            this.tenPoints.push({
                x: 500 + 100 * Math.random(),
                y: tenPointPosition,
                width : tenPointImage.width,
                height : tenPointImage.height
            });
        }
        /* Send goldBombs-redPoints  per 200 frame */
        if (frames % 200 === 0) {
            var redPointPosition = 20 + 250 * Math.random();
            this.redPoints.push({
                x: 400 + 100 * Math.random(),
                y: redPointPosition,
                width : redPointImage.width,
                height : redPointImage.height
            });

            var goldBombPosition = 20 + 250 * Math.random();
            this.goldBombs.push({
                x: 400 + 100 * Math.random(),
                y: goldBombPosition,
                width : goldBombImage.width,
                height : goldBombImage.height
            });

        }

        /* Send redBombs per 400 frame */
        if (frames % 400 === 0) {

            var redBombPosition = 20 + 250 * Math.random();
            this.redBombs.push({
                x: 400 + 100 * Math.random(),
                y: redPointPosition,
                width : redBombImage.width,
                height : redBombImage.height
            });

        }
        /* Send blueBombs per 600 frame */
        if (frames % 600 === 0) {

            var blueBombPosition = 20 + 250 * Math.random();
            this.blueBombs.push({
                x: 400 + 100 * Math.random(),
                y: blueBombPosition,
                width : blueBombImage.width,
                height : blueBombImage.height
            });

        }

        /* Send greenBombs per 800 frame */
        if (frames % 800 === 0) {

            var greenBombPosition = 20 + 250 * Math.random();
            this.greenBombs.push({
                x: 400 + 100 * Math.random(),
                y: greenBombPosition,
                width : greenBombImage.width,
                height : greenBombImage.height
            });

        }

        /* Clear the items that left the window */
        for (var i = 0 , len = this.bombs.length; i < len; i++) {
            var bomb = this.bombs[i];
            detectBombCollision(bomb);

            bomb.x -= 2;
            if (bomb.x < -20) {
                this.bombs.splice(i, 1);
                i--;
                len--;
            }
        }

        for (var i = 0, len = this.points.length; i < len; i++){
            var point = this.points[i];
            detectPointCollision(point);
            point.x -=3;
            if(point.x < -20){
                this.points.splice(i,1);
                i--;
                len--;
            }
        }

        for (var i = 0 , len = this.tenPoints.length; i < len; i++) {
            var tenPoint = this.tenPoints[i];
            detectTenPointCollision(tenPoint);

            tenPoint.x -= 6;
            if (tenPoint.x < -20) {
                this.tenPoints.splice(i, 1);
                i--;
                len--;
            }
        }

        for (var i = 0 , len = this.redPoints.length; i < len; i++) {
            var redPoint = this.redPoints[i];
            detectRedPointCollision(redPoint);

            redPoint.x -= 6;
            if (redPoint.x < -20) {
                this.redPoints.splice(i, 1);
                i--;
                len--;
            }
        }

        for (var i = 0 , len = this.goldBombs.length; i < len; i++) {
            var goldBomb = this.goldBombs[i];
            detectGoldBombCollision(goldBomb);

            goldBomb.x -= 5;
            if (goldBomb.x < -20) {
                this.goldBombs.splice(i, 1);
                i--;
                len--;
            }
        }

        for (var i = 0 , len = this.redBombs.length; i < len; i++) {
            var redBomb = this.redBombs[i];
            detectRedBombCollision(redBomb);

            redBomb.x -= 4;
            if (redBomb.x < -20) {
                this.redBombs.splice(i, 1);
                i--;
                len--;
            }
        }

        for (var i = 0 , len = this.blueBombs.length; i < len; i++) {
            var blueBomb = this.blueBombs[i];
            detectBlueBombCollision(blueBomb);

            blueBomb.x -= 4;
            if (blueBomb.x < -20) {
                this.blueBombs.splice(i, 1);
                i--;
                len--;
            }
        }

        for (var i = 0 , len = this.greenBombs.length; i < len; i++) {
            var greenBomb = this.greenBombs[i];
            detectGreenBombCollision(greenBomb);

            greenBomb.x -= 4;
            if (greenBomb.x < -20) {
                this.greenBombs.splice(i, 1);
                i--;
                len--;
            }
        }

        function detectBombCollision(bomb) {
            var distanceX = bird.xPos - bomb.x;
            var distanceY = bird.yPos - bomb.y;

            var sumRadius = bird.birdRadius + bomb.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                currentState = states.FinalScreen;
            }
        }

        function detectPointCollision(point){
            var distanceX = bird.xPos - point.x;
            var distanceY = bird.yPos - point.y;

            var sumRadius = bird.birdRadius + point.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                score += 1;
                Item.points.splice(i,1);
                i--;
                len--;
            }
        }

        function detectTenPointCollision(tenPoint){
            var distanceX = bird.xPos - tenPoint.x;
            var distanceY = bird.yPos - tenPoint.y;

            var sumRadius = bird.birdRadius + tenPoint.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                currentState = states.FinalScreen;
            }
        }

        function detectRedPointCollision(redPoint){
            var distanceX = bird.xPos - redPoint.x;
            var distanceY = bird.yPos - redPoint.y;

            var sumRadius = bird.birdRadius + redPoint.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                if(score == 0)currentState = states.FinalScreen;
                else{
                    score -= 1;
                    Item.redPoints.splice(i,1);
                    i--;
                    len--;
                }
            }
        }

        function detectGoldBombCollision(goldBomb){
            var distanceX = bird.xPos - goldBomb.x;
            var distanceY = bird.yPos - goldBomb.y;

            var sumRadius = bird.birdRadius + goldBomb.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                score += 2;
                Item.goldBombs.splice(i,1);
                i--;
                len--;
            }
        }

        function detectRedBombCollision(redBomb){
            var distanceX = bird.xPos - redBomb.x;
            var distanceY = bird.yPos - redBomb.y;

            var sumRadius = bird.birdRadius + redBomb.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                score += 3;
                Item.redBombs.splice(i,1);
                i--;
                len--;
            }
        }

        function detectBlueBombCollision(blueBomb){
            var distanceX = bird.xPos - blueBomb.x;
            var distanceY = bird.yPos - blueBomb.y;

            var sumRadius = bird.birdRadius + blueBomb.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                score += 4;
                Item.blueBombs.splice(i,1);
                i--;
                len--;
            }
        }

        function detectGreenBombCollision(greenBomb){
            var distanceX = bird.xPos - greenBomb.x;
            var distanceY = bird.yPos - greenBomb.y;

            var sumRadius = bird.birdRadius + greenBomb.width/2;
            var sqrRadius = sumRadius * sumRadius;

            var distSqr = (distanceX * distanceX) + (distanceY * distanceY);

            if (distSqr <= sqrRadius) {
                score += 5;
                Item.greenBombs.splice(i,1);
                i--;
                len--;
            }
        }


    },

    draw : function(ctx){
        for (var i = 0 , len = this.bombs.length; i < len; i++) {
            var bomb  = this.bombs[i];
            bombImage.draw(ctx,bomb.x,bomb.y);
        }
        for (var i = 0, len = this.points.length; i < len; i++){
            var point = this.points[i];
            pointImage.draw(ctx,point.x,point.y);
        }
        for (var i = 0, len = this.tenPoints.length; i < len; i++){
            var tenPoint = this.tenPoints[i];
            tenPointImage.draw(ctx,tenPoint.x,tenPoint.y);
        }
        for (var i = 0, len = this.redPoints.length; i < len; i++){
            var redPoint = this.redPoints[i];
            redPointImage.draw(ctx,redPoint.x,redPoint.y);
        }
        for (var i = 0, len = this.goldBombs.length; i < len; i++){
            var goldBomb = this.goldBombs[i];
            goldBombImage.draw(ctx,goldBomb.x,goldBomb.y);
        }
        for (var i = 0, len = this.redBombs.length; i < len; i++){
            var redBomb = this.redBombs[i];
            redBombImage.draw(ctx,redBomb.x,redBomb.y);
        }
        for (var i = 0, len = this.blueBombs.length; i < len; i++){
            var blueBomb = this.blueBombs[i];
            blueBombImage.draw(ctx,blueBomb.x,blueBomb.y);
        }
        for (var i = 0, len = this.greenBombs.length; i < len; i++){
            var greenBomb = this.greenBombs[i];
            greenBombImage.draw(ctx,greenBomb.x,greenBomb.y);
        }
    },

}
