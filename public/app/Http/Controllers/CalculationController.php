<?php

namespace App\Http\Controllers;

use App\redshifts;
use App\calculations;
use App\methods;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use App\Exports\RedshiftExport;
use Maatwebsite\Excel\Facades\Excel;




class CalculationController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        return view('calculation');
    }

    public function export(){
    	$str =  'redshift_result' . date('Y-m-d_h:m:s',time()) . '.csv';
        return Excel::download(new RedshiftExport, $str);
	}

		public function import(Request $request)
    {
      	$target_dir = "temp/";
	 	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	  	$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
 		$file = fopen($target_file, "r");
		$str = array();
        $galaxy =  array();
        $galaxy_ID = array();
        $counter = 0;
        $data = fgetcsv($file, ",");

		while(($data = fgetcsv($file, ",") ) !== FALSE && !feof($file)){
        		if(sizeof($data) > 12 && is_numeric($data[1])){
        			$galaxy[$counter] = new redshift_table();
        			try{
						$galaxy[$counter]->assigned_calc_ID = $data[0];
    					$process = new Process('echo  ' . $counter . " >> test.txt");
  			  			$process->mustRun();
    					$galaxy[$counter]->optical_u = floatval($data[1]);
    					$galaxy[$counter]->optical_g = floatval($data[2]);
    					$galaxy[$counter]->optical_r = floatval($data[3]);
    					$galaxy[$counter]->optical_i = floatval($data[4]);
    					$galaxy[$counter]->optical_z =  floatval($data[5]);
    					$galaxy[$counter]->infrared_three_six = floatval($data[6]);
    					$galaxy[$counter]->infrared_four_five =  floatval($data[7]);
    					$galaxy[$counter]->infrared_five_eight =  floatval($data[8]);
    					$galaxy[$counter]->infrared_eight_zero =  floatval($data[9]);
    					$galaxy[$counter]->infrared_J =  floatval($data[10]);
    					$galaxy[$counter]->infrared_K =  floatval($data[11]);
        				$galaxy[$counter]->radio_one_four =  floatval($data[12]);
    					$galaxy[$counter]->user_ID = auth()->id();
			 			$temp =  $galaxy[$counter]->optical_u . " " . $galaxy[$counter]->optical_g . " " . $galaxy[$counter]->optical_r  . " " . $galaxy[$counter]->optical_i . " " . $galaxy[$counter]->optical_z .  " " . $galaxy[$counter]->infrared_three_six . " " . $galaxy[$counter]->infrared_four_five . " " . $galaxy[$counter]->infrared_five_eight . " " . $galaxy[$counter]->infrared_eight_zero . " " . $galaxy[$counter]->infrared_J . " " . $galaxy[$counter]->infrared_K  . " " .  $galaxy[$counter]->radio_one_four;
   						//adds a / to command characters
    					$str[$counter] = escapeshellcmd($temp);
                    	$galaxy[$counter]->save();
                    	$galaxy_ID[$counter] = DB::getPdo()->lastInsertId();
                    	$counter++;
                	}
        			catch (Exception $e){

                	}
                }
  		}
		fclose($file);
        $calculate =  array();
        $method = methods::select('python_script_path')->where('method_id', $request->input('method_id_for_files'))->get();
        $method = collect($method)->pluck('python_script_path')->toArray();

    	for($i = 0; $i < $counter; $i++){
    			$process = new Process('python ' . $method[0]. ' ' . $str[$i]);
        		$calculate[$i] = new calculations();

       			try {
              		$process->mustRun();
             		$calculate[$i]->redshift_result = $process->getOutput();
                	$calculate[$i]->galaxy_id = $galaxy_ID[$i];
    				$calculate[$i]->method_id = $request->input('method_id_for_files');
        		} catch (ProcessFailedException $exception) {
           			 $calculate[$i]->redshift_result = -100;
        		}

        }
		for($i = $counter - 1; $i >= 0; $i--){
			$calculate[$i]->save();
        }
        return redirect('/history');
    }

	public function home(){
       $pages=20;

        if (request()->has('galaxy_id')){
                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.assigned_calc_ID')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_u')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.optical_u')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_g')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.optical_g')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_r')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.optical_r')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_i')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.optical_i')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_z')){

                                         $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.optical_z')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_three_six')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.infrared_three_six')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_four_five')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.infrared_four_five')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_five_eight')){

                                         $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.infrared_five_eight')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_eight_zero')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.infrared_eight_zero')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_J')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.infrared_J')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_K')){

                                        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.infrared_K')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('radio_1.4')){

            $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('redshifts.radio_one_four')->where('redshifts.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('redshift_result')){
            //   $calculations= calculations::join('redshifts','redshifts.calculation_ID','=','calculations.galaxy_ID')->where('redshifts.user_ID', auth()->id())->paginate($pages);

             $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('calculations.redshift_result')->where('redshifts.user_ID', auth()->id())->paginate($pages);



        }
        else{



        $calculations= calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
            ->select('redshifts.*','calculations.redshift_result')->orderByDesc('calculations.updated_at')->where('redshifts.user_ID', auth()->id())->paginate($pages);

                                    }

        return view('history', compact('calculations'));
    }

    public function search(Request $req)
    {
        //
        $pages=20;
        $q = $req->input('q');
    $user = calculations::join('redshifts', 'calculation_ID', '=', 'calculations.galaxy_ID')
     ->where('redshifts.user_ID', auth()->id())->where(function ($query) use ($q)  {
    $query->orWhere('assigned_calc_ID','LIKE','%'.$q.'%')
    ->orWhere('redshifts.optical_u','LIKE','%'.$q.'%')->orWhere('optical_g','LIKE','%'.$q.'%')->
    orWhere('redshifts.optical_r','LIKE','%'.$q.'%')->
    orWhere('redshifts.optical_i','LIKE','%'.$q.'%')->
    orWhere('redshifts.optical_z','LIKE','%'.$q.'%')->
    orWhere('redshifts.infrared_three_six','LIKE','%'.$q.'%')->
    orWhere('redshifts.infrared_five_eight','LIKE','%'.$q.'%')->
    orWhere('redshifts.infrared_eight_zero','LIKE','%'.$q.'%')->
    orWhere('redshifts.infrared_J','LIKE','%'.$q.'%')->
    orWhere('redshifts.infrared_K','LIKE','%'.$q.'%')->
    orWhere('redshifts.radio_one_four','LIKE','%'.$q.'%')->
    orWhere('calculations.redshift_result','LIKE','%'.$q.'%');
})->paginate($pages);

    if(count($user) > 0){
        $details=1;
        return view('search',compact('user','details'));
    }
    else {

        return view ('search')->withMessage('No Details found. Try to search again !');}
    }

    public function store(Request $request){

        $galaxy = new redshifts();
    	$calculate = new calculations();
		$galaxy->assigned_calc_ID = $request->input('assigned_calc_ID');
    	$galaxy->optical_u = $request->input('optical_u');
    	$galaxy->optical_g = $request->input('optical_g');
    	$galaxy->optical_r = $request->input('optical_r');
    	$galaxy->optical_i = $request->input('optical_i');
    	$galaxy->optical_z = $request->input('optical_z');
    	$galaxy->infrared_three_six = $request->input('infrared_three_six');
    	$galaxy->infrared_four_five = $request->input('infrared_four_five');
    	$galaxy->infrared_five_eight = $request->input('infrared_five_eight');
    	$galaxy->infrared_eight_zero = $request->input('infrared_eight_zero');
    	$galaxy->infrared_J = $request->input('infrared_J');
    	$galaxy->infrared_K = $request->input('infrared_K');
        $galaxy->radio_one_four = $request->input('radio_one_four');
    	$galaxy->user_ID = auth()->id();
    	// optical g + optical u
    	$str =  $galaxy->optical_u . " " . $galaxy->optical_g . " " . $galaxy->optical_r  . " " . $galaxy->optical_i . " " . $galaxy->optical_z .  " " . $galaxy->infrared_three_six . " " . $galaxy->infrared_four_five . " " . $galaxy->infrared_five_eight . " " . $galaxy->infrared_eight_zero . " " . $galaxy->infrared_J . " " . $galaxy->infrared_K  . " " .  $galaxy->radio_one_four;
   		//adds a / to command characters
    	$str = escapeshellcmd($str);

        $galaxy->save();
   		$calculate->galaxy_id = DB::getPdo()->lastInsertId();

    	$calculate->method_id = $request->input('method_id');
        $method = methods::select('python_script_path')->where('method_id', $calculate->method_id)->get();
        $method = collect($method)->pluck('python_script_path')->toArray();

    	$process = new Process('c:\Python27\python27.exe ' . $method[0] . ' ' . $str);


    	##try {
    	    $process->mustRun();
            $calculate->redshift_result = $process->getOutput();
            $calculate->redshift_result = rtrim($calculate->redshift_result);
		##} catch (ProcessFailedException $exception) {
    	 #   $calculate->redshift_result = -150;
        #}
        $calculate->save();


     	$red_result=$calculate->redshift_result;

        return redirect('/history')->with(compact('red_result'));


    }
}
?>
