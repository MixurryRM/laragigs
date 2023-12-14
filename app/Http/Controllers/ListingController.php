<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listings
    public function index(){
        // dd(request()->tag);
        // dd(request('tag'));
        // dd($request->all('tag'));
        $listings = Listing::latest()->filter(request(['tag','search']))->simplePaginate(2);
        return view('listings/index',compact('listings'));
    }

    //show single listing
    public function showList($id){
        $list = Listing::where('id',$id)->first();
        if ($list) {
            return view('listings/show',compact('list'));
        } else {
            abort('404');
        }
    }

    //show create form
    public function create(){
        return view('listings.create');
    }

    //store listings data
    public function store(Request $request){

        // dd($request->file('logo'));

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required',Rule::unique('listings','company')],
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message','Listing created successfully!');
    }

    //Show Edit Form
    public function edit(Listing $listing){
        return view('listings.edit',compact('listing')); //['listing' => $listing]
    }

    //Update Listings
    public function update(Request $request,Listing $listing){

        //Make sure logined user is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action!');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        };

        $listing->update($formFields);

        return back()->with('message','Listing updated successfully!');
    }

    //Delete Listing
    public function delete(Listing $listing){

        //Make sure logined user is owner
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action!');
        }

        $listing->delete();

        return redirect('/')->with('message','Listing deleted successfully!');
    }

    //Manage Listings
    public function manage(){
        return view('listings.manage',[
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
