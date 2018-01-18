<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
	    /* Insert activities */

        $activities = [
            [1, 48, 'Schulung/ Workshop', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [2, 49, 'interne Tests', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [3, 34, 'Kundensupport', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [4, 26, 'Administration', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [5, 36, 'Software Entwicklung', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [6, 416443, 'Koordination', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [7, 416444, 'ePub-Produktion', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [8, 416445, 'Präsentation/ Akquise', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [9, 416446, 'Besprechung', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
            [10, 416447, 'Konzeption/ Strategie', '2016-04-28 12:54:02', '2016-04-28 12:54:02', NULL],
        ];

		foreach ($activities as $activity) {
		    list($id, $np_id, $name, $created_at, $updated_at, $deleted_at) = $activity;

			$activity = new Activity;
			$activity->id = $id;
			$activity->np_id = $np_id;
			$activity->name = $name;
			$activity->created_at = $created_at;
			$activity->updated_at = $updated_at;
			$activity->deleted_at = $deleted_at;
			$activity->timestamps = false;
			$activity->save();
		}

		/* Set new auto-increment value */

        DB::statement('ALTER TABLE activities AUTO_INCREMENT = ' . (count($activities) + 1) . ';');
	}
}
