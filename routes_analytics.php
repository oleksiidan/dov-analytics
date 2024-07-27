
<?php

use \Projects\Analytics\App\Controllers\Controller_Analytics;
use \Projects\Analytics\App\Models\Model_Analytics_Count;

Flight::route('GET /analytics', function() {

	// Analytics
	$objCount = new Model_Analytics_Count('analytics', 'all');
		$objCount->count();

	$Controller_Analytics = new Controller_Analytics();
		$Controller_Analytics->main();
});

Flight::route('POST /analytics', function() {

	// Analytics
	$objCount = new Model_Analytics_Count('analytics', 'all');
		$objCount->count();

	$period = Flight::request()->data->period;
		$project = Flight::request()->data->project;

	$objController_Analytics = new Controller_Analytics();

		if(isset($period)) {
			$objController_Analytics->getAnalytics($project, $period);
		}
});

Flight::route('GET /analytics/migration', function() {

	$Controller_Analytics = new Controller_Analytics();	
		$Controller_Analytics->migration();
});