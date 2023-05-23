<?php

use App\Models\GeneralSetting;
use App\Models\School;

if (!function_exists('user')) {
    function user()
    {

        if (auth()->guard('student')->user()) {
            return auth()->guard('student')->user();
        }

        if (auth()->guard('staff')->user()) {
            return auth()->guard('staff')->user();
        }
        return auth()->user();
    }
}

if (!function_exists('ordinalSuffix')) {
    function ordinalSuffix($number, $ss = 0)
    {

        /*** check for 11, 12, 13 ***/
        if ($number % 100 > 10 && $number % 100 < 14) {
            $os = 'th';
        }
        /*** check if number is zero ***/
        elseif ($number == 0) {
            $os = '';
        } else {
            /*** get the last digit ***/
            $last = substr($number, -1, 1);

            switch ($last) {
                case "1":
                    $os = 'st';
                    break;

                case "2":
                    $os = 'nd';
                    break;

                case "3":
                    $os = 'rd';
                    break;

                default:
                    $os = 'th';
            }
        }

        /*** add super script ***/
        $os = $ss == 0 ? $os : '<sup>' . $os . '</sup>';

        /*** return ***/
        return $number . $os;
    }

    if (!function_exists('getSchool')) {
        function getSchool()
        {
            $school = session()->get('school') ? session()->get('school')[0] : null;
            if (!$school && request()->route()) {
                $school = School::where('id', request()->route()->school_id)->active()->first();
                session()->push('school', $school);
            }
            //if school is still not found, extra from the url;
            if (!$school) {
                $domain = explode('.', request()->getHost())[0];
                $school = School::where('code', $domain)->active()->first();
            }

            if (!$school) {
                abort(404);
            }

            return $school;
        }
    }
    if (!function_exists('getSettings')) {
        function getSettings()
        {

            $settings =  GeneralSetting::where('school_id', getSchool()->id)->first();

            return $settings;
        }
    }

    if (!function_exists('getClassPosition')) {
        function getClassPosition(
            $data,
            $student_id
        ) {

            $allMarkStoreFromStudents = $data->where('not_offered', 0);
            $studentIds = $allMarkStoreFromStudents->pluck('student_id')->unique();
            $scores = $studentIds->map(function ($e) use ($allMarkStoreFromStudents) {
                $subject_count =  $allMarkStoreFromStudents->where('student_id', $e)->unique('subject_id')->count();
                $score = $allMarkStoreFromStudents->where('student_id', $e)->sum('score');
                return [
                    'student_id' => $e, 'score' => $score,
                    'subject_count' => $subject_count,
                    'student_average' => '' . $score / $subject_count
                ];
            })->sortByDesc('student_average');
            // $position = $scores->pluck('student_id')->search($student_id) + 1;
            $scoresGroup = $scores->groupBy('student_average');
            $position = $scoresGroup->count();
            $newGroup = [];
            // remove the grouping score
            foreach ($scoresGroup as $group) {
                $newGroup[] = $group;
            }
            foreach ($newGroup as $key => $value) {
                if (strval(collect($value)->pluck('student_id')->search($student_id)) != '') {
                    $position = $key + 1;
                }
            }

            return ordinalSuffix($position, 1);
        }
    }

    if (!function_exists('getSubjectPosition')) {
        function getSubjectPosition(
            $data,
            $student_id,
            $subject_id
        ) {
            $allMarkStoreFromStudents = $data->where('not_offered', 0)->where('subject_id', $subject_id);
            $studentIds = $allMarkStoreFromStudents->pluck('student_id')->unique();
            $scores = $studentIds->map(function ($e) use ($allMarkStoreFromStudents) {
                $subject_count =  $allMarkStoreFromStudents->where('student_id', $e)->unique('subject_id')->count();
                $score = $allMarkStoreFromStudents->where('student_id', $e)->sum('score');
                return [
                    'student_id' => $e, 'score' => $score,
                    'subject_count' => $subject_count,
                    'student_average' => '' . $score / $subject_count
                ];
            })->sortByDesc('student_average');
            // $position = $scores->pluck('student_id')->search($student_id) + 1;
            $scoresGroup = $scores->groupBy('student_average');
            $position = $scoresGroup->count();
            $newGroup = [];
            // remove the grouping score
            foreach ($scoresGroup as $group) {
                $newGroup[] = $group;
            }
            foreach ($newGroup as $key => $value) {
                if (strval(collect($value)->pluck('student_id')->search($student_id)) != '') {
                    $position = $key + 1;
                }
            }

            return ordinalSuffix($position, 1);
        }
    }
}
