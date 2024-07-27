<?php

namespace Projects\Analytics\App\Models;

use \Repository\Db;


class Model_Analytics_Count_In extends Db {

public $array_ip_in;
public $table;

public function __construct($table, $ip_out) {
	
	$this->table = $table;

	$date_now = date("Y-m-d").'%';
		$request = $this->db("SELECT * FROM $this->table
					WHERE 
					ip = '$ip_out' 
					AND 
					date_activity LIKE '$date_now';");
						$data = null;
							while($result = $request->fetch())
							{
								$data [] = [
											'id_analytics' => $result['id_analytics'],
											'token' => $result['token'],
											'ip' => $result['ip'],
											'activity_score' => $result['activity_score'],
											];
							}
								$this->array_ip_in = $data;
}

public function search_id_user($token_out) {
	
	foreach ($this->array_ip_in as $data)
	{
		if($data['token'] == $token_out)
		{
			$array = [
				'id_analytics' => $data['id_analytics'],
				'token' => $data['token'],
				'ip' => $data['ip'],
				'activity_score' => $data['activity_score'],
				];
					return $array;
		}
	}		
}

public function last_user_activity() {
	
	$ip = $this->array_ip_in[0]['ip'];
		$date_now = date("Y-m-d").'%';
			if(count($this->array_ip_in) > 1)
			{
				$request = $this->db("SELECT * FROM $this->table
				WHERE 
				ip = '$ip' 
				AND 
				date_activity LIKE '$date_now'
				AND
				date_activity = (SELECT MAX(date_activity) FROM $this->table);");
			}
			else
			{
				$request = $this->db("SELECT * FROM $this->table
				WHERE 
				ip = '$ip' 
				AND 
				date_activity LIKE '$date_now';");
			}
				$result = $request->fetch();
					return $result;
}

}
