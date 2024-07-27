<?php

namespace Projects\Analytics\App\Models;

use \Repository\Db;
use Flight;
use \Kudashevs\AcceptLanguage\AcceptLanguage;


class Model_Analytics_Count extends Db {

public $token_out;
public $ip_out;
public $timestamp;
public $date_now;
public $city;
public $region;
public $isp;
public $referer;
public $lang;
public $country;
public $longitude;
public $latitude;
public $device;
public $os;
public $browser;
public $obj_ip_in;
public $project;
public $table_analytics;
public $mode;


public function __construct($project, $mode) { // Mode: all, reg

	$this->project = $project;
		$this->table_analytics = 'analytics_'.$project;

	// Get data from an incoming request
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->referer = $_SERVER['HTTP_REFERER'];
		}
		else
		{
			$this->referer = 'Direct link';
		}
			
			$this->ip_out = Flight::request()->ip;

			$this->lang = $this->getLanguage();
				
			// Filling data from user agent
			$user_agent = $this->user_agent_parser(Flight::request()->user_agent);
		
			$this->device = $user_agent['device'];
				$this->os = $user_agent['os'];
					$this->browser = $user_agent['browser'];

			$this->timestamp = date("Y-m-d H:i:s");
				$this->date_now = date("Y-m-d").'%';
					$this->obj_ip_in = new Model_Analytics_Count_In($this->table_analytics, $this->ip_out);
										
		// get data from api
		$data_api = $this->get_ip_detail($this->ip_out);
							
		if(!empty($data_api))
		{
				$this->city = $data_api['city'];
					$this->region = $data_api['region'];
						$this->isp = $data_api['isp'];
									$this->country = $data_api['country'];
											$this->latitude = $data_api['latitude'];
												$this->longitude = $data_api['longitude'];
		}
		else
		{
				$this->city = 'Local city';
					$this->region = 'Local region';
						$this->isp = 'Local isp';
							$this->country = 'Local country';
									$this->latitude = 1212.1212;
										$this->longitude = 1212.1212;
		}

		// Set token out
		if(isset($_SESSION['user']['token']) AND $_SESSION['user']['token'] != null)
		{
			$this->token_out = $_SESSION['user']['token'];
		}
		else
		{
			if(isset($_COOKIE['token']))
			{
				$this->token_out = $_COOKIE['token'];
			}
			else
			{
				$this->token_out = 0;
			}
		}

		$this->mode = $mode;
}

public function count() {

	// Search ip today
	if(empty($this->obj_ip_in->array_ip_in))	
	{
		// (token) = 0
		if($this->search_token('out', 0))
		{
			$this->add();
		}
		else
		{
			// [token] = (token) today
			if($arr_token_today = $this->search_token('today', $this->token_out))
			{
				$this->update('without_token', $arr_token_today);
			}
			else
			{
				$this->add();	
			}
		}
	}
	else
	{
		// [[token][token][token]] = (token)
		if($arr_user = $this->search_token('in', $this->token_out))
		{
			$this->update('with_token', $arr_user);
		}
		else
		{
			// TODAY [token] = (token) Except [0]
			if($arr_token_today = $this->search_token('today', $this->token_out))
			{
				// [token] = 0
				if($arr_token_0 = $this->search_token('in', 0))
				{
					$this->union($arr_token_0, $arr_token_today);
				}
				else
				{
					$this->update('with_token', $arr_token_today);
				}
			}
			else
			{
				// (token) = 0
				if($this->search_token('out', 0))
				{
					$this->update('without_token', $this->obj_ip_in->last_user_activity());	
				}
				else
				{
					// [token] = 0
					if($arr_in_row = $this->search_token('in', 0))
					{
						$this->update('with_token', $arr_in_row);	
					}
					else
					{
						$this->add();
					}
				}
			}
		}
	}					
}

public function send_mail($project) {
        
	if(Flight::request()->ip != '127.0.0.1')
	{
		$project = ucfirst($project);

		$to = "danishevskij@gmail.com";
		$subject = 'Visit - '.$project.'!';
		
		$message = "<h2><a href='#' style='color:black'>".$this->userFromId($this->token_out)."</a></h2>";
		$message .= "<p style='font-size:18px'>".$this->city.", ".$this->region."</p>";
		$message .= "<p style='font-size:18px'><a href='#' style='color:black'>Referer: ".$this->referer."</a></p>";
		
		$header = "From: DOV Analytics <admin@dov.pp.ua> \r\n";
		$header .= "Cc:admin@dov.pp.ua \r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html\r\n";
		
		mail($to,$subject,$message,$header);
	}
}

