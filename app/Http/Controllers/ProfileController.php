<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Toast;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show()
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        $addressParts = explode(', ', $profile->address ?? '');
        $profile->city = $addressParts[0] ?? '';
        $profile->country = $addressParts[1] ?? '';
        $profile->postcode = $addressParts[2] ?? '';

        return view('profile', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:11',
            'email' => 'required|string|email|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:10',
        ], [
            'username.required' => 'Please enter your username.',
            'email.required' => 'Please enter your email.',
        ]);

        if (empty($request->username)) {
            return redirect()->back()->with('error', 'Please enter your username.');
        }

        if (empty($request->email)) {
            return redirect()->back()->with('error', 'Please enter your email.');
        }

        //update table user
        $user = User::find($id);
        $user->name = $request->get('username');
        $user->email = $request->get('email');

        //update table profile
        $profile = Profile::where('user_id', $id)->first();
        $profile->fullname = $request->get('full_name');
        $profile->phone_number = $request->get('phone_number');
        $profile->updated_at = now();



        $profile->address = implode(', ', [
            $request->get('city'),
            $request->get('country'),
            $request->get('postcode'),
        ]);

        $profile->update();
        $user->update();

        if ($profile && $user) {
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    public function updateAvatar(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $profile = Profile::where('user_id', $id)->first();
        $profile->updated_at = now();


        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $profile->avatar =  $avatarName;
        }

        $profile->update();

        if ($profile) {
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
    public function updateSocialMedia(Request $request, $id)
    {
        $request->validate([
            'ig_username' => 'nullable|string|max:255',
            'twitter_username' => 'nullable|string|max:255',
            'tiktok_username' => 'nullable|string|max:255',
        ]);

        $profile = Profile::where('user_id', $id)->first();
        $profile->updated_at = now();

        $profile->social_media = json_encode([
            'ig_username' => $request->get('ig_username'),
            'twitter_username' => $request->get('twitter_username'),
            'tiktok_username' => $request->get('tiktok_username'),
        ]);

        $profile->update();

        if ($profile) {
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function changePassword(Request $request, $id)
    {
        // Validate the request
        // $validator = Validator::make($request->all(), [
        //     'old_password' => 'required',
        //     'new_password' => 'required|string|min:8',
        //     'confirm_password' => 'required|same:new_password',
        // ]);

        // // If validation fails, redirect back with errors
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // // Get the authenticated user
        // $user = User::findOrFail($id);
        // $user->updated_at = now();

        // dd($user);
        // // Check if the old password matches
        // if (!Hash::check($request->old_password, $user->password)) {
        //     return redirect()->back()->with('error', 'Current password is incorrect.');
        // }

        // // Update the user's password
        // $user->password = Hash::make($request->new_password);
        // $user->save();

        // // Redirect back with success message
        // return redirect()->back()->with('success', 'Password changed successfully.');

        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('confirm_password'));
            $user->update();
            if ($user) {
                return redirect()->back()->with('success', 'Password changed successfully.');
            } else {
                return redirect()->back()->with('error', 'Something went wrong.');//need to fix
            }
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
        //
    }
}
