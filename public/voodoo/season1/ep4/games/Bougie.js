var Bougie = function() {
    mse.Game.call(this);
    
    this.setDirectShow(true);
    this.firstShow = false;
    
    this.offx = mse.coor(mse.joinCoor(0)); this.offy = mse.coor(mse.joinCoor(0));
    this.width = mse.coor(mse.joinCoor(800)); this.height = mse.coor(mse.joinCoor(600));
    this.bougiePos = [
        {x:mse.coor(mse.joinCoor(108)),y:mse.coor(mse.joinCoor(275)),
         w:mse.coor(mse.joinCoor(57)),h:mse.coor(mse.joinCoor(90))},
        {x:mse.coor(mse.joinCoor(310)),y:mse.coor(mse.joinCoor(250)),
         w:mse.coor(mse.joinCoor(40)),h:mse.coor(mse.joinCoor(60))},
        {x:mse.coor(mse.joinCoor(485)),y:mse.coor(mse.joinCoor(270)),
         w:mse.coor(mse.joinCoor(45)),h:mse.coor(mse.joinCoor(65))},
        {x:mse.coor(mse.joinCoor(580)),y:mse.coor(mse.joinCoor(345)),
         w:mse.coor(mse.joinCoor(65)),h:mse.coor(mse.joinCoor(110))}
    ];
    
    mse.src.addSource('zippoimg', 'games/flame.png', 'img', true);
    mse.src.addSource('backcut0', 'games/grotte1.png', 'img', true);
    mse.src.addSource('backcut1', 'games/grotte2.png', 'img', true);
    mse.src.addSource('backcut2', 'games/grotte3.png', 'img', true);
    mse.src.addSource('backcut3', 'games/grotte4.png', 'img', true);
    mse.src.addSource('backlight', 'games/newback.jpg', 'img', true);
    
    this.zippo = new mse.Sprite(null, {}, 'zippoimg', 57,64, 0,0,57,64);
    this.fire = new mse.Sprite(null, {}, 'zippoimg', 17,58, 57,0,68,58);
    this.fireAnime = new mse.FrameAnimation(this.fire, [0,1,2,3,3], 0, 2);
    this.part = [];
    this.part[0] = new mse.Image(null, {pos:[0,0],size:[mse.coor(mse.joinCoor(355)),mse.coor(mse.joinCoor(600))],globalAlpha:0}, 'backcut0');
    this.part[1] = new mse.Image(null, {pos:[mse.coor(mse.joinCoor(264)),mse.coor(mse.joinCoor(159))],size:[mse.coor(mse.joinCoor(129)),mse.coor(mse.joinCoor(208))],globalAlpha:0}, 'backcut1');
    this.part[2] = new mse.Image(null, {pos:[mse.coor(mse.joinCoor(418)),mse.coor(mse.joinCoor(148))],size:[mse.coor(mse.joinCoor(180)),mse.coor(mse.joinCoor(236))],globalAlpha:0}, 'backcut2');
    this.part[3] = new mse.Image(null, {pos:[mse.coor(mse.joinCoor(300)),0],size:[mse.coor(mse.joinCoor(500)),mse.coor(mse.joinCoor(600))],globalAlpha:0}, 'backcut3');
    this.backlight = new mse.Image(null, {pos:[0,0],size:[mse.coor(mse.joinCoor(800)),mse.coor(mse.joinCoor(600))]}, 'backlight');
    
    this.light = [false, false, false, false];
    this.firstShow = false;
    this.mousex = 0;
    this.mousey = 0;
    this.count = null;
    
    this.move = function(e) {
        this.mousex = e.offsetX - this.offx;
        this.mousey = e.offsetY - this.offy;
    };
    this.click = function(e) {
        var x = e.offsetX - this.offx;
        var y = e.offsetY - this.offy;
        for(var i = 0; i < 4; ++i) {
            if(!this.light[i] && 
               x > this.bougiePos[i].x && x < this.bougiePos[i].x+this.bougiePos[i].w &&
               y > this.bougiePos[i].y && y < this.bougiePos[i].y+this.bougiePos[i].h) {
                this.light[i] = true;
                if(this.light[0] && this.light[1] && this.light[2] && this.light[3])
                    this.count = 60;
                break;
            }
        }
    };
    
    this.init = function() {
        if(layers.background.getObjectIndex(this) == -1)
            layers.background.insertAfter(this, objs.obj306);
        this.parent = layers.background;
        this.getEvtProxy().addListener("move", this.movecb);
        this.getEvtProxy().addListener("click", this.clickcb);
        layers.content.interrupt();
        mse.fadeout(layers.content, 25);
        mse.fadeout(layers.mask, 25);
        
        mse.setCursor('pointer');
        this.fireAnime.start();
        this.state = "START";
    };
    this.win = function() {
        this.getEvtProxy().removeListener("move", this.movecb);
        this.getEvtProxy().removeListener("click", this.clickcb);
        mse.root.evtDistributor.setDominate(null);
        mse.fadein(layers.content, 25);
        mse.fadein(layers.mask, 25, new mse.Callback(layers.content.play, layers.content));
        
        mse.setCursor('default');
        this.fireAnime.stop();
        
        this.state = "END";
    };
    this.logic = function(ctx) {
        if(this.state != "START") return;
        for(var i = 0; i < 4; i++) {
            if(this.light[i] && this.part[i].globalAlpha < 1) 
                this.part[i].globalAlpha += 0.04;
        }
        if(this.count !== null) {
            if(this.count > 0)
                this.count--;
            else this.win();
        }
    };
    this.draw = function(ctx) {
        if(this.state == "END") {
            this.backlight.draw(ctx);
            return;
        }
        if(this.state != "START") return;
        
        if(!this.firstShow) {
        	this.firstShow = true;
        	this.evtDeleg.eventNotif('firstShow');
        	this.evtDeleg.eventNotif('start');
        }
        ctx.save();
        ctx.translate(this.offx, this.offy);
        // Draw new back
        for(var i = 0; i < 4; i++)
            this.part[i].draw(ctx);
        
        // Zone
        ctx.globalCompositeOperation = "source-atop";
        ctx.translate(this.mousex, this.mousey);
        ctx.fillStyle = "#fff";
        ctx.globalAlpha = 0.1;
        ctx.beginPath();
        ctx.arc(0, -45, 54, 0, 2*Math.PI, true);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(0, -45, 57, 0, 2*Math.PI, true);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(0, -45, 60, 0, 2*Math.PI, true);
        ctx.fill();
        ctx.globalCompositeOperation = "source-over";
        
        // Zippo and fire
        this.fire.draw(ctx, -8.5, -74);
        this.zippo.draw(ctx, -40, -40);
        
        ctx.restore();
    };
    
    this.movecb = new mse.Callback(this.move, this);
    this.clickcb = new mse.Callback(this.click, this);
};
extend(Bougie, mse.Game);