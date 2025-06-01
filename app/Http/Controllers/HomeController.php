<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmission;
use App\Mail\QuoteSubmission;
use App\Models\Admin;
use App\Models\SiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

global $siteinfo;
$siteinfo = SiteInfo::first();

class HomeController extends Controller
{
    public function contact()
    {
        // Access SiteInfo model directly in the method
        $siteinfo = SiteInfo::first();
       // return view('front.pages.contact', compact('siteinfo'));
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
        // Access SiteInfo model directly in the method
        $siteinfo = SiteInfo::first();
      //  return view('front.pages.about', compact('siteinfo'));
    }

    public function leadSubmit(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|regex:/^(\+?\d{1,4}[\s-]?)?(\(?\d{1,4}\)?[\s-]?\d{1,4}[\s-]?\d{1,9})$/',
        ]);

        // Return a success response instead of redirecting
        return response()->json([
            'status' => 'success',
            'message' => 'Form submitted successfully!',
            'data' => $validated,
        ]);
    }

    public function quoteRequest(Request $request)
{
    // Validate the form input
    $request->validate([
        'fullname' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'mobile' => 'required|string|max:20',
        'message' => 'required|string|max:1000',
    ]);


        // Access SiteInfo model directly in the method
        $siteinfo = SiteInfo::first();

        $data = [
            'fullname' => $request->fullname,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'message' => $request->message,
        ];

        //Admin Email
        $adminEmail = Admin::find(1)->email;

        // Send the email to the recipient (you can add dynamic email addresses or use a fixed one)
      //  Mail::to($adminEmail)->send(new QuoteSubmission($data));

    // Redirect with a success message
    return redirect()->back()->with('success', 'Your quote request has been sent successfully!');
}

}
