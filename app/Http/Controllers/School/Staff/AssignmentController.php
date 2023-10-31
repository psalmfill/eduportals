<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Assignment;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();


        if ($request->getMethod() == 'POST' || $request->class) {
            $class_id = $request->class;
            $section_id = $request->section;
            $session_id = $request->session;

            $subject = Subject::find($request->subject);
            $currentClass = SchoolClass::find($class_id);
            $currentSection = Section::find($section_id);
            if (!(auth()->user() || (user()->subjects != null and user()->subjects->contains($subject)))) {
                return back()->with('error', 'Unauthorized access');
            }
            $sections =  $currentClass->sections;
            $subjects = $currentSection
                ->subjects()
                ->wherePivot('school_class_id', $class_id)->get();

            $assignments = Assignment::where('school_id', getSchool()->id)
                ->where('school_class_id', $class_id)
                ->where('section_id', $section_id)
                ->paginate();
            return view('staff.assignments', compact(
                'assignments',
                'classes',
                'sections',
                'subjects',
                'currentClass',
                'currentSection',
                'subject',
            ));
        }

        $assignments = Assignment::where('school_id', getSchool()->id)->paginate();
        return view('staff.assignments', compact('classes', 'assignments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        return view('staff.create_edit_assignment', compact('classes',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAssignmentRequest $request)
    {
        $data = $request->validated();
        $data['school_id'] = getSchool()->id;
        $data['academic_session_id'] = getSettings()->current_session_id;
        $data['term_id'] = getSettings()->current_term_id;
        $data['staffable_type'] = get_class(user());
        $data['staffable_id'] = user()->id;
        try {
            // work on the content
            $dom = new \DomDocument();
            $contentImgs = [];

            $dom->loadHtml($data['content'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {


                $imageData = $img->getAttribute('src');

                list($type, $imageData) = explode(';', $imageData);

                list(, $imageData)      = explode(',', $imageData);

                $imageData = base64_decode($imageData);

                $image_name = "/uploads/" . time() . $k . '.png';

                $path = public_path() . $image_name;
                array_push($contentImgs, $path);

                file_put_contents($path, $imageData);

                $img->removeAttribute('src');

                $img->setAttribute('src', $image_name);
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
            $data['content_images'] = json_encode($contentImgs);

            // work on the resource images
            $dom = new \DomDocument();
            $resourcesImgs = [];

            $dom->loadHtml($data['resources'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {


                $imageData = $img->getAttribute('src');

                list($type, $imageData) = explode(';', $imageData);

                list(, $imageData)      = explode(',', $imageData);

                $imageData = base64_decode($imageData);

                $image_name = "/uploads/" . time() . $k . '.png';

                $path = public_path() . $image_name;
                array_push($resourcesImgs, $path);

                file_put_contents($path, $imageData);

                $img->removeAttribute('src');

                $img->setAttribute('src', $image_name);
            }
            $resources = $dom->saveHTML();
            $data['resources'] = $resources;
            $data['resources_images'] = json_encode($resourcesImgs);

            $data['school_id'] = getSchool()->id;
            $assignment = Assignment::create($data);
            return redirect()->route('assignments.index')->with('message', 'New assignment setup successfully.');
        } catch (Exception $e) {
            if (isset($contentImgs)) {
                foreach ($contentImgs as $image) {
                    if (Storage::exists($image)) {
                        Storage::delete($image);
                    }
                }
            }
            if (isset($resourcesImgs)) {
                foreach ($resourcesImgs as $image) {
                    if (Storage::exists($image)) {
                        Storage::delete($image);
                    }
                }
            }
            return back()->with('error', 'failed creating source');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::where('id', $id)->where('school_id', getSchool()->id)->first();

        if (!$assignment) {
            abort(404);
        }
        return view('staff.show_assignment', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $assignment = Assignment::where('id', $id)->where('school_id', getSchool()->id)->first();


        return view('staff.create_edit_assignment', compact('classes', 'assignment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssignmentRequest $request, $id)
    {
        $data = $request->validated();
        $assignment = Assignment::where('id', $id)->where('school_id', getSchool()->id)->first();

        if (!$assignment) {
            abort(404);
        }
        $data['school_id'] = getSchool()->id;
        $data['academic_session_id'] = getSettings()->current_session_id;
        $data['term_id'] = getSettings()->current_term_id;
        $data['staffable_type'] = get_class(user());
        $data['staffable_id'] = user()->id;
        try {
            // work on the content
            $oldContentImages = $assignment->content_images;
            $oldResourcesImages = $assignment->resources_images;

            $dom = new \DomDocument();
            $contentImgs = [];

            $dom->loadHtml($data['content'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {


                $imageData = $img->getAttribute('src');

                list($type, $imageData) = explode(';', $imageData);

                list(, $imageData)      = explode(',', $imageData);

                $imageData = base64_decode($imageData);

                $image_name = "/uploads/" . time() . $k . '.png';

                $path = public_path() . $image_name;
                array_push($contentImgs, $path);

                file_put_contents($path, $imageData);

                $img->removeAttribute('src');

                $img->setAttribute('src', $image_name);
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
            $data['content_images'] = json_encode($contentImgs);

            // work on the resource images
            $dom = new \DomDocument();
            $resourcesImgs = [];

            $dom->loadHtml($data['resources'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $k => $img) {


                $imageData = $img->getAttribute('src');

                list($type, $imageData) = explode(';', $imageData);

                list(, $imageData)      = explode(',', $imageData);

                $imageData = base64_decode($imageData);

                $image_name = "/uploads/" . time() . $k . '.png';

                $path = public_path() . $image_name;
                array_push($resourcesImgs, $path);

                file_put_contents($path, $imageData);

                $img->removeAttribute('src');

                $img->setAttribute('src', $image_name);
            }
            $resources = $dom->saveHTML();
            $data['resources'] = $resources;
            $data['resources_images'] = json_encode($resourcesImgs);

            $data['school_id'] = getSchool()->id;
            $oldResourcesImages = $oldResourcesImages ? json_decode($oldResourcesImages) : [];
            foreach ($oldResourcesImages as $img) {

                if (File::exists(public_path($img))) {
                    File::delete(public_path($img));
                }
            }
            $oldContentImagesArray = $oldContentImages ? json_decode($oldContentImages) : [];
            foreach ($oldContentImagesArray as $img) {

                if (File::exists(public_path($img))) {
                    File::delete(public_path($img));
                }
            }
            $assignment->update($data);
            return redirect()->route('assignments.index')->with('message', 'New assignment setup successfully.');
        } catch (Exception $e) {
            if (isset($contentImgs)) {
                foreach ($contentImgs as $image) {
                    if (Storage::exists($image)) {
                        Storage::delete($image);
                    }
                }
            }
            if (isset($resourcesImgs)) {
                foreach ($resourcesImgs as $image) {
                    if (Storage::exists($image)) {
                        Storage::delete($image);
                    }
                }
            }
            return back()->with('error', 'failed creating source');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignment = Assignment::where('id', $id)->where('school_id', getSchool()->id)->first();

        if (!$assignment) {
            abort(404);
        }
        $oldResourcesImages = $assignment->resources_images ? json_decode($assignment->resources_images) : [];
        foreach ($oldResourcesImages as $img) {

            if (File::exists(public_path($img))) {
                File::delete(public_path($img));
            }
        }
        $oldContentImagesArray = $assignment->content_images ? json_decode($assignment->content_images) : [];
        foreach ($oldContentImagesArray as $img) {

            if (File::exists(public_path($img))) {
                File::delete(public_path($img));
            }
        }
        $assignment->delete();
        return redirect()->route('assignments.index')->with('message', 'Assignment deleted successfully.');
    }
}
