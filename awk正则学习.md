SED、AWK与正则表达式学习笔记
7. 详解awk
7.1 简介
AWK是一种优良的文本处理工具。它不仅是 Linux 中也是任何环境中现有的功能最强大的数据处理引擎之一。这种编程及数据操作语言（其名称得自于它的创始人 Alfred Aho 、Peter Weinberger 和 Brian Kernighan 姓氏的首个字母）的最大功能取决于一个人所拥有的知识。

AWK 提供了极其强大的功能：可以进行样式装入、流控制、数学运算符、进程控制语句甚至于内置的变量和函数。它具备了一个完整的语言所应具有的几乎所有精美特 性。实际上 AWK 的确拥有自己的语言： AWK 程序设计语言， 三位创建者已将它正式定义为“样式扫描和处理语言”。它允许您创建简短的程序，这些程序读取输入文件、为数据排序、处理数据、对输入执行计算以及生成报 表，还有无数其他的功能。

Awk由循环组成，一个循环是一个历程，它将一直重复执行直到有一些存在的条件终止它。我们不用写这个循环，在awk中它作为一个框架存在，在这个框架中你编写的代码能够执行。

Awk的代码由3个主要部分构成（如下图）

7.2 初探awk
7.2.1   匹配空行

# awk ' /^$/ {print this is kh }' sample

注：sample文件请自行建立。

如果在Shell中直接使用awk，那么在单引号之间不能再使用单引号否则会出错

通过这个实例，大家可以自行试试匹配数字[0-9],匹配字母[a-z[A-Z]

Awk中字段的分割

Awk假设它的输入都是有结构的，而不只是一串无规则的字符。默认情况下awk用空格作为分隔符，对于/etc/passwd这样的文件使用默认显然就比较愚蠢，因为awk会把它看做一个整体。使用-F参数可以设定自己想要的分隔符，定义好后如何调用呢？这时候就用到了$。好现在用实例来说明一下。

7.2.2   匹配passwd文件中的用户

# awk -F : '{print "username " $1 }' /etc/passwd

注：这里使用-F指定了:为分割符（我这里F后带了空格，实际上不带也可以），使用$1引用第一段（众所周知passwd的第一段就是用户名）。朋友们可以可以尝试下用$0看出来什么结果。

实例二

现在咱来打印第四段，通过这个例子向大家说明$后面可以是非常灵活的（整数）。

写脚本

# vim awk

BEGIN{

        FS = ":"

        one = 1

        three = 3

}

{

print $(one + three)

}

执行

# awk -f awk /etc/passwd

注：在简介中的图中已经提到过BEGIN。FS是awk变量用来指定分隔符。下面的one和three都是自己定义的变量，并且被我赋值。需要注意的一点是在awk中变量区分大小写，并且不可以数字开头。

7.2.3   计算空行的数目

本例主要演示赋值运算符++和+= 。这类符号还有很多如表中所示

Operator

Description

++

Add 1 to variable.

–

Subtract 1 from variable.

+=

Assign result of addition.

-=

Assign result of subtraction.

*=

Assign result of multiplication.

/=

Assign result of division.

%=

Assign result of modulo.

^=

Assign result of exponentiation.

**=

Assign result of exponentiation.[6]

如果对编程有些了解的朋友应该对它们并不陌生。

还是以刚刚自行建立的sample为例。

写脚本

vim awk

/^$/{

print x = x + 1

}

执行后便可统计出空行数。

这里的x=x+1完全可以被x +=1 和 x++ 替代，使代码更简洁。

注：如此统计不够完美，因为数是排列出来的，可以自行尝试使用END 来显示最后的结果。

7.2.4   计算学生的平均成绩

john 85 92 78 94 88

andrea 89 90 75 90 86

jasper 84 88 80 92 84

代码如下

{

       #总成绩

       sum = $2+$3+$4+$5+$6

       #平均分

       avg = sum / 5

       #输出

       print $1 , avg

}

结果

# awk -f 脚本的位置 成绩单的位置

john 87.4

andrea 86

jasper 85.6

7.2.5   银行账单

账单如下

总资产1000

编号   地点     数目

125     Market  125.45

126     Hardware Store  34.95

127     Video Store     7.45

128     Book Store      14.32

129     Gasoline        16.10

代码如下

BEGIN{

        FS = "\t"

        blance = 1000

}

{

        blance  = blance- $3

        print blance

}

注：此题不难，请朋友们按照自己的思路写一个脚本来计算。

简洁的写法

awk 'BEGIN{FS="\t"}{count+=$3}END{print 1000-count}' checks.data

7.2.6   统计LS的信息

Ls –l 输出的结果

total 52

-rwxr-xr-x 1  502 games  92 Mar  2  1997 acro

-rw-r--r-- 1  502 games 247 Mar  2  1997 acronyms

-rw-r--r-- 1 root root   76 Feb  4 09:49 awk

-rw-r--r-- 1  502 games 298 Mar  2  1997 checkbook.awk

-rw-r--r-- 1  502 games 109 Mar  2  1997 checks.data

-rwxr-xr-x 1  502 games 163 Mar  2  1997 filesum1

-rwxr-xr-x 1  502 games 749 Mar  2  1997 filesum2

-rwxr-xr-x 1  502 games 766 Mar  2  1997 filesum3

-rwxr-xr-x 1  502 games  42 Mar  2  1997 fls1

-rw-r--r-- 1  502 games 244 Mar  2  1997 fls.data

-rw-r--r-- 1  502 games  92 Mar  2  1997 grades1.awk

-rw-r--r-- 1  502 games 100 Mar  2  1997 grades2.awk

-rw-r--r-- 1  502 games  64 Mar  2  1997 grades.data

现在我来写一个脚本统计ls –l中文件的数量及大小。

脚本的框架应该是这样的

ls -l $* | awk '{

        print $5, "\t", $9

}'

