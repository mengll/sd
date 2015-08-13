//引入express
var express = require('express');
var app = express();
//设置引擎
app.engine('html',reuqire('ejs').renderFile);
//配置相关的参数
app.configure(function(){
app.set('port',progress.port||3000);//设置端口信息
app.set('view engine','ejs');//
app.set('views',__dirname+'/views');
app.use(express.static(__dirname+'/puublic')); //使用当前的模块
})


//实现模块的扩展
 module.exports.addUser = function(req,res,next){
      var username = req.data.username;
      var password = req.data.passworld;
      //创建实现用户的表的链接
      // var user =new userDBModel.Schema("user").model; 数据库的实例化的过程
      var user = new user();
      //express 传递数据到页面的方法
      // res.render('./login.html',{message:"用户名和密码错误！"});
 }
 
 //mongodb的分页查询的实现
    var q=obj.search||{}
    var col=obj.columns;
    var pageNumber=obj.page.num||1;
    var resultsPerPage=obj.page.limit||10;
    var skipFrom = (pageNumber * resultsPerPage) - resultsPerPage;
    var query = todo.find({}).sort('-create_date').skip(skipFrom).limit(resultsPerPage);
    
//文件上传的功能的实现
exports.findUpload=function(req,res){
    var tmp_path = req.files.articleLogo.path;
    console.log("temp_path->"+tmp_path);
    // 指定文件上传后的目录 - 示例为"images"目录。
    var target_path = './public/upload/imgages/' + req.files.articleLogo.name;
    console.log(target_path);
    var readStream = fs.createReadStream(tmp_path)
    var writeStream = fs.createWriteStream(target_path);
    readStream.pipe(writeStream);
    readStream.on('end',function() {
        fs.unlinkSync(tmp_path);
      //  res.send('File uploaded to: ' + target_path + ' - ' + req.files.thumbnail.size + ' bytes' + "target_path" + target_path);
    });
}
    
