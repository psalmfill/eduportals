<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CBTController extends Controller
{
    public function index()
    {
        return view('staff.examinations.cbt.index');
    }

    public function subjects()
    {
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        return view('staff.examinations.cbt.subjects', compact('subjects'));
    }

    public function manageQuestions($id)
    {
        $questions = Question::where('subject_id', $id)->get();
        $subject = Subject::findOrFail($id);
        return view('staff.examinations.cbt.questions', compact('questions', 'subject'));
    }

    public function editQuestion($id, $question_id)
    {
        $questions = Question::where('subject_id', $id)->get();
        $question = Question::findOrFail($question_id);
        $subject = Subject::findOrFail($id);
        return view('staff.examinations.cbt.questions', compact('questions', 'subject', 'question'));
    }

    public function storeQuestion(Request $request, $id)
    {

        $request->validate([
            'content' => 'required',
            'mark' => 'required',
            'options' => 'required|array|min:2',
            'options.*.content' => 'required|distinct'
        ]);

        try {

            DB::beginTransaction();
            $question = Question::create([
                'content' => $request->get('content'),
                'mark' => $request->get('mark'),
                'subject_id' => $id,
                'school_id' => getSchool()->id
            ]);

            foreach ($request->options as $option) {
                $question->options()->create([
                    'content' => $option['content'],
                    'is_correct' => isset($option['is_correct']) ? 1 : 0
                ]);
            }
            DB::commit();
            return redirect()->back()->with('message', 'New Question added');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add New Question');
        }
    }

    public function updateQuestion(Request $request, $id, $question_id)
    {

        $request->validate([
            'content' => 'required',
            'mark' => 'required',
            'options' => 'required|array|min:2',
            'options.*.content' => 'required|distinct'
        ]);

        // dd($request->all());
        try {

            DB::beginTransaction();
            $question = Question::findOrFail($question_id);
            $question->update([
                'content' => $request->content,
                'mark' => $request->mark,
            ]);
            $options_ids = $question->options()->pluck('id');

            foreach ($request->options as $k => $option) {
                if ($options_ids->contains($k)) {
                    QuestionOption::find($k)->update([
                        'content' => $option['content'],
                        'is_correct' => isset($option['is_correct']) ? 1 : 0
                    ]);
                } else {
                    $question->options()->create([
                        'content' => $option['content'],
                        'is_correct' => isset($option['is_correct']) ? 1 : 0
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('message', 'Question updated');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add update Question');
        }
    }

    public function deleteOption($id)
    {
        $option = QuestionOption::findOrFail($id);
        if ($option->delete()) {
            return redirect()->back()->with('message', 'Option deleted');
        }
        return redirect()->back()->with('message', 'Fail to delete option');
    }
}
