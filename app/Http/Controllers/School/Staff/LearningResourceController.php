<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLearningResourceRequest;
use App\Http\Requests\UpdateLearningResourceRequest;
use App\Models\LearningResource;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LearningResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        if (request()->query->count() > 1) {
            $class =  SchoolClass::where('id', request()->class)->where('school_id', getSchool()->id)->first();
            $subject =  Subject::where('id', request()->subject)->where('school_id', getSchool()->id)->first();
            $learningResources = LearningResource::when($class, function ($query, $class) {
                return $query->where('school_class_id', $class->id);
            })
                ->when($subject, function ($query, $subject) {
                    return $query->where('subject_id', $subject->id);
                })
                ->where('school_id', getSchool()->id)
                ->orderBy('title', 'desc')->paginate();
            return view('staff.learning-resources', compact('classes', 'learningResources', 'class', 'subjects', 'subject'));
        }
        $learningResources = LearningResource::where('school_id', getSchool()->id)->orderBy('created_at', 'desc')->paginate(100);
        return view('staff.learning-resources', compact('classes', 'learningResources', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        return view('staff.create_edit_learning_resource', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLearningResourceRequest $request)
    {
        $data = $request->validated();
        try {
            if ($data['type'] == 'text') {
                $dom = new \DomDocument();
                $imgs = [];

                $dom->loadHtml($data['content'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $images = $dom->getElementsByTagName('img');

                foreach ($images as $k => $img) {


                    $imageData = $img->getAttribute('src');

                    list($type, $imageData) = explode(';', $imageData);

                    list(, $imageData)      = explode(',', $imageData);

                    $imageData = base64_decode($imageData);

                    $image_name = "/uploads/" . time() . $k . '.png';

                    $path = public_path() . $image_name;
                    array_push($imgs, $path);

                    file_put_contents($path, $imageData);

                    $img->removeAttribute('src');

                    $img->setAttribute('src', $image_name);
                }

                $content = $dom->saveHTML();
                $data['content'] = $content;
                $data['content_images'] = json_encode($imgs);
            } else {
                $data['content'] = '';

                $data['file'] = $request->hasFile('file') ? $request->file('file')->storePublicly('resources') : null;
            }
            $data['school_id'] = getSchool()->id;
            $learningResources = LearningResource::create($data);
            return redirect()->route('learning-resources.index')->with('message', 'New resource added successfully.');
        } catch (Exception $e) {

            if (Storage::exists($data['file'])) {
                Storage::delete($data['file']);
            }
            if (isset($imgs)) {
                foreach ($imgs as $image) {
                    if (Storage::exists($image)) {
                        Storage::delete($image);
                    }
                }
            }
            dd($e);
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
        $learningResource = LearningResource::where('id', $id)->where('school_id', getSchool()->id)->first();
        // dd($learningResource);
        if (!$learningResource) {
            abort(404);
        }
        return view('staff.show_learning_resource', compact('learningResource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        $learningResource = LearningResource::where('id', $id)->where('school_id', getSchool()->id)->first();
        // dd($learningResource);
        if (!$learningResource) {
            abort(404);
        }
        return view('staff.create_edit_learning_resource', compact('classes', 'subjects', 'learningResource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLearningResourceRequest $request, $id)
    {
        $data = $request->validated();
        $learningResource = LearningResource::where('id', $id)->where('school_id', getSchool()->id)->first();
        if (!$learningResource) {
            abort(404);
        }
        try {

            $oldContentImages = $learningResource->content_images;
            if ($data['type'] == 'text') {

                $dom = new \DomDocument();
                $imgs = [];

                $dom->loadHtml($data['content'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $images = $dom->getElementsByTagName('img');

                foreach ($images as $k => $img) {

                    $imageData = $img->getAttribute('src');
                    if (str_starts_with($imageData, 'htt')) {
                        continue;
                    }
                    list($type, $imageData) = explode(';', $imageData);

                    list(, $imageData)      = explode(',', $imageData);

                    $imageData = base64_decode($imageData);

                    $image_name = "/uploads/" . time() . $k . '.png';

                    $path = public_path() . $image_name;
                    array_push($imgs, $image_name);

                    file_put_contents($path, $imageData);

                    $img->removeAttribute('src');

                    $img->setAttribute('src', $image_name);
                }
                $content = $dom->saveHTML();
                $data['content'] = $content;
                $data['content_images'] = json_encode($imgs);
                // delete old content
                $oldFile = $learningResource->file;
                if (Storage::exists($oldFile))
                    Storage::delete($oldFile);
            } else {

                $oldFile = $learningResource->file;
                if ($request->hasFile('file')) {
                    $data['file'] = $request->hasFile('file') ? $request->file('file')->storePublicly('images') : null;
                }


                if ($request->hasFile('file') and Storage::exists($oldFile))
                    Storage::delete($oldFile);
                $data['content'] = '';
            }
            $oldContentImagesArray = $oldContentImages ? json_decode($oldContentImages) : [];
            foreach ($oldContentImagesArray as $img) {

                if (File::exists(public_path($img))) {
                    File::delete(public_path($img));
                }
            }

            $learningResource->update($data);
            return redirect()->route('learning-resources.index')->with('message', 'Learning resource updated successfully.');
        } catch (Exception $e) {
            if ($request->hasFile('image'))
                Storage::delete($data['image']);
            if (isset($imgs)) {
                foreach ($imgs as $img) {
                    if (File::exists(public_path($img))) {
                        File::delete(public_path($img));
                    }
                }
            }
            return back()->with('error', $e->getMessage());
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
        $learningResource = LearningResource::where('id', $id)->where('school_id', getSchool()->id)->first();
        $oldContentImagesArray = $learningResource->content_images ? json_decode($learningResource->content_images) : [];
        foreach ($oldContentImagesArray as $img) {

            if (File::exists(public_path($img))) {
                File::delete(public_path($img));
            }
        }
        $oldFile = $learningResource->file;
        if (Storage::exists($oldFile))
            Storage::delete($oldFile);
        $learningResource->delete();
        return redirect()->route('learning-resources.index')->with('message', 'Learning resource deleted successfully.');
    }

    public function getDownload($id)
    {
        $learningResource = LearningResource::where('id', $id)->where('school_id', getSchool()->id)->first();

        //PDF file is stored under project/public/download/info.pdf
        $file = storage_path('app/' . $learningResource->file);

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file);
    }
}
