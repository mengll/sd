  var animFrames = [];
    var str = "";
    for (var i = 1; i < 35; i++) {
        str = "explosion_" + (i < 10 ? ("0" + i) : i) + ".png";
        var frame = cc.spriteFrameCache.getSpriteFrame(str);
        animFrames.push(frame);
    }
    var animation = new cc.Animation(animFrames, 0.04);
    cc.animationCache.addAnimation(animation, "Explosion");
    
     this.animation = cc.animationCache.getAnimation("Explosion");
     
          this.runAction(cc.sequence(
            cc.animate(this.animation), ///演示动画 this.animation this.destory 消失的对象
            cc.callFunc(this.destroy, this)
        ));
