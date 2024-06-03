<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Report;
use App\Models\Review;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $patients = Patient::query();

        if (request('search')) {
            $patients->where('name', 'like', '%' . request('search') . '%')->orWhere('student_id', 'like', '%' . request('search') . '%');
        }

        return view("admin.patient_data", ["patients" => $patients->paginate(10)->withQueryString()]);
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        try {
            $response = Http::post('http://127.0.0.1:8000/api/login', [
                'username' => $request->username,
                'password' => $request->password,
            ]);
    
            $data = $response->json();
    
            // Simpan token dalam session
            session(['token' => $data['token']]);
            session(['user' => $data['user']]);
    
            // dd($data);
    
            // Redirect ke dashboard dengan menyertakan token dalam session
            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Jika login gagal, arahkan kembali ke halaman login dengan pesan error
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }
    }

    public function dashboard(Request $request)
    {
        // dd("dashboard");
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/dashboard', [
                'id' => $user['id'],
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data));

            return view('client.dashboard', ['data' => $objectData->data,'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    // public function showDoctors(Request $request) {
    //     $doctors = Doctor::when($request->poli, function($query) use ($request) {
    //         return $query->where('specialization', $request->poli);
    //     })->whereHas('schedule_time', function ($query) {
    //         $query->whereNotNull('schedule_time_id'); // Sesuaikan dengan nama kolom di tabel pivot
    //     });

    //     $doctors = $doctors->paginate(10)->withQueryString();

    //     $ratings = [];

    //     foreach ($doctors as $doctor) {
    //         $rating = number_format(Review::where('doctor_id', $doctor->id)->avg('rating'), 1);
    //         $ratings[] = $rating;
    //     }
        
    //     return view('client.make_reservation',["doctors" => $doctors, "ratings" => $ratings]);
    // }

    public function showDoctors(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // dd($token);

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/lakukan-reservasi',[
                'poli' => $request->poli,
            ]);

            $data = $response->json();

            // dd($data);

            return view('client.make_reservation', ['data' => $data['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
        
        // return view('client.make_reservation',["doctors" => $doctors, "ratings" => $ratings]);
    }

    public function destroy(Request $request) {
        Patient::where('id', $request->id)->delete();

        return redirect('/admin/data-pasien')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($username) {
        try {
            $patient = Patient::where('username',$username)->firstOrFail();

            return view('admin.patient_data_edit',["patient" => $patient]);
        } catch (ModelNotFoundException $exception) {
            return view("client.notFound",["exception" => $exception]);
        }

        
    }

    public function update(Request $request,$id) {
        $patient = Patient::findOrFail($id);

        try {
            $request->validate([
                'no_hp' => 'required|min:11|max:13',
                'alamat' => 'required|max:256',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required',
                'password' => 'nullable|max:15|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
            ]);

            if ($request->password == null) {
                $patient->update([
                    "phone" => $request->no_hp,
                    "gender" => $request->jenis_kelamin,
                    "birthdate" => $request->tanggal_lahir,
                    "address" => $request->alamat
                ]);
            } else {
                $patient->update([
                    "phone" => $request->no_hp,
                    "gender" => $request->jenis_kelamin,
                    "birthdate" => $request->tanggal_lahir,
                    "address" => $request->alamat,
                    "password" => bcrypt($request->password) 
                ]);
            }
    
            $patient = Patient::findOrFail($request->id);
    
    
            return back()->with('success','Data berhasil diupdate!');
        } catch (ValidationException $e) {
            return redirect('/admin/data-pasien/edit/' . $request->username)->with('toast_error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/admin/data-pasien/edit/' . $request->username)->withErrors(['error' => 'Terjadi kesahalan!']);
        }
    }

    public function profileEdit() {
        return view("client.profile");
    }

    public function profileUpdate(Request $request) {
        try {
            $request->validate([
                'phone' => 'required|numeric|digits_between:11,13',
                'address' => 'required|string|max:256',
                'birthdate' => 'required|date',
                'gender' => 'required',
            ]);
    
           Patient::findOrFail($request->id)->update([
                "phone" => $request->phone,
                "gender" => $request->gender,
                "birthdate" => $request->birthdate,
                "address" => $request->address
            ]);

    
            return redirect('/profile')->with('success','Update profil berhasil!');
        } catch (ValidationException $e) {
            // Tangkap exception jika validasi gagal
            return redirect('/profile')->with('toast_error', $e->getMessage());
        } catch (\Exception $e) {
            // Tangkap exception lain jika terjadi kesalahan lainnya
            return redirect('/profile')->withErrors(['error' => 'Terjadi kesalahan!']);
        }
    }

    public function showReservations(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // dd($token);

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/reservasi-saya',[
                'poli' => $request->poli,
            ]);

            $data = $response->json();

            $objectData = json_decode(json_encode($data));

            // dd($objectData);
            return view('client.my_reservation', ['daftar_reservasi' => $objectData->data,'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
    }

    public function showResults(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // dd($token);

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/riwayat-pemeriksaan',[
                'id' => $user['id'],
            ]);

            $data = $response->json();

            // dd($data);

            return view('client.reservation_result', ['daftar_pemeriksaan' => $data['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }
        // return view('client.reservation_result',['daftar_pemeriksaan'=> $daftar_pemeriksaan->paginate(6) ]);
    }

    public function showResultDetail(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // dd($token);

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/riwayat-pemeriksaan/detail',[
                'id' => $request->id,
            ]);

            $data = $response->json();
            $objectData = json_decode(json_encode($data ));

            return view('client.reservation_result_detail', ['report' => $objectData->data,'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }

        return view('client.reservation_result_detail', ["report" => $report]);
    }

    public function showResultDetailPDF($id) {
        $report = Report::with('reservation')->where('reservation_id',$id)->first();
        

        $obatList = explode("\n", $report->medications);
    

        $pdf = Pdf::loadView('client.reservation_result_detail_pdf',["report" => $report, "daftar_obat" => $obatList]);
        return $pdf->stream('TelkoMedika_Hasil Pemeriksaan_' . $report->reservation->patient->student_id . '.pdf');

        return view('client.reservation_result_detail_pdf', ["report" => $report, "daftar_obat" => $obatList]);
    }

    public function showDoctorDetail(Request $request) {
        try {
            
            // Mengambil token dari session atau dari tempat penyimpanan lainnya
            $token = $request->session()->get('token');
            $user = $request->session()->get('user');

            // Menyertakan token dalam header Authorization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://127.0.0.1:8000/api/lakukan-reservasi/detail',[
                'username' => $request->username,
            ]);

            $data = $response->json();

            return view('client.make_reservation_detail', ['data' => $data['data'],'user' => $user]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            return redirect()->back()->withErrors(['error' => 'Failed to retrieve dashboard data.']);
        }

        return view('client.make_reservation_detail',["doctor" => $doctor, "schedules" => DoctorSchedule::where('doctor_id',$doctor->id)->get(),"reviews" =>$reviews]);
    }

    public function makeReview(Request $request) {
        try {
            // Mengambil token dari session atau tempat penyimpanan lainnya
            $token = $request->session()->get('token');

            // Panggil API dengan token bearer
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/review', [
                'id' => $request->id,
                'comment' => $request->comment,
                'rating' => $request->rating,
                'doctor_id' => $request->doctor_id,
            ]);
            
            return redirect()->back()->withToastSuccess($response['message']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $response['message']]);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->session()->get('token');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://127.0.0.1:8000/api/logout');
            
            // Periksa apakah respons sukses
            if ($response->successful()) {
                // Logout berhasil
                $request->session()->forget('token');
                $request->session()->forget('user');
                return redirect('/login')->with('success', 'Anda telah berhasil logout');
            } else {
                // Tangani jika logout gagal
                return redirect('/')->with('error', 'Logout gagal: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi kesalahan dalam permintaan HTTP
            return redirect('/')->with('error', 'Terjadi kesalahan dalam melakukan logout: ' . $e->getMessage());
        }
    }

}
