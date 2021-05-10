<?php
namespace App\Http\Controllers;
use App\Models\AvailableTest;
use App\Models\TestPerformed;
use App\Models\Category;
use DB;
class HomeController extends Controller
{
    public function index()
    {
        
        $data = DB::table('test_performeds')->where('Sname_id', '=', '2')->get();
        $today =$data->where('created_at', '>=', date('Y-m-d H:i:s',strtotime('-1 days')) )->count();
        $thisWeekPatient=$data->where('created_at', '>=', date('Y-m-d H:i:s',strtotime('7 days')) )->count();
        $thisMongthPatient=$data->where('created_at', '>=', date('Y-m-d H:i:s',strtotime('30 days')) )->count();
          

          $allPerformedToday = DB::table('test_performeds')
          ->join('available_tests', 'test_performeds.available_test_id', '=', 'available_tests.id')
          ->join('patients', 'test_performeds.patient_id', '=', 'patients.id')
          ->get();
          $criticalTestToday=array();
          foreach ($allPerformedToday as $performed) {
                if($performed->testResult <= $performed->firstCriticalValue || $performed->testResult >= $performed->finalCriticalValue)
                {
                array_push($criticalTestToday,$performed);

                }

            }
             // dd($criticalTestToday);



    
       
        $todayDelayeds = TestPerformed::where('Sname_id', '=', '1')->get();
        // dd($dat);
        // $todayCri =$dat->where('start_time', '>=', date('Y-m-d H:i:s',strtotime('-1 days')) );
     

        $testPerformed = TestPerformed::get();


        $testPerformeds = DB::table('test_performeds')
        ->join('patients', 'test_performeds.patient_id', '=', 'patients.id')
        ->join('statuses', 'test_performeds.Sname_id', '=', 'statuses.id')
        ->join('available_tests', 'test_performeds.available_test_id', '=', 'available_tests.id')
        ->join('categories', '.available_tests.category_id', '=', 'categories.id')
        ->select('categories.Cname','available_tests.name','patients.Pname','statuses.Sname')
        ->orderBy('patient_id', 'DESC')
        ->get();
     


        $distincrCatagory = Category::distinct()->get();
        $test = DB::table('test_performeds')
        ->get('id'); 
         $distincrCatagory2 = $test->count();    
    

     
        return view('home', compact('today','thisWeekPatient','thisMongthPatient','testPerformed','distincrCatagory',
        'distincrCatagory2','todayDelayeds','criticalTestToday','testPerformeds'));
        
    }
    public function dashboard(Request $request)
    { 
        $data['testPerformed'] = TestPerformed::count();
        $data['testPerformd'] = TestPerformed::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-7 days')) )->count();
        $data['testPerfor'] = TestPerformed::whereDate('created_at', '>=', date('Y-m-d H:i:s',strtotime('-30 days')) )->count();
        $your_Valu = 101;
        $min_price = 101;
        $max_price =200;
        $data['tes'] = TestPerformed::whereBetween('initailaNormalValue', [$min_price, $max_price])->count('id');
        $data['invoiceAmount'] = Invoice::sum('amount');
        $data['billAmount'] = Bill::sum('amount');
        $data['paymentAmount'] = Payment::sum('amount');
        $data['advancePaymentAmount'] = AdvancedPayment::sum('amount');
        $data['doctors'] = Doctor::count();
        $data['patients'] = Patient::count();
        $data['nurses'] = Nurse::count();
        $data['availableBeds'] = Bed::whereIsAvailable(1)->count();
        $data['noticeBoards'] = NoticeBoard::take(10)->orderBy('id', 'DESC')->get();
        $data['enquiries'] = TestCatagory::where('name', 0)->latest()->take(10)->get();
          $projects = TestPerformed::where('user_id', 1)->latest()->take(10)->get();
        $data['currency'] = Setting::CURRENCIES;
        return view('dashboard.index', compact('data','projects'));
    }

}