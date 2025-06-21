<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmission;
use App\Mail\QuoteSubmission;
use App\Models\Admin;
use App\Models\ClassModel;
use App\Models\Level;
use App\Models\SchoolInfo;
use App\Models\SiteInfo;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

        /**
     * Shared data for all front pages
     */
    private function getPageData(): array
    {
        return [
            'schoolinfo'    => SchoolInfo::first(),
            'totalStudents' => Student::count(),
            'staffs'        => Staff::paginate(12),
            'levels'        => Level::all(),
            'classes'       => ClassModel::all(),
        ];
    }


    public function index()
    {

        return view('front.pages.home', $this->getPageData());
    }

    public function contact()
    {
        $schoolinfo = SchoolInfo::first(); // Gets the first row of school info


        return view('front.pages.contact', compact(
            'schoolinfo'));
    }

    public function contactSend(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'mobile_number' => 'required|regex:/^(\+?\d{1,4}[\s-]?)?(\(?\d{1,4}\)?[\s-]?\d{1,4}[\s-]?\d{1,4}[\s-]?\d{1,9})$/',
            'email' => 'required|email|max:255',
            'interested_in' => 'required|string',
            'your_location' => 'required|string|max:255',
            'skype_whatsapp_no' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'agree' => 'accepted', // Ensures the checkbox is checked
        ]);

        // If validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Access SiteInfo model directly in the method
        $siteinfo = SiteInfo::first();

        $data = [
            'fullname' => $request->fullname,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'interested_in' => $request->interested_in,
            'your_location' => $request->your_location,
            'skype_whatsapp_no' => $request->skype_whatsapp_no,
            'description' => $request->description,
        ];

        //Admin Email
        $adminEmail = Admin::find(1)->email;

        // Send the email to the recipient (you can add dynamic email addresses or use a fixed one)
        //  Mail::to($adminEmail)->send(new ContactFormSubmission($data));

        // Redirect back with a success message
        return back()->with('success', 'Your message has been sent successfully!');
    }


  public function about()
    {
        return view('front.pages.about', $this->getPageData());
    }

    public function admission()
    {
        return view('front.pages.admission', $this->getPageData());
    }

    public function classes()
    {
        return view('front.pages.classes', $this->getPageData());
    }

    public function faqs()
    {
        return view('front.pages.faqs', $this->getPageData());
    }

    public function gallery()
    {

        // $galleryItems = collect([
        //     (object)[
        //         'title' => '',
        //         'image' => '',
        //         'categories' => '',
        //     ],
        //     (object)[
        //         'title' => 'Cultural Day Performance',
        //         'image' => 'gallery/cultural_day.jpg',
        //         'categories' => 'cultural',
        //     ],
        //     (object)[
        //         'title' => 'Abdullahi Musa at Football Match',
        //         'image' => 'gallery/football.jpg',
        //         'categories' => 'students sports',
        //     ],
        //     (object)[
        //         'title' => 'Funmilayo in Library',
        //         'image' => 'gallery/library.jpg',
        //         'categories' => 'students facilities',
        //     ],
        //     (object)[
        //         'title' => 'Emeka Nwosu in Debate Club',
        //         'image' => 'gallery/debate.jpg',
        //         'categories' => 'students',
        //     ],
        //     (object)[
        //         'title' => 'Aisha Bello at Annual Sports Day',
        //         'image' => 'gallery/sports_day.jpg',
        //         'categories' => 'sports',
        //     ],
        //     (object)[
        //         'title' => 'Tunde Olatunji in Computer Lab',
        //         'image' => 'gallery/computer_lab.jpg',
        //         'categories' => 'students facilities',
        //     ],
        //     (object)[
        //         'title' => 'Yoruba Cultural Festival',
        //         'image' => 'gallery/yoruba_festival.jpg',
        //         'categories' => 'cultural',
        //     ],
        //     (object)[
        //         'title' => 'Students in Classroom',
        //         'image' => 'gallery/classroom.jpg',
        //         'categories' => 'students',
        //     ],
        // ])->paginate(6);
        $galleryItems = [];


        return view('front.pages.gallery', $this->getPageData(), compact('galleryItems') );
    }

    public function specialClass()
    {
        return view('front.pages.special-class', $this->getPageData());
    }

    public function teachers()
    {
        return view('front.pages.teachers', $this->getPageData());
    }

    public function testimonials()
    {
        return view('front.pages.testimonials', $this->getPageData());
    }

}
