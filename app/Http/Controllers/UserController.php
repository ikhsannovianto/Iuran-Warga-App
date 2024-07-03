<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan Anda mengimpor model User jika belum melakukannya
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UserExportPdf;

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

    public function deletelist(User $user) {
        $user->delete();
        Auth::logout();
        return redirect()->route('listuser')->with('success', 'Akun Anda berhasil dihapus. Silahkan register kembali');
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('listuser.index', compact('users'));
    }

    public function create()
    {
        return view('listuser.create');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('listuser')->with('success', 'User berhasil ditambahkan.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
        ]);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'DataUserIuranWargaApps.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect()->route('listuser')->with('success', 'Users imported successfully.');
    }

    public function exportPdf()
    {
        $exporter = new UserExportPdf();
        return $exporter->export();
    }
    
}

