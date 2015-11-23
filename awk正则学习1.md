gsub（/123/,456,$3）将第三个域中的“123”替换成“456”
例子：
test文件内容：
0001|efskjfdj|EREADFASDLKJCV
0002|djfksdaa|JDKFJALSDJFsddf
0003|efskjfdj|EREADFASDLKJCV
0004|djfksdaa1234|JDKFJALSDJFsddf
将文本以“|”分割，将第二域中的字母“d”替换成“#”

awk -F '|' 'gsub(/d/,"#",$2) {print $0}' test

0001 efskjf#j EREADFASDLKJCV
0002 #jfks#aa JDKFJALSDJFsddf
0003 efskjf#j EREADFASDLKJCV
0004 #jfks#aa1234 JDKFJALSDJFsddf


awk的变量

awk允许对多个输入文件进行处理。值得注意的是awk不修改输入文件。如果未指定输入文件，awk将接受标准输入，并将结果显示在标准输出上。Awk支持输入输出重定向。
next语句从输入文件中读取一行，然后从头开始执行awk脚本。
如：{if ($1 ~/test/){next} else {print} }
exit语句用于结束awk程序，但不会略过END块。退出状态为0代表成功，非零值表示出错。

awk变量：
在awk中，变量不需要定义就可以直接使用，变量类型可以是数字或字符串。
赋值格式：Variable = expression，如$ awk '$1 ~/test/{count = $2 + $3; print count}' test,上式的作用是,awk先扫描第一个域，一旦test匹配，就把第二个域的值加上第三个域的值，并把结果赋值给变量count，最后打印出来。
awk可以在命令行中给变量赋值，然后将这个变量传输给awk脚本。如$ awk -F: -f awkscript month=4 year=2004 test，上式的month和year都是自定义变量，分别被赋值为4和2004。在awk脚本中，这些变量使用起来就象是在脚本中建立的一样。注意，如果参数前面出现test，那么在BEGIN语句中的变量就不能被使用。
域变量也可被赋值和修改，如$ awk '{$2 = 100 + $1; print }' test,上式表示，如果第二个域不存在，awk将计算表达式100加$1的值，并将其赋值给$2，如果第二个域存在，则用表达式的值覆盖$2原来的值。再例如：$ awk '$1 == "root"{$1 ="test";print}' test，如果第一个域的值是“root”，则把它赋值为“test”，注意，字符串一定要用双引号。
内建变量的使用。变量列表在前面已列出，现在举个例子说明一下。$ awk -F: '{IGNORECASE=1; $1 == "MARY"{print NR,$1,$2,$NF}'test，把IGNORECASE设为1代表忽略大小写，打印第一个域是mary的记录数、第一个域、第二个域和最后一个域。

FS输入字段分隔符（缺省为:space:），相当于-F选项
awk -F ':' '{print}' a    和   awk 'BEGIN{FS=":"}{print}' a 是一样的
OFS输出字段分隔符（缺省为:space:）
awk -F ':' 'BEGIN{OFS=";"}{print $1,$2,$3}' b
如果cat b为
1:2:3
4:5:6
那么把OFS设置成";"后就会输出
1;2;3
4;5;6



