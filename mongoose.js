//创建mongoose链接测试
var mongoose = require('mongoose');
var Schema = mongoose.Schema; //创建视图
var model = new Schema({usrName:String,opassworld:String});//视图的结构
mongoose.model('user',model);//这是在书写的书写的时候出现过错误 这是是创建user
mmodule.exports.Schema = function(modelname){
  return {model:mongoose.model(modelname)}；
}

//重写不用上面的代码
//多么模型的的引用的方式
//!1首先的是引入mongoose 模块
var mongoose = require('mongoose');
var Schema  = mongoose.Schema; //获取视图

//创建user表的模型
var userSchema = new Schema({UserName:String,PassWorld;String});

//创建news 视图
var newsSchema = new Schema({id:Int,news:String});

//创建model的操作
mongoose.model('user',userSchema);
mongoose.model('news',newsSchema);

//获取数据模型的操作
module.exports.Schema = function(modelName){
  return mongoose.Schema.model(modelName);
}

//调用的方式

var user =new userDBModel.Schema("user").model; ///引入的文件名称标的名称 model对象

//创建索引
UserSchema.index({loginname: 1}, {unique: true});
UserSchema.index({email: 1}, {unique: true});
UserSchema.index({score: -1});

UserSchema.virtual('isAdvanced').get(function () {
  // 为满足某些特殊的需求，而创建新增的虚拟的属性 在最后的时候要返回你说定义的，虚拟的属性
  return this.score > 700 || this.is_star;
});

//创建链接的密码的实现

var md5 = crypto.createHash('md5') var password = md5.update().digest('hex'); //获取当前的加密的密钥
