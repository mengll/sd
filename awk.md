awk正则表达式及内置函数实例详解：
1、模糊匹配：
复制代码 代码如下:

awk ‘{if($3~/97/) print $0}' data.f：如果第三项中含有”97”则打印该行
awk ‘{if($4!~/ufcx/) print $0}' data.f：如果第三项中不含ufcx有则打印
2、精确匹配：
复制代码 代码如下:

awk ‘{if($5==66) print $0}' data.f：如果第五项是66则打印
awk ‘{if($5!=66)print $0}' data.f : 如果第五项不是66则打印
awk ‘{if($1>$5) print $0}' data.f：如果第一项大于第五项则打印
3、大小写匹配：
复制代码 代码如下:

awk ‘{if(/[Ss]ept/) print $0}' data.f：符合，则打印一行。
awk ‘/[Ss]ept/ {print $2}' data.f：符合，则打印第二字段
4、任意匹配：
复制代码 代码如下:

awk ‘{if($2 ~/^.e/) print $0}' data.f：第二字段中，第二个字符为e，输出
awk ‘{if($4 ~/(lps|fcx)/) print $0}' data.f：第四个字段含有lps或fcx则输出
5、&&，||：
复制代码 代码如下:

awk ‘{if($3 ~/1993/ && $2==”sept”) print $0}' data.f：两边都真则输出
awk ‘{if($3 ~/a9/ || $2==”sept”) print $0}' data.f：一边为真则输出
6、变量定义：
awk ‘{date=$2;price=$5; if(date ~/[Ss]ept/) print “price is ” price}' data.f：变量定义，满足date是sept或者Sept的将price输出。
7、修改数值（源文件数值不变）
复制代码 代码如下:

awk ‘{BASELINE=42; if($1>BASELINE) $5=$5+100; print $0}' data.f：三行程序，以“;”分割

如果修改的是文本域，就要添加“”””。例如：awk ‘{if($2==”may”) $2=”tt”; print $0}' data.f
上边都是显示所有数据，awk ‘{if($2==”may”) {$2=”tt”; print $0}}' data.f这个只显示修改数据，仔细看看，其实语法和c一样，只是最外边添加了一个{}符号。
8、创建新域：（源文件数值不变）
复制代码 代码如下:

awk ‘{if($5>$1){$8=$5-$1;print $1,$8}}' data.f：

或者awk ‘{if($5>$1){diff=$5-$1;print $1,diff}}' data.f
9、数据统计：
awk ‘{(total+=$5)}END{print total}' data.f：“{(total+=$5)}”和“{print total}”代表两个不同的代码段，如果没有END每次的累积结果都会输出，END可以理解为代码段落的标志，这样只输出最终结果即{print total}只执行一次。
10、统计文件大小：
复制代码 代码如下:

ls –l | awk ‘{if(/^[^d]/) total=+$5}END{print “total KB:” total}'：/^[^d]/行首匹配可以不写域值$1
11、Awk内置变量：
ARGC 命令行参数个数
ARGV 命令行参数排列
ENVIRON 支持队列中系统环境变量的使用
FILENAME awk浏览的文件名
FNR 浏览文件的记录数
FS 设置输入域分隔符，等价于命令行- F选项
NF 浏览记录的域个数
NR 已读的记录数
OFS 输出域分隔符
ORS 输出记录分隔符
RS 控制记录分隔符
12、awk内置字符串处理函数
gsub ( r, s )在整个$0中用s替代r
gsub ( r, s , t )在整个t中用s替代r
index ( s , t )返回s中字符串t的第一位置
length ( s )返回s长度
match ( s , r )测试s是否包含匹配r的字符串，返回位置
split ( s , a , fs )在fs上将s分成序列a
sprint ( f m t , exp )返回经f m t格式化后的exp
sub ( r, s ,$0) $0中s替换第一次r出现的位置
substr ( s , p )返回字符串s中从p开始的后缀部分
substr ( s , p , n )返回字符串s中从p开始长度为n的后缀部分
13、awk ‘gsub(/6\./,78) {print $0}' data.f：将所有“6.”换成78，并输出
复制代码 代码如下:

awk ‘{if($2==”Sept”) {sub(/3/,”9″,$0); print $0}}' data.f：只替换第一个出现的
awk ‘BEGIN{print index(“hello”,”lo”)}'：输出的值为4
awk ‘{if($3==”3BC1997″) print length($3) ” ” $3}' data.f
awk ‘BEGIN{print match(“ABCD”,”B”)}'：输出2
awk ‘BEGIN{print match(“ABCD”,/B/)}'：“//”和“”””效果一样
awk ‘BEGIN {print split(“123#234#654″, myarray, “#”)}'：返回数组元素个数，123#234#654是字符串，以“#”为分隔符，将字符串放入数组。
awk ‘{if($1==34) print substr($3,2,7)}' data.f
awk ‘BEGIN{print substr(“helloleeboy”,2,7)}'：输出ellole
awk ‘BEGIN{print substr(“helloleeboy”,2,7)}' data.f：输出n遍ellole，n为data.f的行数
14、awk ‘BEGIN{print”May\tDay\n\nMay \104\141\171″}'：\104\141\171表示Day。\t：tab键，\n：换行，\ddd：八进制
15、echo “65” | awk ‘{printf “%c\n”,$0}'：printf函数，和c差不多，输出为A。（ASCII码）
复制代码 代码如下:

echo “65” | awk ‘{printf “%d\n”,$0}'：输出65数字。
awk ‘{printf “%-15s %s\n”,$2,$3}' data.f：“%-15s”左对齐15个字符长度
awk ‘{if(age<$1) print $0}' age=80 data.f和 awk ‘{age=49;if(age<$1) print $0}' data.f结果一样，前者将值传入awk，后者在awk中定义了一个变量。
