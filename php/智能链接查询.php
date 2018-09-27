    // 数据库链接表
    public function get_db_link(){
        return array(
            "app_type"   => array(
                "base_table" => " ty_game_app ",
                "join"       => " left join",
                "on"		 => array("pid"=>"id"),                     // 基础字段 关联表的字段	 
                "select"	 => ["os"],                                 // 获取字段 
                "where"		 => array("os"=>'app_type',"id"=>"pid","game_id"=>"game_id"),    //管理字段 
                "order"		 => "",         // 排序 
                "limit"		 => "",         //取值限制
                "alias"      => "tgame",     //别名
                "group"      => "",
                "having"     => ""
            ),
            "page" => array(
                "base_table" => " ty_page ",
                "join"       => " left join",
                "on"		 => array("page_id"=>"id"),                 // 基础字段 关联表的字段	 
                "select"	 => ["id","media_id","group_id","app_id"],  // 获取字段 
                "where"		 => array("id"=>'page_id',"media_id"=>'media_id',"group_id"=>"group_id"),  //管理字段 
                "order"		 => "",         // 排序 
                "limit"		 => "",         //取值限制
                "alias"      => "tpage" ,    //别名
                "group"      => "",
                "having"     => ""
            ),
            "zone" => array(
                "base_table" => " ty_user_zone ",
                "join"       => " left join",
                "on"		 => array("ucid"=>"ucid","pid"=>"pid"),          // 基础字段 关联表的字段	 
                "select"	 => ["zone_id"],                    // 获取字段 
                "where"		 => array("zone_id"=>'zone_id'),    //管理字段 
                "order"		 => "",         // 排序 
                "limit"		 => "",         //取值限制
                "alias"      => "tzone",     //别名
                "group"      => "ucid",
                "having"     => ""
            ),
            "active" => array(
                "base_table" => " ty_device_active_new ",
                "join"       => " inner join",
                "on"		 => array("imei"=>"deviceid","pid"=>"pid"),          // 基础字段 关联表的字段	 
                "select"	 => ["deviceid"],                    // 获取字段 
                "where"		 => array(),    //管理字段 
                "order"		 => "",         // 排序 
                "limit"		 => "",         //取值限制
                "alias"      => "tactive",     //别名
                "group"      => "",
                "having"     => ""
            ),
            "pay" => array(
                "base_table" => " ty_user_orders ",
                "join"       => " inner join",
                "on"		 => array("pid"=>"pid","ucid"=>"ucid"),          // 基础字段 关联表的字段	 
                "select"	 => ["deviceid"],                    // 获取字段 
                "where"		 => array('create_date >= '=>"date_start",'create_date <= ' =>"date_end"),    //管理字段 
                "order"		 => "",         // 排序 
                "limit"		 => "",         //取值限制
                "alias"      => "tpay",     //别名
                "group"      => "",
                "having"     => ""
            )

        );
    }

    // 获取type_sql
    public function get_type_sql($where_arr,$type,$alias){
        $where = array();
        $link_dat = $this->get_db_link();
        $app_type = $link_dat[$type];
        $join = $app_type["join"] .$app_type['base_table'].' as '.$app_type['alias']." on ";
        $app_as = $app_type['alias'];
        $ons = [];
        foreach($app_type['on'] as $k =>$v){
            $ons[] = " ".$alias.".".$k."=".$app_as.".".$v." ";
        }
        $join = $join .implode(' and ',$ons);

        foreach($app_type['where'] as $k =>$v){
    
            if ($where_arr[$v] !=''){

                $type = gettype($where_arr[$v]);
                if ($type == "string" || $k == "zone_id"){
                    if($v == "date_start" || $v == "date_end"){
                        $where[] = $app_as.".".$k.date('Ymd',strtotime($where_arr[$v])) ;
                    }else{
                        $where[] = $app_as.".".$k." = '".$where_arr[$v] ."' ";
                    }
                }else{
                    $where[] = $app_as.".".$k." = ".$where_arr[$v] ." ";
                }
            }
        }
        return [$join,$where];
    }

    //设置基础表
    public function get_base_table(){
        return array(
            'register'          =>  "ty_user_meta_data",
            "login"             =>  "ty_user_login_log",
            "recharge"          =>  "ty_user_orders",
            "role_create"       =>  'ty_user_zone',
            "login_recharge"    =>  "ty_user_login_log",
            "register_recharge" =>  "ty_user_meta_data",
            "register_device"   =>  "ty_user_meta_data",
            "role_create_role_count_gt_2" => "ty_user_zone",
            "role_create_role_count_eq_2" => "ty_user_zone",
            "recharge_role_create_role_count_gt_2"=>"ty_user_zone",
            "recharge_role_create_role_count_eq_2"=>"ty_user_zone"
        );
    }

    // base table kyes 
    public function get_base_table_key($tb){
        //基础表主要字段信息
        $base_table_key = array();
        $base_table_key["ty_user_meta_data"] = array("pid"=>"int","rid"=>"int","imei"=>"string","page_id"=>"int","ucid"=>"int","create_date"=>"int");
        $base_table_key["ty_user_login_log"] = $base_table_key["ty_user_meta_data"];
        $base_table_key["ty_user_orders"]    = array("pid"=>"int","rid"=>"int","zone_id"=>"int","page_id"=>"int","ucid"=>"int","create_date"=>"int");
        $base_table_key["ty_user_zone"] =  $base_table_key["ty_user_orders"] ;
        return $base_table_key[$tb];
    }

    // 通用注册数据查询
    public function get_user_info($where_arr){
        $base_tale = $this->get_base_table();
        $tbs = array();
        $tbs["tb_name"] = $base_tale[$where_arr['event']];
        $tbs["alias"]   = "tu";
        $tbs["select"]  = array("ucid");
        $sql_h  = "select ";
        $select = [];
        $from   = " from ";
        $join   = "";
        $where  = [];
        $group  = "";
        $order  = "";
        $limit  = ""; 
        $having = "";

        $kyes  = $this->get_base_table_key($tbs["tb_name"]);
        $alias =$tbs['alias'];
        $from .= $tbs['tb_name'] .' as '.$alias.' ';
        foreach( $tbs['select'] as $k =>$v){
            $select[] = $alias.".".$v;           
        }
       
        $link_dat = $this->get_db_link();
        if($where_arr['app_type'] || $where_arr['game_id']){
            $dt = $this->get_type_sql($where_arr,"app_type",$alias);
            $join .= $dt[0];
            $where = array_merge($where,$dt[1]);
        }
        
        if( $where_arr['group_id'] || $where_arr['page_id'] || $where_arr['media_id']){
            if(isset($kyes['page_id']) && $where_arr['page_id']){
                $where[] = $alias.".page_id =".$where_arr['page_id'];
            }else{
                $dt = $this->get_type_sql($where_arr,"page",$alias);
                $join .= $dt[0];
                $where = array_merge($where,$dt[1]);
            }
        }

        if($where_arr['zone_id'] ){
            if(isset($kyes['zone_id']) && $where_arr['zone_id']){
                $where[] = $alias.".zone_id = '".$where_arr['zone_id']."'";
            }else{
                $dt = $this->get_type_sql($where_arr,"zone",$alias);
                $join .= $dt[0];
                $where = array_merge($where,$dt[1]);
            }
        }

        if ($where_arr['date_start']){
            $start_date = date("Ymd",strtotime($where_arr['date_start']));
            $where[] = $alias."."."create_date >= {$start_date}";
        }
        if ($where_arr['date_end']){
            $end_date = date("Ymd",strtotime($where_arr['date_end']));
            $where[] = $alias."."."create_date <= {$end_date}";
        }
        
        if($where_arr['pid']){
            $pid = $where_arr['pid'];
            $where[] = $alias."."."pid = {$pid}";
        }
        
        switch($where_arr['event']){
            //登录充值，注册充值
            case "login_recharge" :
            case "register_recharge":
                $dt = $this->get_type_sql($where_arr,"pay",$alias);
                $join .= $dt[0];
                $where = array_merge($where,$dt[1]);
            break;

            // 注册激活
            case "register_device":
                $dt = $this->get_type_sql($where_arr,"active",$alias);
                $join .= $dt[0];
                $where = array_merge($where,$dt[1]);
                break;

            case "role_create_role_count_gt_2":
            case "role_create_role_count_eq_2":
                    if($where_arr['event'] == "role_create_role_count_eq_2"){
                        $having = "HAVING count(*) = 2";
                    }else{
                        $having = "HAVING count(*) >= 2";
                    } 
                break;

            case "recharge_role_create_role_count_gt_2":
            case "recharge_role_create_role_count_eq_2":
                    $dt = $this->get_type_sql($where_arr,"pay",$alias);
                    $join .= $dt[0];
                    $where = array_merge($where,$dt[1]);
                    if($where_arr['event'] == "recharge_role_create_role_count_eq_2"){
                        $having = "HAVING count(*) = 2";
                    }else{
                        $having = "HAVING count(*) >= 2";
                    }
                    
        }
        if (isset($kyes['ucid'])){
            $group = "GROUP BY {$alias}.ucid ";
        }
    
        $sql = [$sql_h ,implode(',',$select),$from,$join,'where',implode(" and ",$where),$group,$having];
        $run_sql = [];
        foreach($sql as $k =>$v){
              if($v != ''){
                $run_sql[] = $v;
              }  
        }
        return implode(' ',$run_sql);
    }

    public function get_ucid($where){
        set_time_limit(0);
        ini_set('memory_limit','500M');
        $data = array('total'=> 0, 'rows'=> [], 'query_sql'=>'', 'query_time'=> 0);
        $type = $where['event'];
        $sql = '';
        $base_tale = $this->get_base_table();
        $kyes  = $this->get_base_table_key($base_tale[$type]);
        switch($type){
            case "active":
                    $login = $where;
                    $login['event'] = "login";
                    $reg   = $where;
                    $reg['event']   = "register";
                    $sql =  $this->get_user_info($login) ." EXCEPT ".$this->get_user_info($reg);
                break;
         
            // 处理衮服的操作    
            default:
                    $sql = $this->get_user_info($where);    
        }

        if (isset($kyes['ucid'])){
            $ucids_sql = $sql;
        }else{
            $ucids_sql = "SELECT DISTINCT ucid FROM ($sql) AS t";
        }
      
        $users_sql = "with td as ($ucids_sql LIMIT 1000) SELECT td.ucid, uid, nickname, last_login_at, last_login_ip FROM ucusers INNER JOIN td ON ucusers.ucid = td.ucid";

        $data['query_sql'] = $users_sql;
        $data['rows'] = $this->queryFindAll($users_sql);
        $result = $this->queryFind("SELECT COUNT(t.ucid) AS total FROM ($ucids_sql) AS t");

        $data['total'] = intval($result['total'] ?? 0);
        return $data;
    }
