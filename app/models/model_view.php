<?php

namespace Projects\Analytics\App\Models;

use \Projects\Auth\App\Models\Model_Auth;
use \Repo\Db;
use PDO;
use DateTime;


class Model_View extends Db {

public $auth;

public function __construct() {
	
	$modelAuth = new Model_Auth();
		$this->auth = $modelAuth->check();
}

public function viewMain() {

	if($this->auth)
	{
		$table = 'analytics_projects';
			$data['email'] = $_SESSION['user']['email'];
		
		$db = $this->db();
			$query = $db->query("SELECT * FROM $table");

		// Create data array
		while($result = $query->fetch())
		{
			// Get count
			$dataAnalytics = $this->getAnalytics($result['key_name'], 'today', false);
			
			$result['count'] = [
									'total' => $dataAnalytics['count']['total'],
									'reg' => $dataAnalytics['count']['reg'],
									'online' => $dataAnalytics['count']['online']
								];
			$data[] = $result;				
		}	
				return $data;
	}
}

public function getAnalytics($project, $period, $api = true) {

	require '../config/config.php';

	if($this->auth)
	{
		$table = 'analytics_'.$project;
			$table_projects_list = 'analytics_projects';
	 
		$date = new DateTime();

		$db2 = $this->db();
			$query2 = $db2->query("SELECT * FROM $table_projects_list WHERE key_name = '$project'");
				$projects = $query2->fetch(PDO::FETCH_ASSOC);


		$db = $this->db();	
			if($period == 'today') {
				$date_activity = $date->format("Y-m-d");
			
			} elseif($period == 'yesterday') {
				$date->modify("-1 day");
				$date_activity = $date->format("Y-m-d");
			
			} elseif($period == 'current_month') {
				$date_activity = $date->format("Y-m");
			
			} elseif($period == 'last_month') {
				$date->modify("-1 month");
					$date_activity = $date->format("Y-m");
			};

			$query = $db->query("SELECT * FROM $table WHERE date_activity LIKE '%$date_activity%' ORDER BY date_activity DESC");

			// Create ['projects']	
			$data['project'] = [
									'key_name' => $projects['key_name'],
									'url' => $projects['url']
								];
			
			// Create ['count']
			$data['count'] = [
								'total' => $query->rowCount(),
								'reg' => 0,
								'unreg' => 0,
								'online' => $this->count_online($projects['key_name'])
							];									
			
			// Create ['users']		
			$users = null; // If users don`t exist

				while($result = $query->fetch(PDO::FETCH_ASSOC))
				{
					// Add property online
					$result['online'] = $this->is_online($result['date_activity']);

					// Editing output - date_activity
					if($period == 'today')
					{
						$result['date_activity'] = substr($result['date_activity'], 11, -3);
					}	
					
					// Editing output - email
					$result['email'] = $this->userFromToken($result['token']);

					// Editing output - token
					if($result['token'] == 0)
					{
						$result['token'] = false;
					}
					else
					{
						$result['token'] = true;
					}

					// Hidden data
					if($_SESSION['user']['token'] !== $whoi)
					{
						$result['email'] = $this->hidden_data('user', $result['email']);
							$result['ip'] = $this->hidden_data('ip', $result['ip']);
					}

					// Count reg and unreg users
					if($result['token'])
					{
						$data['count']['reg'] += 1;
					}
					else
					{
						$data['count']['unreg'] += 1;
					}
						$users[] = $result;
				}
					$data['users'] = $users;

						// Return mode
						if($api)
						{
							echo json_encode($data);
						}
						else
						{
							return $data;
						}
	}
}

public function count_online($project) {
	
	$date_before = strtotime('-15 minutes');
		$date = date('Y-m-d H:i:s', $date_before);

	$db = $this->db();	
		$table = "analytics_".$project;
			$query = $db->query("SELECT * FROM $table WHERE date_activity > '$date' ORDER BY date_activity DESC");

				$query->execute();
			
		$data = $query->rowCount();
	
	return $data;
}

public function is_online($time) {
	
	$date_now = time();
		$date_activity = strtotime($time);
			$difference = $date_now - $date_activity;
				$date_fifteen = 60 * 15;	

	if($difference < $date_fifteen) {
		return true;
	}
	else
	{
		return false;
	}
}

public function userFromToken($token) {

	$db = $this->db();
		$query = $db->query("SELECT * FROM users WHERE token = '$token'");
			$result = $query->fetch();
		
	if($result) {
		$user = $result['email'];
	}
	else
	{
		$user = 'Unregistration user';
	}		
		return $user;
}

public function hidden_data($option, $data) {

	if($option == 'user')
	{
		if($data == 'Unregistration user')
		{
			return $data;
		}
		else
		{
			$data_start = substr($data, 0, 1);
				$data_middle = str_repeat('*', strpos($data, '@')-1);
					$data_end = substr($data, strpos($data, '@'));

			return $data_start . $data_middle . $data_end;
		}

	}
	elseif($option == 'ip')
	{
		$dot_1 = strpos($data, '.');
			$part_1 = substr($data, 0, $dot_1);

		$string_2 = substr($data, $dot_1 + 1);
			$dot_2 = strpos($string_2, '.');
				$part_2 = substr($string_2, 0, $dot_2);

		$string_3 = substr($string_2, $dot_2 + 1);
			$dot_3 = strpos($string_3, '.');
				$part_3 = substr($string_3, 0, $dot_3);

		$string_4 = substr($string_3, $dot_3 + 1);
			$part_4 = $string_4;

				$part_2 = str_repeat('*', strlen($part_2));
				$part_3 = str_repeat('*', strlen($part_3));

		return $part_1.'.'.$part_2.'.'.$part_3.'.'.$part_4;
	}
}

}
