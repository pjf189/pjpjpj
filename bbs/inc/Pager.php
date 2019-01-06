<?php 
require_once 'database.php';
/**
* 
*/
class PAger{
	public $page_size,$page_holder;
	public $page_start,$page_last,$page_current,$page_previous,$page_next;
	public $sql;

	function __construct($sql,$page_size=10,$page_holder='page'){
		//全局变量与局部变量的区别
		global $handle;

		$this->page_start = 1;
		$this->page_holder = $page_holder;  
		$this->page_size = $page_size;  
		$this->sql = $sql;  

		$sql_amount = 'select count(*) as amount  ' . substr($sql, strpos($sql,'from' ) ) ;
		//计算总记录数
		$row_amount = $handle->query($sql_amount)->fetchObject()->amount;

		//计算总页数	
		$this->page_last = ceil($row_amount / $page_size);
	}

	function query($page_current = 1){
		//全局变量与局部变量的区别
		global $handle;

		$this->page_current = $page_current ;
		//当未指定页号，或者页号错误时	
		if (empty($page_current) || $page_current < 1){
			$this->page_current = 1;
		}elseif($page_current > $this->page_last){
			$this->page_current = $this->page_last;
		}

		//生成上一页、下一页
		$this->page_previous = ($this->page_current <= $this->page_start ) ? $this->page_start : $this->page_current - 1 ;
		$this->page_next = ($this->page_current >= $this->page_last ) ? $this->page_last : $this->page_current + 1 ;

		//计算返回纪录的起点与记录数
		$row_base= ($this->page_current-1) * $this->page_size;
		$page_sql = " LIMIT {$this->page_size} OFFSET {$row_base}";

		$sql = $this->sql .  $page_sql;
		return $handle->query($sql);

	}

	public function nav_html($value=''){
		$query_str = "{$_SERVER['SCRIPT_NAME']}?" ;

		$arr = [
			'page_first' =>'page_start',
			'page_previous'=>'page_previous',
			'page_next'=>'page_next',
			'page_last'=>'page_last'
		];
		
		//as $_GET or $_POST
		$params = $_REQUEST;
		foreach ($arr as $key => $value) {
			$params[$this->page_holder] = $this->$value;	
			$key .= '_q';
			$$key =  $query_str . http_build_query($params);
		}
		
		
		return <<< EOT
	  <div id="pager"> 
	    <a href="$page_first_q">首页</a>
	    <a href="$page_previous_q">上一页</a>
	    <a href="$page_next_q">下一页</a>    
	    <a href="$page_last_q">末页</a>  
	    <span>当前第$this->page_current 页</span>
	    <span>总共 $this->page_last 页</span> 
	  </div>    
EOT;
	}


}//end of class






 ?>