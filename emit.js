//事件发送机制的实现

//创建一个事件的绑定 
var util = require('util');
var events = require('events');

function MyStream(){
	events.EventEmitter.call(this);
}

//实现方法的继承

util.inherits(MyStream,events.EventEmitter);

//创建对象原型
MyStream.prototype.write = function(data){
	this.emit("data",data);
}

//创建方法来使用当前的对象
var stream = new MyStream();

stream.on("data",function(data){
	console.log('oh this had get message! that is '+data);
});

stream.write("It works!");