$*是shell里的一个变量用来扩展通过命令行传递的所有变量。这些参数可能是文件名，目录或ls的附加选项。

好，让我们先来统计文件的个数吧。

NF==9 && /^-/{

       Filenum ++

}

END { print  "there are",filenum,"files here" }

注：NF==9用来过滤第一行total 52。

/^-/是正则，匹配文件，在Linux中文件是用-来表示。

现在来统计大小

NF==9 && /^-/{

       filenum ++

       total += $5

}

END { print  "there are",filenum,"files here" , "total",total, "bytes"}

到此为止文件个数和大小都已经被统计。但是为了更清楚我们到底统计了哪些文件，我们还需要完善一下该脚本。

BEGIN {

        print "files","bytes"

}

NF==9{

        filenum ++

        total += $5

        print $9,$5

}

END { print  "there are",filenum,"files here" , "total",total, "bytes"}

运行后输出结果格式比较混乱

files bytes

acro 92

acronyms 247

awk 76

checkbook.awk 298

checks.data 109

filesum1 163

filesum2 749

filesum3 766

fls 172

fls.data 244

grades1.awk 92

grades2.awk 100

grades.data 64

there are 13 files here total 3172 bytes

好，现在使用printf来整理一下

7.2.7   格式化输出printf

Awk的printf与c一样。以下是用在printf中的格式说明符

c

ASCII character

d

Decimal integer十进制整数

i

Decimal integer. (Added in POSIX)

e

Floating-point format ([-]d.precisione[+-]dd)

E

Floating-point format ([-]d.precisionE[+-]dd)

f

Floating-point format ([-]ddd.precision)

g

e or f conversion, whichever is shortest, with trailing zeros removed

G

E or f conversion, whichever is shortest, with trailing zeros removed

o

Unsigned octal value

s

String字符串

x

Unsigned hexadecimal number. Uses a-f for 10 to 15

X

Unsigned hexadecimal number. Uses A-F for 10 to 15

%

Literal %

这次主要用printf来规定对齐方式。

右对齐

# awk 'END {printf ("|s|\n","hello")}' /etc/passwd

|     hello|

左对齐

# awk 'END {printf ("|%-10s|\n","hello")}' /etc/passwd

|hello     |

好了不知道大家有没有点感觉，如何让上例中的格式对齐呢？

格式化后的完整代码如下

ls -l $* | awk '

BEGIN{

        printf("%-15s\ts\n","files","bytes")

}

NF==9{

        filenum ++

        total += $5

        printf ("%-15s\td\n",$9,$5)

}

END { print  "There are",filenum,"files here\n" "Total",total, "bytes"}

'

7.2.8   统计学生成绩单

