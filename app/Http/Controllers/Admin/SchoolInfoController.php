<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CbtQuestion;
use App\Models\ClassModel;
use App\Models\ExamQuestion;
use App\Models\PromotionHistory;
use App\Models\SchoolInfo;
use App\Models\SessionModel;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SchoolInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolinfo = SchoolInfo::first();
        $sessions = SessionModel::orderBy('session_name', 'ASC')->get();
        return view('admin.pages.schoolinfo', compact('schoolinfo', 'sessions'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id = '')
    {
        // Validate incoming data
        $validatedData = $request->validate([
            // Basic School Info
            'school_name'        => 'required|string|max:255',
            'short_name'         => 'nullable|string|max:100',
            'school_motto'       => 'nullable|string|max:255|unique:school_info,school_motto,' . $id,
            'school_type'        => 'required|in:primary,secondary,combined',
            'address'            => 'nullable|string',
            'city'               => 'nullable|string|max:100',
            'state'              => 'nullable|string|max:100',
            'lga'                => 'nullable|string|max:100',
            'country'            => 'nullable|string|max:100',
            'latitude'           => 'nullable|numeric|between:-90,90',
            'longitude'          => 'nullable|numeric|between:-180,180',
            'year_established'   => 'nullable|digits:4|integer|min:1800|max:' . date('Y'),
            'phone'              => 'nullable|string|max:20',
            'phone_alt'          => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:255',
            'meta_description'   => 'nullable|string',
            'meta_keywords'      => 'nullable|string',
            'facebook'           => 'nullable|url|max:255',
            'youtube'            => 'nullable|url|max:255',
            'whatsapp'           => 'nullable|string|max:100',
            'website'            => 'nullable|url|max:255',
            'google_map_src'     => 'nullable|string',

            //  New Session Fields
            'current_session'       => ['nullable', 'string', 'regex:/^\d{4}\/\d{4}$/', 'max:9'],
            'current_term'          => 'nullable|in:first,second,third',
            'session_start_date'    => 'nullable|date',
            'session_end_date'      => 'nullable|date|after_or_equal:session_start_date',
            'school_opened'         => 'nullable|integer|min:0',
            'next_term_begin_date'  => 'nullable|date|after_or_equal:session_end_date',
        ]);


        $validatedUploads = $request->validate([
            'logo_path'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon_path'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'darklogo_path'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Retrieve the first SchoolInfo or find by provided id if necessary
        $SchoolInfo = empty($id) ? SchoolInfo::first() : SchoolInfo::findOrFail($id);

        // Handle file uploads if applicable
        if ($request->hasFile('logo_path')) {
            $logo = $request->file('logo_path');
            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $logo->store('front/images', 'public');

            // Get the filename (this will include the folder path)
            $filename = 'logo.png';

            // Rename the file to 'logo.png'
            Storage::disk('public')->move($path, 'front/images/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['logo_path'] = 'front/images/' . $filename;
        }


        // Store the favicon in the 'public/front/images' directory and name it 'favicon.png'
        if ($request->hasFile('favicon_path')) {
            $favicon = $request->file('favicon_path');
            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $favicon->store('front/images', 'public');

            // Get the filename (this will include the folder path)
            $filename = 'favicon.png';

            // Rename the file to 'favicon.png'
            Storage::disk('public')->move($path, 'front/images/' . $filename);

            // Store the relative path (without 'public/' prefix)
            $validatedData['favicon_path'] = 'front/images/' . $filename;
        }

        // Store the dark logo in the 'public/front/images' directory and name it 'white-logo.png'
        if ($request->hasFile('darklogo_path')) {
            $darklogo = $request->file('darklogo_path');
            // Store the file temporarily in the storage folder (you can choose any temporary name)
            $path = $darklogo->store('front/images', 'public');

            // Get the filename (this will include the folder path)
            $filename = 'white-logo.png';

            // Rename the file to 'white-logo.png'
            Storage::disk('public')->move($path, 'front/images/' . $filename);
        }


        Artisan::call('cache:clear');

        // Update the SchoolInfo record with validated data
        $SchoolInfo->update($validatedData);

        return redirect()->back()->with('success', 'School information updated successfully.');
    }

    public function indexAdvanced()
    {
        $schoolinfo = SchoolInfo::first();
        return view('admin.pages.advanced.index', compact('schoolinfo'));
    }

    public function promote(Request $request)
    {

        $schoolInfo = SchoolInfo::first();
        $option = $request->promotion_option;

        try {
            DB::beginTransaction();

            // Common promotion logic
            $students = Student::where('status', 'active')->get();

            foreach ($students as $student) {
                $currentClass = ClassModel::find($student->class_id);

                if (!$currentClass) {
                    throw new \Exception("Class not found for student ID: {$student->id}");
                }

                // Find the next class by rank
                $nextClass = ClassModel::where('rank', $currentClass->rank + 1)
                    ->where('status', 'active')
                    ->first();

                if ($nextClass) {
                    // Promote to next class
                    $student->class_id = $nextClass->id;
                    $student->save();

                    PromotionHistory::create([
                        'student_id' => $student->id,
                        'previous_class_id' => $currentClass->id,
                        'current_class_id' => $nextClass->id,
                        'promotion_date' => now(),
                    ]);
                } else {
                    // Convert student to array, add graduation_session
                    $studentData = $student->toArray();

                    // Fix datetime format for MySQL
                    $studentData['created_at'] = $student->created_at->format('Y-m-d H:i:s');
                    $studentData['updated_at'] = now()->format('Y-m-d H:i:s');
                    $studentData['session'] = $schoolInfo->current_session;

                    // Insert into graduated_students
                    DB::table('graduated_students')->insert($studentData);

                    // Delete from students table
                    DB::table('students')->where('id', $student->id)->delete();
                }
            }

            if ($option == 'full_promotion') {
                // Delete records from specified tables
                DB::table('student_scores')->delete();
                DB::table('student_results')->delete();
                DB::table('exam_questions')->delete();
                DB::table('cbt_questions')->delete();


                // Delete files in the exam uploads directory
                $path = 'front/images/examuploads';

                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->deleteDirectory($path);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Students promoted successfully, and all specified data and files deleted.',
                ]);
            } elseif ($option == 'partial_promotion') {
                // Delete only student scores and results
                DB::table('student_scores')->delete();
                DB::table('student_results')->delete();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Students promoted successfully, and student scores and results deleted.',
                ]);
            } elseif ($option == 'export_promotion') {
                // Export tables as SQL
                $tables = [
                    'student_scores' => StudentScore::class,
                    'student_results' => StudentResult::class,
                    'exam_questions' => ExamQuestion::class,
                    'cbt_questions' => CbtQuestion::class,
                ];

                $timestamp = now()->format('Ymd_His');
                $exportDisk = Storage::disk('public');

                foreach ($tables as $tableName => $model) {
                    // Get table structure
                    $createTable = DB::select("SHOW CREATE TABLE {$tableName}");
                    $createSql = $createTable[0]->{'Create Table'} . ";\n\n";

                    // Get table data
                    $records = DB::table($tableName)->get();
                    $insertSql = '';

                    if ($records->isNotEmpty()) {
                        $columns = Schema::getColumnListing($tableName);
                        $columnList = implode('`, `', $columns);
                        $insertPrefix = "INSERT INTO `{$tableName}` (`{$columnList}`) VALUES ";

                        $values = [];
                        foreach ($records as $record) {
                            $recordValues = array_map(function ($value) {
                                if (is_null($value)) {
                                    return 'NULL';
                                }
                                return "'" . Str::replace("'", "\\'", $value) . "'";
                            }, (array)$record);
                            $values[] = '(' . implode(', ', $recordValues) . ')';
                        }

                        $insertSql = $insertPrefix . implode(",\n", $values) . ";\n\n";
                    }

                    // Combine and save SQL
                    $sqlContent = "-- Export of table {$tableName} at {$timestamp}\n\n" . $createSql . $insertSql;
                    $filename = "{$tableName}_{$timestamp}.sql";
                    $exportDisk->put('exports/' . $filename, $sqlContent);
                }

                // Delete records from specified tables
                DB::table('student_scores')->delete();
                DB::table('student_results')->delete();
                DB::table('exam_questions')->delete();
                DB::table('cbt_questions')->delete();


                // Delete files in the exam uploads directory
                $path = 'public/front/images/examuploads';
                if (Storage::exists($path)) {
                    Storage::deleteDirectory($path);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Students promoted successfully, data exported as SQL files, and active data deleted.',
                ]);
            }

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Invalid promotion option selected.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }

    public function deleteStudentPromotion(Request $request, $promotionId)
    {
        // Validate request data
        $request->validate([
            'previous_id' => 'required|exists:classes,id',
            'student_id' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            // Find the promotion record
            $promotion = PromotionHistory::findOrFail($promotionId);

            // Verify the promotion matches the request
            if ($promotion->student_id != $request->student_id || $promotion->previous_class_id != $request->previous_id) {
                throw new \Exception('Invalid promotion data provided.');
            }

            // Check if student exists in students or graduated_students
            $student = Student::find($promotion->student_id);
            $graduatedStudent = $student ? null : DB::table('graduated_students')->where('id', $promotion->student_id)->first();

            if (!$student && !$graduatedStudent) {
                throw new \Exception('Student not found in students or graduated_students.');
            }

            // Verify the previous class exists and is active
            $previousClass = ClassModel::where('id', $promotion->previous_class_id)
                ->where('status', 'active')
                ->first();

            if (!$previousClass) {
                throw new \Exception('Previous class is not active or does not exist.');
            }

            if ($student) {
                // Student is in students table; update class_id
                $student->class_id = $promotion->previous_class_id;
                $student->status = 'active'; // Ensure student is active
                $student->save();
            } else {
                // Student is in graduated_students; restore to students
                $studentData = (array)$graduatedStudent;
                $studentData['created_at'] = now()->format('Y-m-d H:i:s');
                $studentData['updated_at'] = now()->format('Y-m-d H:i:s');
                $studentData['class_id'] = $promotion->previous_class_id;
                $studentData['status'] = 'active';

                // Insert into students
                DB::table('students')->insert($studentData);

                // Delete from graduated_students
                DB::table('graduated_students')->where('id', $promotion->student_id)->delete();
            }

            // Log the reversion in promotion_history
            PromotionHistory::create([
                'student_id' => $promotion->student_id,
                'previous_class_id' => $promotion->current_class_id, // Current class becomes previous
                'current_class_id' => $promotion->previous_class_id, // Revert to previous class
                'promotion_date' => now(),
            ]);

            // Delete the original promotion record
            $promotion->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Student promotion reverted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('success', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function deletePromotion($promotionId)
    {

        // Find the promotion record
        PromotionHistory::findOrFail($promotionId)->delete();


        return redirect()->back()->with('success', 'Student promotion deleted successfully.');
    }

    public function addStudentPromotion(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Find the student
            $student = Student::findOrFail($id);
            if ($student->status !== 'active') {
                throw new \Exception('Only active students can be promoted.');
            }

            // Find the current class
            $currentClass = ClassModel::findOrFail($student->class_id);

            // Find the next class by rank
            $nextClass = ClassModel::where('rank', $currentClass->rank + 1)
                ->where('status', 'active')
                ->first();

            $schoolInfo = SchoolInfo::first();

            if ($nextClass) {
                // Promote to next class
                $student->class_id = $nextClass->id;
                $student->save();

                // Log promotion in promotion_history
                PromotionHistory::create([
                    'student_id' => $student->id,
                    'previous_class_id' => $currentClass->id,
                    'current_class_id' => $nextClass->id,
                    'promotion_date' => now(),
                ]);
            } else {
                // Move to graduated_students
                $studentData = $student->toArray();
                $studentData['created_at'] = $student->created_at->format('Y-m-d H:i:s');
                $studentData['updated_at'] = now()->format('Y-m-d H:i:s');
                $studentData['session'] = $schoolInfo->current_session;

                // Insert into graduated_students
                DB::table('graduated_students')->insert($studentData);

                // Log promotion to graduated status
                PromotionHistory::create([
                    'student_id' => $student->id,
                    'previous_class_id' => $currentClass->id,
                    'current_class_id' => null,
                    'promotion_date' => now(),
                ]);

                // Delete from students
                $student->delete();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Student promoted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('success', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function addStudentDemotion(Request $request, $id)
    {


        try {
            DB::beginTransaction();

            // Check if student exists in students or graduated_students
            $student = Student::find($id);
            $graduatedStudent = $student ? null : DB::table('graduated_students')->where('id', $id)->first();

            if (!$student && !$graduatedStudent) {
                throw new \Exception('Student not found in students or graduated_students.');
            }

            if ($student) {
                // Student is in students table
                $currentClass = ClassModel::findOrFail($student->class_id);

                // Find the previous class by rank
                $previousClass = ClassModel::where('rank', $currentClass->rank - 1)
                    ->where('status', 'active')
                    ->first();

                if (!$previousClass) {
                    throw new \Exception('No active previous class available for demotion.');
                }

                // Demote to previous class
                $student->class_id = $previousClass->id;
                $student->status = 'active';
                $student->save();

                // Log demotion in promotion_history
                PromotionHistory::create([
                    'student_id' => $student->id,
                    'previous_class_id' => $currentClass->id,
                    'current_class_id' => $previousClass->id,
                    'promotion_date' => now(),
                ]);
            } else {
                // Student is in graduated_students; restore to students
                $studentData = (array)$graduatedStudent;
                $studentData['created_at'] = now()->format('Y-m-d H:i:s');
                $studentData['updated_at'] = now()->format('Y-m-d H:i:s');
                $studentData['status'] = 'active';

                // Find the previous class (last class before graduation)
                $lastPromotion = PromotionHistory::where('student_id', $id)
                    ->whereNotNull('previous_class_id')
                    ->orderBy('promotion_date', 'desc')
                    ->first();

                if (!$lastPromotion) {
                    throw new \Exception('No promotion history found for demotion.');
                }

                $previousClass = ClassModel::where('id', $lastPromotion->previous_class_id)
                    ->where('status', 'active')
                    ->first();

                if (!$previousClass) {
                    throw new \Exception('Previous class is not active or does not exist.');
                }

                $studentData['class_id'] = $previousClass->id;

                // Insert into students
                DB::table('students')->insert($studentData);

                // Log demotion in promotion_history
                PromotionHistory::create([
                    'student_id' => $id,
                    'previous_class_id' => null, // Graduated status
                    'current_class_id' => $previousClass->id,
                    'promotion_date' => now(),
                ]);

                // Delete from graduated_students
                DB::table('graduated_students')->where('id', $id)->delete();
            }

            DB::commit();

            return redirect()->back()->with('success', 'Student demoted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('success', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function deleteQuestions(Request $request)
    {

        // Check if at least one option is selected
        if (!$request->has('delete_cbt_questions')  && !$request->has('delete_exam_questions')) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one type of questions to delete.',
            ]);
        }

        try {
            DB::beginTransaction();

            $deleted = false;

            // Delete First Test questions from cbt_questions
            if ($request->boolean('delete_cbt_questions')) {
                // Delete cbt_questions
                DB::table('cbt_questions')->delete();
                $deleted = true;
            }

            // Delete Exam questions from exam_questions
            if ($request->boolean('delete_exam_questions')) {
                DB::table('exam_questions')->delete();
                $deleted = true;
            }

            // Delete files in the exam uploads directory if any questions were deleted
            if ($deleted) {
                $path = 'front/images/examUploads';
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->deleteDirectory($path);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Selected questions deleted successfully' . ($deleted ? ' and associated files removed.' : '.'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }

    public function deleteResults(Request $request)
    {
        // Check if at least one option is selected
        if (!$request->has('delete_computed_results') && !$request->has('delete_student_scores')) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one type of data to delete.',
            ]);
        }

        try {
            DB::beginTransaction();

            $deleted = false;

            // Delete computed results from student_results
            if ($request->boolean('delete_computed_results')) {
                DB::table('student_results')->delete();
                $deleted = true;
            }

            // Delete all student scores from student_scores
            if ($request->boolean('delete_student_scores')) {
                DB::table('student_scores')->delete();
                $deleted = true;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Selected data deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }
}
