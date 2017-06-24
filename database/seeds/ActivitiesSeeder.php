<?php

use Illuminate\Database\Seeder;
use App\Activity;

class ActivitiesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$activities = [
			48 => 'Schulung/ Workshop',	
			49 => 'interne Tests',	
			34 => 'Kundensupport',	
			26 => 'Administration',	
			36 => 'Software Entwicklung',	
			416443 => 'Koordination',	
			416444 => 'ePub-Produktion',	
			416445 => 'Präsentation/ Akquise',	
			416446 => 'Besprechung',	
			416447 => 'Konzeption/ Strategie',	
		];
		
		foreach ($activities as $npId => $title) {
			$activity = new Activity;
			$activity->np_id = $npId;
			$activity->name = $title;
			$activity->save();
		}
	}
}
