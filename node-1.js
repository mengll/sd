1.//创建密码
var md5 = crypto.createHash('md5');
var password = md5.update().digest('hex');