首先我们要使用的是for循环，利用它制造出一个“万能”平均分计算器。

For循环的框架

for ( 变量初值 ; 条件（范围） ; 计数方法 )
动作
以该成绩单为例

mona 70 77 85 83 70 89

john 85 92 78 94 88 91

andrea 89 90 85 94 90 95

jasper 84 88 80 92 84 82

dunce 64 80 60 60 61 62

ellis 90 98 89 96 96 92

代码如下

        total = 0

        for (i=2 ;i<=NF;++i )

        {

                total = total + $i

        }

        avg = total / (NF-1)

注：total是总成绩

(NF -1)因为第一列是名字，所以需要-1 。这里的括号一定不能少，不然除法是比加法优先的。

好了，现在不管分有多少我们都可以用它算出成绩来了！

成绩出来了就一定有好有坏，现在来用if语句来把及格和不及格的成绩过滤出来。

If语句的框架如下

if ( 条件 ){
动作1 }
else
动作2
现在我们用if来判断学生的成绩是否及格。这里以60为底线。

        if ( avg >= 60)

                grade = "good job!"

        else

                grade = "sorry!"

有时遇到的情况可能会更复杂一些，比如要为成绩分类，统计出每个层次的学生数量等。这时可以用else if来设置多个条件。

现在假设要把成绩分为4类。A,B,C,D

        if ( avg >= 90) grade = "A"

        else if ( avg >= 80 ) grade = "B"

        else if ( avg >= 60 ) grade = "C"

        else if ( avg <= 60 ) grade = "D"

结合上面的代码，一个统计学生成绩单的程序就出来了！完整代码如下

{

        total = 0

        for (i=2 ;i<=NF;++i )

        {

                total = total + $i

        }

        avg = total / (NF-1)

        if ( avg >= 90) grade = "A"

        else if ( avg >= 80 ) grade = "B"

        else if ( avg >= 60 ) grade = "C"

        else if ( avg <= 60 ) grade = "D"

        print $1,avg,grade

}

请朋友们自己试着统计出每个层次的学生数量。

技巧：在代码顶部加入#!/bin/awk –f可以直接调用awk来执行人物。有时候比使用awk –f 脚本 目标 的方式更简洁一些。

好，现在来做下练习巩固前面所学到的东西，之后进行数组的学习。

7.3 练习
打印输入文件第八行

#!/bin/awk -f

{

  if ( NR == 8 )

  { print $0 }

}

打印输入行的总数：awk -F: 'END{print NR}' passwd

打印字段数大于等于4个的行：awk -F: 'NF >＝4 {print $0}' passwd

打印文件所有字段的总数awk -F ":" 'BEGIN { N=0 } {n+=NF}END{ print n}' /etc/passwd

打印UID在30～40范围内的用户名：awk 'BEGIN {FS=":"} { if ($3 >= 30 && $3 <= 40) {print $0}}' /etc/passwd

倒序排列文件的所有字段

注：标记为红色的是我个人曾未做出的题目

BEGIN {

        FS=":|:/"

}

{

        for (x=NF ; x>=1 ; --x)

        printf("%s:",$x)

        printf("\n") #这是重点

}

隔行删除：awk -F ":" '{if ( NR%2==1 ) print $0}' /etc/passwd

抽取每行第一次出现的单词

awk -F "[^a-zA-Z]+" '/.$/{if ($1 ~ /[a-zA-Z]+/) print $1 ; else print $2}' /etc/passwd

打印字段大于5个的行总数

BEGIN {

        FS=":"

}

NR > 5{

        num ++

}

END {print num}

输出文件的每一行的倒数第二个字段：

BEGIN {

        FS=":|/"

}

{

        for (i=0 ; i <= NR ; ++i)

        NR == i

        print $(NF -1)

}

输出可以登录与不可以登录的用户数量：

BEGIN {

        FS = ":|:/"

}

{

if (/Bash/){ 可以登陆

        ++num

}

else if (/nologin/){ 不可登陆

        ++num2

}

else{ 其他

        ++num3

}

}

END {

        print num,num2,num3

}

7.3.1   数组

数组是可以用来存储一组数据的变量。通常这些数据之间具有某种联系。数组中的每一个元素通过它们在数组中的下标来访问。下面是数据的框架

