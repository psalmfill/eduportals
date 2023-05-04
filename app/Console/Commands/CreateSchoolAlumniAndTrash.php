<?php

namespace App\Console\Commands;

use App\Http\Controllers\School\Staff\SchoolClassesController;
use App\Models\School;
use Illuminate\Console\Command;

class CreateSchoolAlumniAndTrash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alumni_and_trash_class:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate school trash and alumni';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $schoolClassesController = app(SchoolClassesController::class);
        $schools = School::all();
        foreach ($schools as $school)
        {
            $schoolClassesController->createAlumniAndTrashClasses($school);
        }
    }
}
