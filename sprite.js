1.根据图片的资源创建对象
var sprite = cc.Sprite(res.imgs);

var sp2c=  new cc.sprite('re.png',cc.rect(0,0,300,300));


2.根据图片集 或者纹理集 

var sp = cc.Sprite("#sprite")的方式创建精灵



3.通过精灵帧创建

var spriteFrame = cc.spriteFrameCache.getSpriteFrame('background.png');