array[下标] = 元素
在awk中不必指明数组的大小，只需要为数组指定标识符。
下面的例子为数组flavor的一个元素指定了一个字符串“cherry”
flavor[1] = "cherry"

这个数组的下标是“1”。下面的语句将打印“cherry”

print flavor[1]

好，现在让我们利用数组将学生平均分计算程序更加强大！（编写时能用数组的地方都用了数组，主要是为了向大家介绍数组。但是大家要明白，那些功能并非一定要用数组才能解决）

本次需要实现的功能有1计算班级平均分2统计高于和低于平均分的人数3统计A,B,C,D中各有多少人。

成绩单

mona 70 77 85 83 70 89

john 85 92 78 94 88 91

andrea 89 90 85 94 90 95

jasper 84 88 80 92 84 82

dunce 64 80 60 60 61 62

ellis 90 98 89 96 96 92

执行效果。（着色部分是本次加入的新功能）

$ awk -f grades.awk grades.test
mona    79      C

john    88      B

andrea  90.5    A

jasper  85      B

dunce   64.5    D

ellis   93.5    A

Class Average:  83.4167

At or Above Average:    4

Below Average:  2

A:      2

B:      2

C:      1

D:      1

代码如下

{

        total = 0

        for (i=2;i<=NF;i++)

                total += $i

        avg = total / (NF -1)

        if (avg >= 90) grade = "A"

        else if (avg >= 80) grade = "B"

        else if (avg >= 70) grade = "C"

        else grade = "D"

        student_avg_total[NR] = avg

        ++level[grade]

        print $1,avg,grade

}

END{

        for (x=1 ; x <= NR ; x++)

                class_avg_total += student_avg_total[x]

                class_avg = class_avg_total / NR

        print "Class Avg:",class_avg

        for (x=1; x<=NR;x++)

                if (student_avg_total[x] >= class_avg)

                        ++niubi

                else

                        ++yiban

        print "At or Above Average:",niubi

        print "Below Average:",yiban

        for (num in level)

                print num ":" level[num]

}

班级平均分的实现

将所有平均分都放入了数组中，并以NR作为下标（因为NR值是递增的）。

在END中通过一个for循环将元素调出，相加。用和除以NR便可得出班级平均分。

统计高于和低于平均分的人数

通过for循环将平均分调出，然后使用if语句进行判断。

统计A,B,C,D中各有多少人

在本例中实际上最难理解的点应该在这里 ++level[grade]

在grade中存储的是A,B,C,D。而++level负责统计字母出现的个数。

        for (num in level)

这里num（可以是任意名称）可看做是和普通for循环计数器（i++）一样递增的临时变量，in指定了它作用在哪个数组。

                print num ":" level[num]

这里num调出了level的元素名，而level[num]调出了统计结果。

注：awk中所有的数组都是关联数组。关联数组的独特之处在于它的下标可以是一个字符串或一个数值。

7.3.2   词汇搜索

本程序根据用户提交的缩略词将文件中的完整写法提取。

文件如下

USGCRP  U.S. Global Change Research Program

NASA    National Aeronautic and Space Administration

EOS     Earth Observing System

代码

BEGIN { FS = "\t"

        printf("Enter a glossary term: ")

}

FILENAME == "glossary" {

        entry[$1] = $2 #将第二段与第一段的缩写对应

        next #将数组载入完成后进入下面的代码段

}

#如果输入内容不为空则进行下面的判断

$0 != "" {

       #in是一个操作符，用在条件表达式中来测试一个小标是否是数组的成员

        if ( $0 in entry ) {

                print entry[$0]

        } else

                print $0 " not found"

}

#如果输入内容为空

{

  printf("Enter another: ")

}

好，基本功能实现了。因为本脚本从标准输入中读取，所以在执行的时候需要这样写awk -f lookup1 glossary glossary –

本程序有一个缺点就是用户无法主动退出，现在来补充这个内容

$0 ~ /^(quit|[qQ]|exit|[Xx])$/ { exit }

不需要记，以后自己在写脚本的时候直接复制粘贴即可！

7.3.3   用split()创建数组

内置函数split()能够将任何字符串分解到数组的元素中。这个函数对于从字段中提取“子字段”是很有用的。函数split()的框架如下

n = split(字符串, 数组, 分隔符（或者正则）)
n为数组中元素的个数，所以数组中的下标从1开始到n。

