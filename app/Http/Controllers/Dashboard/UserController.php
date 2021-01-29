<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Alert;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:update_users'])->only(['edit', 'update']);
        $this->middleware(['permission:delete_users'])->only('destroy');
    }
    /**
     * "files": ["helpers.php" ]
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Set a warning toast, with no title
        //notify()->warning('My name is Inigo Montoya. You killed my father, prepare to die!');

        // Set a success toast, with a title
        //notify()->success('Have fun storming the castle!', 'Miracle Max Says', ['timeOut' => 50]);

        // Set an error toast, with a title
        //notify()->error('I do not think that word means what you think it means.', 'Inconceivable!');

        // Override global config options from 'config/notify.php'

        //notify()->success('We do have the Kapua suite available.', 'Turtle Bay Resort', ['timeOut' => 5000]);

        // for pnotify driver
        //notify()->alert('We do have the Kapua suite available.', 'Turtle Bay Resort', ['timeOut' => 5000]);


        //Alert::success('Success Title', 'Success Message');
        //Alert::alert('Title', 'Message', 'Type');
        //Alert::info('Info Title', 'Info Message');
        //Alert::warning('Warning Title', 'Warning Message');
        //Alert::error('Error Title', 'Error Message');
        //Alert::question('Question Title', 'Question Message');
        //Alert::image('Image Title!', 'Image Description', 'Image URL', 'Image Width', 'Image Height');
        //Alert::html('Html Title', 'Html Code', 'Type');
        //Alert::toast('Toast Message', 'Toast Type');

        //toast('Your Post as been submited!', 'success');
        //alert()->success('SuccessAlert', 'Lorem ipsum dolor sit amet.')->persistent(true, false);
        //toast('Success Toast', 'success')->autoClose(5000);
        //alert('Title', 'Lorem Lorem Lorem', 'success')->position('top-end');
        //alert()->success('SuccessAlert', 'Lorem ipsum dolor sit amet.')->showConfirmButton('Confirm', '#3085d6');
        //alert()->question('Are you sure?', 'You won\'t be able to revert this!')->showCancelButton('Cancel', '#aaa');
        //toast('Post Updated', 'success', 'top-right')->showCloseButton();
        //toast('Post Updated', 'success', 'top-right')->hideCloseButton();
        // example:
        //alert()->question('Are you sure?', 'You won\'t be able to revert this!')->showConfirmButton('Yes! Delete it', '#3085d6')->showCancelButton('Cancel', '#aaa')->reverseButtons();
        //alert()->error('Oops...', 'Something went wrong!')->footer('<a href="#">Why do I have this issue?</a>');
        //alert()->success('Post Created', 'Successfully')->toToast();
        //alert()->success('Post Created', '<strong>Successfully</strong>')->toHtml();
        //alert('Title', 'Lorem Lorem Lorem', 'success')->addImage('https://unsplash.it/400/200');
        //alert('Title', 'Lorem Lorem Lorem', 'success')->width('720px');
        //alert('Title', 'Lorem Lorem Lorem', 'success')->padding('50px');
        //alert('Title', 'Lorem Lorem Lorem', 'success')->background('#fff');
        // example:
        //alert()->info('InfoAlert', 'Lorem ipsum dolor sit amet.')->animation('tada faster', 'fadeInUp faster');
        //alert()->success('Post Created', 'Successfully')->buttonsStyling(false);
        // example:
        //alert()->success('Post Created', 'Successfully')->iconHtml('<i class="far fa-thumbs-up"></i>');

        // example:
        //alert()->question('Are you sure?', 'You won\'t be able to revert this!')->showCancelButton()->showConfirmButton()->focusConfirm(true);
        //alert()->question('Are you sure?', 'You won\'t be able to revert this!')->showCancelButton()->showConfirmButton()->focusCancel(true);
        //toast('Signed in successfully', 'success')->timerProgressBar();




        $users = User::whereRoleIs('admin')->where(
            function ($q) use ($request) {
                return $q->when($request->search, function ($query) use ($request) {
                    return $query->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            }
        )->latest()->paginate(10);
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'permissions' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,gif,bmp',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        /*$request['password'] = bcrypt($request->password);
        $user = User::create($request->all());*/

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }
        $user = User::create($request_data);

        $user->attachRole('admin');

        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $title = __('site.edit_user');
        return view('dashboard.users.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //dd($request->all());

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'permissions' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,gif,bmp',
            //'email' => 'required|email|unique:users,email,' . $user->id,
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'sometimes|nullable|min:6|confirmed',
            'password_confirmation' => 'sometimes|nullable',
        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);

        //if (request()->has('password') && !empty($request->password)) {
        if ($request->password) {
            //dd($request->all());
            $request_data['password'] = bcrypt($request->password);
        }

        if ($request->image) {

            if ($user->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        }

        $user->update($request_data);

        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        }

        $user->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.users.index');
    }
}
