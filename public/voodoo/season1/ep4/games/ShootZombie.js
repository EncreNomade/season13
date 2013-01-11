var Zombie = function(conf, sx) {
    this.sprite = new mse.Sprite(null, {}, 'zombiesprite', conf.fw, conf.fh, conf.sx, conf.sy, conf.sw, conf.sh);
    this.effet = new mse.EIColorFilter(this.sprite, {duration: 25, rMulti: 0.75, alpha: 0.6});
    this.walkanime = new mse.FrameAnimation(this.sprite, [0,1,2,3,4,5,6,7], 0, 5);
    this.deadanime = new mse.FrameAnimation(this.sprite, [0,8,9], 1, 3);
    this.deadSprite = new mse.Sprite(null, {}, 'zombiesprite', 75,100, 0,0,1050,100);
    this.fadeAnime = new mse.FrameAnimation(this.deadSprite, [0,1,2,3,4,5,6,7,8,9,10,11,12,13], 1, 3);
    this.walkanime.start();
    this.velo = conf.velo;
    this.life = conf.life;
    this.offy = 354 - conf.fh;
    this.minioy = 430 - conf.fh/2;
    this.offx = sx;
    this.state = "INIT";
};
Zombie.prototype = {
    constructor: Zombie,
    init: function(conf, sx) {
        this.sprite.configSprite(conf.fw, conf.fh, conf.sx, conf.sy, conf.sw, conf.sh);
        this.walkanime.start();
        this.count = 0;
        this.velo = conf.velo;
        this.life = conf.life;
        this.offy = 354 - conf.fh;
        this.minioy = 430 - conf.fh/2;
        this.offx = sx;
        this.state = "INIT";
    },
    hit: function(power) {
        this.life -= power;
        this.offx += 15;
        
        this.sprite.startEffect(this.effet);
        if(this.life <= 0) {
            this.state = "DIEING";
            this.deadanime.start();
            this.count = 0;
        }
    },
    logic: function() {
        this.sprite.logic();
        if(this.state == "INIT") {
            this.offx += this.velo;
        }
        else if(this.state == "DIEING") {
            this.count++;
            if(this.count == 9) {
                this.fadeAnime.start();
            }
            else if(this.count == 51)
                this.state = "DEAD";
        }
    },
    drawMini: function(ctx) {
        if(this.offx < 0) return;
        if(this.state == "DEAD" || this.state == "DIEING")
            ctx.drawImage(mse.src.getSrc('zombiesprite'), 698,100,30,30, 440+this.offx/5,this.minioy+10,30,30);
        else
            ctx.drawImage(mse.src.getSrc('zombiesprite'), this.sprite.sx,this.sprite.sy,this.sprite.fw,this.sprite.fh, 440+this.offx/5,this.minioy,30,this.sprite.fh/2);
    },
    draw: function(ctx) {
        if(this.count >= 9) this.deadSprite.draw(ctx, this.offx, this.offy);
        else this.sprite.draw(ctx, this.offx, this.offy);
    }
};

var Rock = function(sprite, type, force, angle) {
    this.sp = sprite;
    this.fr = type;
    var velo = (type == 1 ? force/6 : force/4);
    this.vx = velo * Math.cos(angle);
    this.vy = velo * Math.sin(angle);
    this.angle = angle;
    this.offx = 66;
    this.offy = 265;
    this.count = 10;
    this.rotation = 0;
};
Rock.prototype = {
    constructor: Rock,
    logic: function() {
        if(this.count > 0) {
            this.count--;
            return;
        }
        this.offx += this.vx;
        this.offy += this.vy;
        this.vy += 9.8*0.08;
    },
    draw: function(ctx) {
        if(this.count <= 0) {
            ctx.save();
            ctx.translate(this.offx + 9.5, this.offy + 8.5);
            ctx.rotate(this.rotation);
            this.rotation += Math.PI/6;
            if(this.rotation >= Math.PI * 2) this.rotation = 0;
            ctx.translate(-9.5, -8.5);
            this.sp.drawFrame(this.fr, ctx, 0, 0);
            ctx.restore();
        }
    }
};

