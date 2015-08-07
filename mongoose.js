//创建mongoose链接测试
var mongoose = require('mongoose');
var Schema = mongoose.Schema; //创建视图
var model = new Schema({usrName:String,opassworld:String});//视图的结构
mongoose.model('user',model);//这是在书写的书写的时候出现过错误 这是是创建user
mmodule.exports.Schema = function(modelname){
  return {model:mongoose.model(modelname)}；
}
