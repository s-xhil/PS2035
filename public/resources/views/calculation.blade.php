@extends('layouts.app_boot')
@section('title', 'Calculation Page' )
@section('content')
<head>
	<style>
    	.btn_upload {
 			 background-color: Coral;
 			 border: 1px solid black;
  			 color: Black;
  			 text-align: center;
        	 padding-left: 20px;
        	 padding-right: 20px;
        	 margin-left: 1px;
  			 font-size: 16px;
 			 opacity: 0.6;
  			 transition: 0.3s;
}
.btn_upload:hover {opacity: 0.9}
	</style>
</head>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" >
            <div class="container">
                <a class="nav-link" href="{{ route('home') }}"><h2 id="redshift">RedShift Estimator</h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" >
                        <!-- Authentication Links -->
                        <li class="nav-item">
                           <a class="nav-link" href="{{ route('history') }}">{{ __('History') }}</a>

                    </li>
                            <li class="nav-item">

                              <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                            </li>
                   <h4 class="nav-link"> {{ Auth::user()->name }} </h4>

                    </ul>
                </div>
            </div>
        </nav>
  <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins" style="background-image: url('/images/bg1.jpg')">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body" >
                    <h2 class="title">Calculation Form</h2>
                    <form method="POST" action="{{ route('calculation.index') }}" style="align-items:center;">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Galaxy ID</label>
                                    <input id="assigned_calc_ID" type="text" class="input--style-4" name="assigned_calc_ID" value="{{ old('assigned_calc_ID') }}" required autocomplete="assigned_calc_ID" autofocus>
                                </div>
                            </div>
                        <!-- </div>
                        <div class="row"> -->
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Optical U</label>
                                    <input id="optical_u" step="any" type="number" class="input--style-4" name="optical_u" value="{{ old('optical_u') }}" required autocomplete="optical_u" autofocus>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Optical R</label>
                                    <input id="optical_r" step="any" type="number" class="input--style-4" name="optical_r" value="{{ old('optical_r') }}" required autocomplete="optical_r" autofocus>
                                </div>
                            </div>
                        <!-- </div>
                         <div class="row"> -->
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Optical I</label>
                                    <input id="optical_i" step="any" type="number" class="input--style-4" name="optical_i" value="{{ old('optical_i') }}" required autocomplete="optical_i" autofocus>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Optical G</label>
                                    <input id="optical_g" step="any" type="number" class="input--style-4" name="optical_g" value="{{ old('optical_g') }}" required autocomplete="optical_g" autofocus>
                                </div>
                            </div>
                        <!-- </div>
                         <div class="row"> -->
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Optical Z</label>
                                    <input id="optical_z" step="any" type="number" class="input--style-4" name="optical_z" value="{{ old('optical_z') }}" required autocomplete="optical_z" autofocus>
                                </div>
                            </div>
                        <!-- </div>
                         <div class="row"> -->
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Infrared 3.6</label>
                                    <input id="infrared_three_six" step="any" type="number" class="input--style-4" name="infrared_three_six" value="{{ old('infrared_three_six') }}" required autocomplete="infrared_three_six" autofocus>
                                </div>
                            </div>
                             <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Infrared 4.5</label>
                                    <input id="infrared_four_five" step="any" type="number" class="input--style-4" name="infrared_four_five" value="{{ old('infrared_four_five') }}" required autocomplete="infrared_four_five" autofocus>
                                </div>
                            </div>
                        <!-- </div>
                         <div class="row"> -->
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Infrared 5.8</label>
                                    <input id="infrared_five_eight" step="any" type="number" class="input--style-4" name="infrared_five_eight" value="{{ old('infrared_five_eight') }}" required autocomplete="infrared_five_eight" autofocus>
                                </div>
                            </div>
                             <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Infrared 8.0</label>
                                    <input id="infrared_eight_zero" step="any" type="number" class="input--style-4" name="infrared_eight_zero" value="{{ old('infrared_eight_zero') }}" required autocomplete="infrared_eight_zero" autofocus>
                                </div>
                            </div>
                        <!-- </div>
                        <div class="row"> -->
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Infrared J</label>
                                    <input id="infrared_J" step="any" type="number" class="input--style-4" name="infrared_J" value="{{ old('infrared_J') }}" required autocomplete="infrared_J" autofocus>
                                </div>
                            </div>
                             <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Infrared K</label>
                                    <input id="infrared_K" step="any" type="number" class="input--style-4" name="infrared_K" value="{{ old('infrared_K') }}" required autocomplete="infrared_K" autofocus>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="label text-md-right">Radio 1.4</label>
                                    <input id="radio_one_four" step="any" type="number" class="input--style-4" name="radio_one_four" value="{{ old('radio_one_four') }}" required autocomplete="radio_one_four" autofocus>
                                </div>
                            </div>



                            <div class="col-4">
                                <div class="input-group" style="text-align:center">
                                    <label class="label text-md-right">Calculation Method</label>

                                    <select name="method_id" id="method" name="dropdown" onchange="update_var()">
       									 @foreach($dropdowns as $dropdown)
        								 <option value="{{ $dropdown->method_id}}">{{ $dropdown->python_script_path}}</option>
        								@endforeach
   								 </select>
                                <script>
                                function update_var() {
                                	 document.getElementById("method_id_for_files").value = document.getElementById("method").value;
								}
                                </script>
                                </div>

                            </div>
                          </div>

                        <div class="p-t-15" style="margin-left:33%">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Calculate</button>

                        </div>
                    </form>
                         <div class="input-group" style = "margin-top: 20px">
                         	<div class="custom-file">
                        		<form enctype="multipart/form-data" action="{{ route('upload') }}" method="POST">
                            	@csrf
                            	 <input type="file" class="custom-file-input" id="fileInput" name="fileToUpload">
                                <input type ="number" style="display:none" name = "method_id_for_files" id="method_id_for_files" value= "1">
   							 	<label id = "inputLable" class="custom-file-label" for="fileInput">
                                <script>
                                document.getElementById('fileInput').onchange = function () {
  									 document.getElementById('inputLable').innerHTML = this.value.replace(/.*[\/\\]/, '');
								};
                                </script>
                                Choose File
                                </label>


							</div>
                            <div class="input-group-append">
   									 <button class = "btn_upload" type="submit" value="Upload">Upload</button>
  							</div>
                        </form>
                    	</div>
                </div>
            </div>
        </div>
    </div>


 @endsection
