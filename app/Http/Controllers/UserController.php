<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan Anda mengimpor model User jika belum melakukannya
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    /**
     * Set user role to admin.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function setAdminRole($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            // User tidak ditemukan
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->role = 'admin';
        $user->save();

        return response()->json(['message' => 'User role updated to admin'], 200);
    }

    /**
     * Check if user is admin.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function checkUserRole($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            // User tidak ditemukan
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->role === 'admin') {
            return response()->json(['message' => 'User is admin'], 200);
        } else {
            return response()->json(['message' => 'User is regular user'], 200);
        }
    }

    public function dataUser(Request $request)
    {
        if(Auth::check())
        {
            return view('users.index',['judul'=>'Registered', 'datauser'=>$request->user()]);
        }
        else
        {
            return view('users.index',['judul'=>'Silahkan login terlebih dahulu']);
        }
        
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        Auth::logout();  // User akan logout setelah update 

        return redirect()->route('login')->with('success', 'Data berhasil diperbarui. Silahkan login kembali');
    }

    public function delete(Request $request) {
        $user = $request->user();
        $user->delete();
        Auth::logout();
        return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus. Silahkan register kembali');
    }

    public function index()
    {
        echo Auth::user()->id."<br>";
        echo Auth::user()->name."<br>";
        echo Auth::user()->email."<br>";
        echo Auth::user()->password."<br>";
        dump(Auth::user());
    }
}