7.3.4   打印罗马数字

输入从1到10的数字并转换为罗马数字。

根据split的框架我们可以这样写

split ("I,II,III,IV,V,VI,VII,VIII,IX,XI",number,",")

这样就把罗马数字存入了数组中，此时number[1]=I.number[2]=II……

#判断$1是否在1-10之间。

$1>0 && $1<=10 {

       #过滤小数

      if (/[0-9]\.[0-9]*/) {

                        print "not a good number"

        }else

                        print number[$1]

       #exit告诉程序执行到这里就结束，不然即使输入正确也会报错

        exit

}

如果不是1-10之间的数字，则报错

{

        print "faild"

        exit

}

7.3.5   转换日期格式

将“mm-dd-yy”或“mm/dd/yy”转换为“月日，年”

代码如下

awk '

#与打印罗马数字一样的思路一样。首先在BEGIN中将1-12与12月份的英文单词对应。

BEGIN {

        listmonths = "January,February,March,April,May,June,July,August,September,October,November,December"

        split( listmonths , month ,",")

}

#判断输入

$1 != ""{

        dateg = split($1 , date , "-") #将$1打散放入数组

        if (dateg == 1) #判断是否有内容的

                datexg == split( $1 , date , "/")

        if (datexg ==1)

                exit

       date[1] += 0 #处理类似于12/05/09这样的操作，awk认为05和5是两个不一样的字符，最终结果将导致以05表示的五月无法被正常输出。

        print month[date[1]],date[2]",",date[3]

}'

7.3.6   处理文章的缩写词

文章如下

The USGCRP is a comprehensive

research effort that includes applied

as well as basic research.

The NASA program Mission to Planet Earth

represents the principal space-based component

of the USGCRP and includes new initiatives

类似于黄色字体的都是缩写词，本次编写的程序就目的就是把这些词转换。

缩写词的对应关系存储在acronyms中

USGCRP  U.S. Global Change Research Program

NASA    National Aeronautic and Space Administration

EOS     Earth Observing System

代码如下

awk 'FILENAME == "acronyms" #读取存储缩写词对应关系的文件

{

       #制作缩写词对应关系的数组（之前也做过，并且比这个方法简单，看以参阅“词汇搜索”）

        split($0,entry,"\t")

        acro[entry[1]]=entry[2]

        next

}

#匹配包含多个大写字母的行

/[A-Z][A-Z]+/{

        for (i=1;i<=NF;i++)

                #一段一段的截取出来并判断是否有缩写存在于acro中

                if ($i in acro){

                        #如果存在则进行替换。"("$i")"用来显示被替换的缩写词

                        $i=acro [$i] "("$i")"

                }

}

{

        print $0

}' acronyms $*

常用

1.按内存从大到小排列进程:  

ps -eo "%C : %p : %z : %a"|sort -k5 -nr

2.查看当前有哪些进程；查看进程打开的文件: 

ps -A ；lsof -p PID

 

3.获取当前IP地址（从中学习grep,awk,cut的作用）

ifconfig eth0 |grep "inet addr:" |awk '{print $2}'|cut -c 6-

SED、AWK与正则表达式学习笔记（三）
2011年1月18日Linux桌面应用
1 Star 2 Stars 3 Stars 4 Stars 5 Stars  (No Ratings Yet)

没有评论
6. 详解sed
6.1 引语
本篇主要是让大家对sed的脚本编写有一个整体的了解，在大脑中能有个框架。

写脚本前一定要

1. 具体的分析清楚自己想做什么

2. 明确处理的过程

3. 在应用于生产环境前要反复测试

下面图中的示例是sed如何匹配字符串并替换

从图中可以看出sed首先将整个编辑脚本应用于第一个输入行，然后在读取第二个输入行并对其应用整个脚本。这种做法的优点显而易见，跟少食多餐一个 性质，一顿饭吃一百个馒头恐怕你的胃就爆了，这就是内存溢出。

6.2 Sed脚本的3种用途
1. 对同一文件的编辑。

热身:包含了以前章节中的知识点

HORSEFEATHERS SOFTWARE PRODUCT BULLETIN

DESCRIPTION

+   ___________

BigOne Computer  offers three  software packages from the  suite

