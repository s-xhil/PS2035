@extends('layouts.app')

@section('content')

  <div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="background-color:#002855; color:white">
                <div class="card-header">{{ __('Redshift Estimator') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('calculation') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="assigned_calc_ID" class="col-md-4 col-form-label text-md-right">{{ __('Calculation ID') }}</label>

                            <div class="col-md-6">
                                <input id="assigned_calc_ID" type="text" class="form-control @error('assigned_calc_ID') is-invalid @enderror" name="assigned_calc_ID" value="{{ old('assigned_calc_ID') }}" required autocomplete="assigned_calc_ID" autofocus>

                                @error('assigned_calc_ID')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="optical_u" class="col-md-4 col-form-label text-md-right">{{ __('Optical u') }}</label>

                            <div class="col-md-2">
                                <input id="optical_u" type="number" class="form-control @error('optical_u') is-invalid @enderror" name="optical_u" value="{{ old('optical_u') }}" required autocomplete="optical_u" autofocus>

                                @error('optical_u')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>
                        <div class="form-group row"> -->
                            

                            <div class="col-md-2">
                                <input id="optical_g" type="number" class="form-control @error('c_optical_gid') is-invalid @enderror" name="optical_g" value="{{ old('optical_g') }}" required autocomplete="optical_g" autofocus>
<label for="optical_g" class="row-md-1">{{ __(' Optical g') }}</label>
                                @error('optical_g')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          <!-- </div>
                        <div class="form-group row">  -->
                            

                            <div class="col-md-2">
                                <input id="optical_r" type="number" class="form-control @error('optical_r') is-invalid @enderror" name="optical_r" value="{{ old('optical_r') }}" required autocomplete="optical_r" autofocus>
<label for="optical_r" class="row-md-1">{{ __('Optical r') }}</label>
                                @error('optical_r')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                         </div>
                        <div class="form-group row"> 
                          
 <label for="optical_i" class=" col-md-4 col-form-label text-md-right">{{ __('Optical i') }}</label>
                            <div class="col-md-2">
                                <input id="optical_i" type="number" class="form-control @error('optical_i') is-invalid @enderror" name="optical_i" value="{{ old('optical_i') }}" required autocomplete="optical_i" autofocus>

                                @error('optical_i')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>
                        <div class="form-group row"> -->
                          

                            <div class="col-md-2">
                                <input id="optical_z" type="number" class="form-control @error('optical_z') is-invalid @enderror" name="optical_z" value="{{ old('optical_z') }}" required autocomplete="optical_z" autofocus>
  <label for="optical_z" class="row-md-2">{{ __('Optical z') }}</label>
                                @error('c_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="infrared_three_six" class="col-md-4 col-form-label text-md-right">{{ __('Infrared 3.6') }}</label>

                            <div class="col-md-2">
                                <input id="infrared_three_six" type="number" class="form-control @error('infrared_three_six') is-invalid @enderror" name="infrared_three_six" value="{{ old('infrared_three_six') }}" required autocomplete="infrared_three_six" autofocus>

                                @error('infrared_three_six')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>
                        <div class="form-group row"> -->
                           

                            <div class="col-md-2">
                                <input id="infrared_four_five"  type="number" class="form-control @error('infrared_four_five') is-invalid @enderror" name="infrared_four_five" value="{{ old('infrared_four_five') }}" required autocomplete="infrared_four_five" autofocus>
 <label for="infrared_four_five" class="row-md-2">{{ __('Infrared 4.5') }}</label>
                                @error('infrared_four_five')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>
                        <div class="form-group row"> -->
                          

                            <div class="col-md-2">
                                <input id="infrared_five_eight" type="number" class="form-control @error('infrared_five_eight') is-invalid @enderror" name="infrared_five_eight" value="{{ old('infrared_five_eight') }}" required autocomplete="infrared_five_eight" autofocus>
  <label for="infrared_five_eight" class="row-md-2">{{ __('Infrared 4.8') }}</label>
                                @error('infrared_five_eight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="infrared_eight_zero" class="col-md-4 col-form-label text-md-right">{{ __('Infrared 8.0') }}</label>

                            <div class="col-md-2">
                                <input id="infrared_eight_zero" type="number" class="form-control @error('infrared_eight_zero') is-invalid @enderror" name="infrared_eight_zero" value="{{ old('infrared_eight_zero') }}" required autocomplete="infrared_eight_zero" autofocus>

                                @error('infrared_eight_zero')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>
                        <div class="form-group row"> -->
                            

                            <div class="col-md-2">
                                <input id="infrared_J" type="number" class="form-control @error('infrared_J') is-invalid @enderror" name="infrared_J" value="{{ old('infrared_J') }}" required autocomplete="infrared_J" autofocus>
<label for="infrared_J" class="row-md-2">{{ __('Infrared J') }}</label>
                                @error('infrared_J')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>
                        <div class="form-group row"> -->
                           

                            <div class="col-md-2">
                                <input id="infrared_K" type="number" class="form-control @error('infrared_K') is-invalid @enderror" name="infrared_K" value="{{ old('infrared_K') }}" required autocomplete="infrared_K" autofocus>
 <label for="infrared_K" class="row-md-2">{{ __('Infrared K') }}</label>
                                @error('infrared_K')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="radio_one_four" class="col-md-4 col-form-label text-md-right">{{ __('Radio 1.4') }}</label>

                            <div class="col-md-6">
                                <input id="radio_one_four" type="number" class="form-control @error('radio_one_four') is-invalid @enderror" name="radio_one_four" value="{{ old('radio_one_four') }}" required autocomplete="radio_one_four" autofocus>

                                @error('radio_one_four')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                       

                        <div class="form-group row mb-6">
                            <div class="col-md-20 offset-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Calculate') }}
                                </button>
                            </div>
                        </div>  
                        
 <div class="form-group row">
                            <label for="redshift_result" class="col-md-4 col-form-label text-md-right">{{ __('Redshift') }}</label>
<div class="col-md-6">
                                <input id="redshift_result" type="number" class="form-control @error('redshift_result') is-invalid @enderror" name="redshift_result" value="{{ old('redshift_result') }}" required autocomplete="redshift_result" autofocus>
                              
                                @error('redshift_result')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                            
                        </div>
                        
                        <!-- <div class="form-group row mb-6">
                            <div class="col-md-20 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Show History') }}
                                </button>
                            </div>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
    
 @endsection