var ShootZombie = function() {
    mse.Game.call(this, {fillback:true, size:[600,440]});
    this.config.title = "La cauchemar de Simon";
    
    this.msg = {
        "BEFOREINIT": "Clique pour jouer.",
        "WIN": "Bravo!!! Tu as gagné ",
        "LOSE": "Perdu..."
    };
    var zombieConfig = [
        {
            velo: -1,
            life: 3,
            fw: 64, fh: 94,
            sx: 0, sy: 100, sw: 640, sh: 94
        },
        {
            velo: -2,
            life: 1,
            fw: 60, fh: 101,
            sx: 0, sy: 194, sw: 600, sh: 101
        },
        {
            velo: -3,
            life: 2,
            fw: 60, fh: 102,
            sx: 0, sy: 295, sw: 600, sh: 102
        },
        {
            velo: -4,
            life: 1,
            fw: 60, fh: 105,
            sx: 0, sy: 397, sw: 600, sh: 105
        }
    ];
    var vague = [
        [1,1,1,1,3,1,1,1],
        [3,1,1,3,0,1,3,1,1],
        [3,1,0,1,1,2,3,0,0],
        [0,0,3,0,3,1,1,2,2,3,0],
        [2,2,3,3,0,3,0,2,3,0,2,2]
    ];
    var toolPos = [
        {x:42, y:400},
        {x:118, y:400},
        {x:194, y:400}
    ];
    var power = [
        1,3,2
    ];
    this.shootox = 66;
    this.shootoy = 265;
    
    mse.src.addSource('zombiedecor', 'games/zombieback.jpg', 'img', true);
    mse.src.addSource('zombiesprite', 'games/Sprites.png', 'img', true);
    
    this.decor = new mse.Image(null, {size:[600,440]}, 'zombiedecor');
    this.simon = new mse.Sprite(null, {pos:[17,262]}, 'zombiesprite', 81,92,0,502,729,92);
    this.shootAnime = new mse.FrameAnimation(this.simon, [0,1,2,3,4,5,6,7,8,0], 1, 2);
    this.rockSp = new mse.Sprite(null, {}, 'zombiesprite', 19,17,640,100,57,17);
    this.rocks = [];
    this.zombies = [];
    for(var i = 0; i < 12; ++i) {
        this.zombies[i] = new Zombie(zombieConfig[0], 600);
    }
    
    this.state = "BEFOREINIT";
    this.help = new mse.Text(null, {
    	pos:[60,140],
    	size:[this.width-120,0],
    	fillStyle:"rgb(255,255,255)",
    	font:"20px Arial",
    	textAlign:"center",
    	textBaseline:"top",
    	lineHeight:25}, "Simon rêve qu’il est attaqué par des zombis.\n \nMaintient le bouton gauche de la souris enfoncé et vise. Relache pour lancer le projectile.\n \nClique pour commencer!", true
    );
    this.currVague = 0;
    this.currTime = 0;
    
    this.init = function() {
        this.reinit();
        this.state = "INIT";
        this.currVague = 0;
        this.getEvtProxy().addListener('click', clickcb, true, this);
    };
    this.reinit = function() {
        if(this.currVague == vague.length) this.currVague = 0;
        this.max = vague[this.currVague].length;
        this.curr = 0;
        this.showtime = randomInt(20) + 50;
        this.count = 0;
        this.tool = 0;
        this.skelton = 3;
        this.rockSp.setFrame(0);
        this.angle = 0;
        this.miredis = 100;
        this.mirex = this.shootox+100;
        this.mirey = this.shootoy;
        this.shooting = false;
        this.force = 3;
        this.plus = true;
        this.nextVague = false;
        for(var i = 0; i < this.max; ++i)
            this.zombies[i].init(zombieConfig[vague[this.currVague][i]], 600);
        this.currTime = 0;
    };
    
    this.win = function() {
        this.getEvtProxy().removeListener('gestureStart', cbStart);
        this.getEvtProxy().removeListener('gestureUpdate', cbMove);
        this.getEvtProxy().removeListener('gestureEnd', cbEnd);
        this.state = "WIN";
        this.setScore( 20 * this.currVague + this.currTime * 0.05 );
        this.prototype.win.call(this);
    };
    this.die = function() {
        this.getEvtProxy().removeListener('gestureStart', cbStart);
        this.getEvtProxy().removeListener('gestureUpdate', cbMove);
        this.getEvtProxy().removeListener('gestureEnd', cbEnd);
        this.state = "LOSE";
        this.setScore( 20 * this.currVague + this.currTime * 0.025 );
        this.lose();
    };
    
    this.click = function(e) {
        if(this.state == "INIT") {
            this.state = "START";
            this.getEvtProxy().removeListener('click', clickcb);
            this.getEvtProxy().addListener('gestureStart', cbStart, true, this);
            this.getEvtProxy().addListener('gestureUpdate', cbMove, true, this);
            this.getEvtProxy().addListener('gestureEnd', cbEnd, true, this);
        }
    };
    this.touchStart = function(e) {
        if(MseConfig.android || MseConfig.iPhone) {
            var x = e.offsetX/0.8;
            var y = e.offsetY/0.62;
        }
        else {
            var x = e.offsetX;
            var y = e.offsetY;
        }
        
        // Tool clicked
        for(var i = 0; i < 3; ++i)
            if(Math.abs(x - toolPos[i].x) < 30 && Math.abs(y - toolPos[i].y) < 30) {
                this.tool = i;
                this.rockSp.setFrame(i);
                return;
            }
        
        if(this.tool == 2 && this.skelton <= 0)
            return;
        // Start shoot
        this.force = 3;
        this.shooting = true;
    };
    this.touchMove = function(e) {
        if(MseConfig.android || MseConfig.iPhone) {
            var x = e.offsetX/0.8;
            var y = e.offsetY/0.62;
        }
        else {
            var x = e.offsetX;
            var y = e.offsetY;
        }
        
        if(x < 66 || y > 320) return;
        this.angle = angleForLine(this.shootox, this.shootoy, x, y);
        this.mirex = this.shootox + this.miredis * Math.cos(this.angle);
        this.mirey = this.shootoy + this.miredis * Math.sin(this.angle);
    };
    this.touchEnd = function(e) {
        if(MseConfig.android || MseConfig.iPhone) {
            var x = e.offsetX/0.8;
            var y = e.offsetY/0.62;
        }
        else {
            var x = e.offsetX;
            var y = e.offsetY;
        }
        
        if(this.shooting) {
            this.shooting = false;
            if(this.tool == 2) {
                if(this.skelton <= 0) return;
                else this.skelton--;
            }
            this.shootAnime.start();
            this.rocks.push(new Rock(this.rockSp, this.tool, this.force, this.angle));
        }
    };
    
    this.logic = function() {
        if(this.state != "START") return;
        // Next vague count down
        if(this.nextVague) {
            if(this.count < 75) this.count++;
            else {
                if(this.currVague == vague.length-1) {
                    this.currVague++;
                    this.win();
                    return;
                }
                else {
                    this.currVague++;
                    this.reinit();
                }
            }
        }
        // Force
        if(this.shooting) {
            if(this.plus) {
                if(this.force < 100) this.force+=3;
                else this.plus = false;
            }
            else {
                if(this.force > 3) this.force-=3;
                else this.plus = true;
            }
        }
        // Rocks
        for(var i = 0; i < this.rocks.length; i++) {
            this.rocks[i].logic();
            if(this.rocks[i].offx >= 600 || this.rocks[i].offy >= 345)
                this.rocks.splice(i, 1);
        }
        // New zombie out
        if(this.curr < this.max) {
            this.count++;
            if(this.count == this.showtime) {
                this.showtime += randomInt(20) + 50;
                this.curr++;
            }
        }
        if(!this.nextVague && this.curr == this.max) var vaguefinish = true;
        // Zombie
        for(var i = 0; i < this.curr; ++i) {
            this.zombies[i].logic();
            
            if(this.zombies[i].state != "INIT") continue;
            vaguefinish = false;
            // Stone hit zombie
            var zx = this.zombies[i].offx + 30;
            var zxmax = this.zombies[i].offx + this.zombies[i].sprite.width;
            var zy = this.zombies[i].offy;
            var zymax = this.zombies[i].offy + this.zombies[i].sprite.height;
            for(var j = 0; j < this.rocks.length; j++) {
                var rx = this.rocks[j].offx+9.5;
                var ry = this.rocks[j].offy+8.5;
                if(rx >= zx && rx <= zxmax && ry >= zy && ry <= zymax) {
                    this.zombies[i].hit(power[this.rocks[j].fr]);
                    this.rocks.splice(j, 1);
                }
            }
            
            // Zombie touch simon
            if(this.zombies[i].offx < 50)
                this.die();
        }
        // All zombie down, vague finished, start countdown
        if(vaguefinish) {
            this.nextVague = true;
            this.count = 0;
        }
        
        this.currTime++;
    };
    this.draw = function(ctx) {
        ctx.save();
        if(MseConfig.android || MseConfig.iPhone) {
            ctx.scale(0.8, 0.62);
        }
        // Back
        this.decor.draw(ctx);
        
        // Simon
        this.simon.draw(ctx);
        
        // Zombie
        for(var i = 0; i < this.curr; ++i) {
            this.zombies[i].draw(ctx);
            this.zombies[i].drawMini(ctx);
        }
        
        // Rocks
        for(var i = 0; i < this.rocks.length; i++) {
            this.rocks[i].draw(ctx);
        }
        
        // Interface
        ctx.fillStyle = 'rgba(255,0,0,0.2)';
        ctx.beginPath();
        ctx.arc(toolPos[this.tool].x, toolPos[this.tool].y, 29, 0, Math.PI*2, true);
        ctx.fill();
        // Skelton
        ctx.fillStyle = "#fff";
        ctx.font = "bold 14px Arial";
        ctx.fillText(this.skelton, toolPos[2].x+15, toolPos[2].y-25);
        
        // Shooting
        if(this.shooting) {
            ctx.fillStyle = "#fff";
            ctx.fillRect(this.mirex-8, this.mirey, 18,2);
            ctx.fillRect(this.mirex, this.mirey-8, 2,18);
            ctx.strokeStyle = "#323232";
            ctx.lineWidth = 4;
            ctx.fillStyle = "#f70000";
            ctx.fillRect(22,232,0.8*this.force,18);
            ctx.strokeRoundRect(20,230,84,20,3);
        }
        
        // Start help message
        if(this.state == "INIT") {
            ctx.fillStyle = "rgba(0,0,0,0.6)";
            ctx.strokeStyle = 'rgb(188,188,188)';
            ctx.fillRect(0,0,this.width,this.height);
            ctx.strokeRect(0,0,this.width,this.height);
            this.help.draw(ctx);
        }
        
        ctx.restore();
    };
    
    var cbStart = new mse.Callback(this.touchStart, this);
    var cbMove = new mse.Callback(this.touchMove, this);
    var cbEnd = new mse.Callback(this.touchEnd, this);
    var clickcb = new mse.Callback(this.click, this);
};
extend(ShootZombie, mse.Game);