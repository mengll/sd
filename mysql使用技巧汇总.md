select * from t where id in (
    select substring_index(substring_index(idlist,',',nums.id),',',-1) from nums,
    (
        select nid,v,group_concat(tid) idlist from (
            select t.id tid,nums.id nid,
            case nums.id 
            when 1 then concat(c1,',',c2)
            when 2 then concat(c2,',',c3)
            when 3 then concat(c1,',',c3) end v from nums,t where nums.id <=3 
        ) t1 group by nid,v having count(*)>1
    ) t2 where nums.id<=(length(idlist) - length(replace(idlist,',',''))+1)
);

1、substring_index(str,delim,count)
　　      str:要处理的字符串
　　      delim:分隔符
　　      count:计数
　　例子：str=
　　substring_index(str,'.',1)
　　结果是：www
　　substring_index(str,'.',2)
　　结果是：www.google
　　也就是说，如果count是正数，那么就是从左往右数，第N个分隔符的左边的全部内容
　　相反，如果是负数，那么就是从右边开始数，第N个分隔符右边的所有内容，如：
　　substring_index(str,'.',-2)
　　结果为：google.com
　　有人会为，如果我呀中间的的google怎么办？
　　很简单的，两个方向：
　　1、从右数第二个分隔符的右边全部，再从左数的第一个分隔符的左边：
　　substring_index(substring_index(str,'.',-2),‘.’,1);
　　2、你懂得！
　　2，concat是连接几个字符串，可以多个哦。
　　concat('wo','lin','xue','bin')
　　结果就是wolinxuebin。
　　
　　
　　通俗点理解，其实是这样的：group_concat()会计算哪些行属于同一组，将属于同一组的列显示出来。要返回哪些列，由函

    数参数(就是字段名)决定。分组必须有个标准，就是根据group by指定的列进行分组。
    
    if(条件，成立返回，不成立返回结果) as 别名 //根据的当前的条件判断使用的是当前的第几个值
    
    case when then end //感觉就像是switch的条件的判断的方法的处理，可以根据当前的条件判断返回县官的
    case 传入的值，when 判断当前的值是否 then 是则执行 end  别名 所用都结束
    
    
    
    
