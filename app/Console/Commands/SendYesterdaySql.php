<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Worklog;

class SendYesterdaySql extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sendsql:yesterday';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send yesterdays SQL commands via mail';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$worklogs = Worklog::yesterday()->get();
		
		foreach ($worklogs as $worklog) {
			$sql = $worklog->toNpSql();
			$duration = $worklog->duration();
			$this->info($duration);
		}
	}
}
