<?php

namespace App\Http\Controllers;

use App\redshift_table;
use App\calculation_table;
use App\method_table;
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
        $method = method_table::select('python_script_path')->where('method_id', $request->input('method_id_for_files'))->get();
        $method = collect($method)->pluck('python_script_path')->toArray();

    	for($i = 0; $i < $counter; $i++){
    			$process = new Process('python ' . $method[0]. ' ' . $str[$i]);
        		$calculate[$i] = new calculation_table();

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
                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.assigned_calc_ID')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_u')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.optical_u')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_g')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.optical_g')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_r')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.optical_r')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_i')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.optical_i')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('optical_z')){

                                         $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.optical_z')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_three_six')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.infrared_three_six')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_four_five')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.infrared_four_five')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_five_eight')){

                                         $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.infrared_five_eight')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_eight_zero')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.infrared_eight_zero')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_J')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.infrared_J')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('infrared_K')){

                                        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.infrared_K')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('radio_1.4')){

            $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('redshift_tables.radio_one_four')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);
        }
        else if (request()->has('redshift_result')){
            //   $calculations= calculation_table::join('redshift_tables','redshift_tables.calculation_ID','=','calculation_tables.galaxy_ID')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);

             $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('calculation_tables.redshift_result')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);



        }
        else{



        $calculations= calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
            ->select('redshift_tables.*','calculation_tables.redshift_result')->orderByDesc('calculation_tables.updated_at')->where('redshift_tables.user_ID', auth()->id())->paginate($pages);

                                    }

        return view('history', compact('calculations','red'));
    }

    public function search(Request $req)
    {
        //
        $pages=20;
        $q = $req->input('q');
    $user = calculation_table::join('redshift_tables', 'calculation_ID', '=', 'calculation_tables.galaxy_ID')
     ->where('redshift_tables.user_ID', auth()->id())->where(function ($query) use ($q)  {
    $query->orWhere('assigned_calc_ID','LIKE','%'.$q.'%')
    ->orWhere('redshift_tables.optical_u','LIKE','%'.$q.'%')->orWhere('optical_g','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.optical_r','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.optical_i','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.optical_z','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.infrared_three_six','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.infrared_five_eight','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.infrared_eight_zero','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.infrared_J','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.infrared_K','LIKE','%'.$q.'%')->
    orWhere('redshift_tables.radio_one_four','LIKE','%'.$q.'%')->
    orWhere('calculation_tables.redshift_result','LIKE','%'.$q.'%');
})->paginate($pages);

    if(count($user) > 0){
        $details=1;
        return view('search',compact('user','details'));
    }
    else {

        return view ('search')->withMessage('No Details found. Try to search again !');}
    }

    public function store(Request $request){

        $galaxy = new redshift_table();
    	$calculate = new calculation_table();
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

    	$calculate->method_id = $request->input('method_ID');
        $method = method_table::select('python_script_path')->where('method_id', $calculate->method_id)->get();
        $method = collect($method)->pluck('python_script_path')->toArray();

    	$process = new Process('python ' . $method[0]. ' ' . $str);
    	try {
  			  $process->mustRun();
              $calculate->redshift_result = $process->getOutput();
		} catch (ProcessFailedException $exception) {
            $calculate->redshift_result = -150;
        }

        $calculate->save();

     	$red_result=(float)$calculate->redshift_result;

        return redirect('/history')->with(compact('red_result'));
    }
}
?>
