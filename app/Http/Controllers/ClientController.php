<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
  
class ClientController extends Controller
{
    public function index()
    {
        if (auth()->user()->type == 'user') {
            $clients = User::where('type','client')->where('assigned_to',auth()->user()->id)->with('assign')->get();
        }else{
            $clients = User::where('type','client')->with('assign')->get();
        }
        return Inertia::render('Clients/Index', ['clients' => $clients]);
    }
    
    public function create()
    {
        return Inertia::render('Clients/Create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

  
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'client',
            'assigned_to'=> auth()->user()->id
        ]);
  
        return redirect()->route('clients.index');
    }
    
    public function edit(User $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => $client
        ]);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
  
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'type' => 'client',
            'assigned_to'=> auth()->user()->id
        ]);
        return redirect()->route('clients.index');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('clients.index');
    }
}