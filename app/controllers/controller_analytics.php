<?php

namespace Projects\Analytics\App\Controllers;

use \Repo\View;
use \Projects\Analytics\App\Models\Model_View;
use \Projects\Auth\App\Models\Model_Auth;
use \Projects\Analytics\App\Models\Model_Migration;


class Controller_Analytics extends View {

public function main() {
		
	$modelAuth = new Model_Auth();
		$modelView = new Model_View();
	
		if($modelAuth->check())
		{
			$data = $modelView->viewMain();
				$this->view('analytics', 'content_auth.php', ['projectsList' => $data]);
		} 
		else
		{
			$data = $modelView->viewMain();
				$this->view('analytics', 'content_notauth.php', ['projectsList' => $data]);
		}
}

public function getAnalytics($project, $period) {

	$modelView = new Model_View();
		$modelView->getAnalytics($project, $period);
}

public function migration() {
	$Model_Migration = new Model_Migration();
		$Model_Migration->migration();
}

}