of Horsefeathers  software products  –  Horsefeathers  Business

BASIC, BASIC  Librarian,  and LIDO.  These software products can

fill  your    requirements    for    powerful,    sophisticated,

general-purpose business  software providing you with a base for

software customization or development.

Horsefeathers  BASIC is  BASIC optimized for use on  the  BigOne

machine with UNIX  or MS-DOS operating systems.  BASIC Librarian

is a full screen program editor, which also provides the ability

要求

1用sea取代所有空行

这个不用多说，在上次的文章中已经写过

s/^$/sea/g

2删除每行前面的空格

s/^  *//g

3删除+后的___

/^+  *___*/d

4删除在两个单词之间的多个空格

s/  */ /g

5保留.号后的多个空格

s/\. */\.  /g

6干掉,号后的空格

s/\,  */\,/g

2. 改变一组文件

类似于这样

sed -i -e ’74 s/^/#/’ -i -e ’76 s/^/#/’ $ssh_cf

sed -i “s/#UseDNS yes/UseDNS no/” $ssh_cf

sed -i -e ’44 s/^/#/’ -i -e ’48 s/^/#/’ $ssh_cf

sed -i ‘/expose_php/s/On/Off/’ $fcgi_cf

sed -i ‘/display_errors/s/On/Off/’ $fcgi_cf

sed -i ‘s#extension_dir = “./”#extension_dir = “no-debug-non-zts-20060613/”\nextension这样的脚本可以节省大量的时间，但如果写的不好造成的错误恐怕会让你花 更多的时间去解决。所以制作这种脚本时最好多做测试以免以后出乱子。

注：这种脚本通常出现在安装程序脚本的制作上。如果经常看文档，应该对此不会陌生。

3. 提取文件的内容

例：提取C 源文件中的 main() 函数

$ sed -n -e ‘/main[[:space:]]*(/,/^}/p’ sourcefile.c | more

注：这里的[[:space:]] 只是一个特殊的关键字，它告诉 sed 与 TAB 或空格匹配。

6.3 基本sed命令
想要用好sed首先就要了解它的框架，知道每一段都是干什么的。

框架: [address]s/pattern/replacement/flags
Flags可以看做是古代打仗作战时的令旗。

6.3.1   Flags段

以下是该段可能出现的参数

n 1-512间的一个数字，指定对第n次出现的情况进行替换

g 全局替换

p 打印

w 将样本写入到某个文件中

替换指令应用于与address匹配的行。如果没有指定地址，那么就应用于与pattern匹配的所有行。

Flag段中的指令和组合使用。

6.3.2   replacement段

&

表示用正则表达式匹配的内容进行替换

这东西以前我非常难以理解，因为所看的大部分中文文档对此都没有过详述。

比如一篇文章里面有很多关键字如：社会主义。现在我想在每个社会主义后面都加一个好并且用括号括起来。

s/社会主义/(&好）/g

现在大家应该明白了它的意思吧？（生产环境估计是没有中文，这里主要是为了大家好理解）

\n

匹配第n个子串（n是一个数字），这个子串需要在pattern中用“\(\)”包围。

例现在文章中的关键字有司马光，小李，猴子。现在想变成司马光砸缸子，小李飞刀，猴子偷桃。

s/\(司马光\)\(小李\)\(猴子\)/\1砸缸子\2飞刀\3偷桃/

\ 转义特殊符号。在相关文档中提到\也可以当作换行符来用。

注：The backslash is generally used to escape the other metacharacters but it is also used to include a newline in a replacement string.

追加，插入和更改

这些命令的语法在sed中不常用，因为它们必须在多行上来指定。语法如下

追加 [line-address]a\
text
插入 [line-address]i\
text
修改 [address]c\
text
替换文件中不可正常输出的字符

曾经使用过man 查看文档，并把文档重定向的朋友一定知道用firefox或者gedit这类工具打开重定向的文档时会出现很多小方块。那些小方块是用来调节格式的，而 ff和gedit不认识而已。

查看不可见字符。如换行。

Sed –n –e “l” file

这时便可以看见了。针对文档拿掉那些符号即可。

读和写文件

语法如下

[line-address]r file
[address]w file
非常实用的功能。
例如在代码中结尾处有;的地方给予提示。
代码如下
/;$/r file
执行效果
sed -f scr index.php