public function search_token($where, $value) {

	if($where == 'out')
	{
		if($this->token_out == $value)
		{
			return true;
		}
	}
	else if($where == 'in')
	{
		if(empty($this->obj_ip_in->array_ip_in))
		{
			return false;
		}
		else
		{		

		$input = false;	
			foreach($this->obj_ip_in->array_ip_in as $data)
			{
				if($data['token'] == $value)
				{
					$input = $data;
				}

			}

			return $input;
		}
	}
	else if($where == 'today')
	{
				$request = $this->db("SELECT * FROM $this->table_analytics
					WHERE 
					token = '$value' 
					AND
					token != '0'	
					AND 
					date_activity LIKE '$this->date_now';");

				if($result = $request->fetch())
				{
					return $result;
				}


	}
}	

public function update($key, $array_ip_in) {

	$activity_score_count = $array_ip_in['activity_score'] + 1;
		$id_row_update = $array_ip_in['id_analytics'];

		if($key == 'with_token')
		{
			$this->db("UPDATE $this->table_analytics
						SET
						token = '$this->token_out',
						ip = '$this->ip_out',
						date_activity = '$this->timestamp',
						device = '$this->device',
						os = '$this->os',
						browser = '$this->browser',
						activity_score = '$activity_score_count',
						lang ='$this->lang',
						city = '$this->city',
						region = '$this->region',
						isp = '$this->isp'
						WHERE
						id_analytics = '$id_row_update'");	   
		}
		elseif($key == 'without_token')
		{
			$this->db("UPDATE $this->table_analytics
						SET
						ip = '$this->ip_out',
						date_activity = '$this->timestamp',
						device = '$this->device',
						os = '$this->os',
						browser = '$this->browser',
						activity_score = '$activity_score_count',
						city = '$this->city',
						region = '$this->region',
						isp = '$this->isp'
						WHERE
						id_analytics = '$id_row_update'");
		}
}

public function union($del, $upd) {

		$activity_score_count = $del['activity_score'] + $upd['activity_score'];	
			$id_row_update = $upd['id_analytics'];
				$id_row_del = $del['id_analytics'];

			$this->db("UPDATE $this->table_analytics
						SET
						ip = '$this->ip_out',
						date_activity = '$this->timestamp',
						device = '$this->device',
						os = '$this->os',
						browser = '$this->browser',
						lang = '$this->lang',
						activity_score = '$activity_score_count',
						city = '$this->city',
						region = '$this->region',
						isp = '$this->isp'
						WHERE
						id_analytics = '$id_row_update'");

			$this->db("DELETE
					   FROM $this->table_analytics 
					   WHERE 
					   id_analytics = '$id_row_del'");
}

public function add() {
	
	$this->db("INSERT INTO
				$this->table_analytics
				(token, ip, date_activity, device, os,
				browser, activity_score, city, region, isp,
				referer, country, lang,
				latitude, longitude)
				VALUE
				('$this->token_out', '$this->ip_out', '$this->timestamp', '$this->device', '$this->os',
				'$this->browser', 1, '$this->city', '$this->region', '$this->isp',
				'$this->referer', '$this->country', '$this->lang',
				'$this->latitude', '$this->longitude')");

			if($this->mode == 'all')
			{
				$this->send_mail($this->project);
			}
			elseif($this->mode == 'reg' AND $this->token_out !== 0)
			{
				$this->send_mail($this->project);	
			}         
}

public function get_ip_detail($ip) {

	// Get info from api
	if($ip != '127.0.0.1')
	{
		$response = file_get_contents('http://ip-api.com/json/'.$ip.'?fields=status,message,country,regionName,city,lat,lon,as,mobile');

			$ip_array = json_decode($response);
	   
				if($ip_array->status == 'success')
				{
					$data =	[
								'country' => $ip_array->country,
								'region' => $ip_array->regionName,
								'city' => $ip_array->city,
								'isp' => $ip_array->as,
								'latitude' => $ip_array->lat,
								'longitude' => $ip_array->lon
							];
				}
				else
				{
					$data = null;	
				}
	}
	else
	{
		$data = null;	
	}

	   return $data;
}

public function user_agent_parser($user_agent) {
	$browser = new \foroco\BrowserDetection();
		$result = $browser->getAll($user_agent);
			
		$data = [
					'device' => ucfirst($result['device_type']),
					'os' => $result['os_title'],
					'browser' => $result['browser_title']
				];
	return $data;
}

public function userFromId($token) {

	$request = $this->db("SELECT * FROM users WHERE token = '$token'");
		$result = $request->fetch();
	
		return $result['email'];
}

public function getLanguage() {

	$service = new AcceptLanguage();
		$service->process();
	
	return $service->getLanguage(); 
}

}
