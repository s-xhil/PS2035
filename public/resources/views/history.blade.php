@extends('layouts.app_boot')
@section('title','History')
@section('content')

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" >
             <div class="container">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                        </li> -->
                        <!-- <li class="nav-item">
                       	 <form class="form-inline mr-auto">
                            @csrf
     						<div class="md-form my-0">
        							<input class="form-control" type="text" placeholder="Search" aria-label="Search">
        							<i class="fas fa-search text-white ml-3" aria-hidden="true"></i>
     				   		</div>
                       	 </form>
      				   </li> -->

   <li class="nav-item">
                 <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <form class="form-inline mr-auto" action="/search" method="POST" role="search">
    @csrf
      <input class="form-control" type="text" placeholder="Search"  name="q" aria-label="Search">
      <button class="btn btn-mdb-color btn-rounded btn-sm my-0 ml-sm-2" type="submit">Search</button>
    </form>

  </div>
</li>



                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" >
                        <!-- Authentication Links -->
                        <li class="nav-item"> <a class="nav-link" href="{{ route('home') }}">Home</a> </li>

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
                    		<li class="nav-item">
                            	<div style = "background: coral; border-radius: 20px;">
                                <a class="nav-link" href="{{ route('csv') }}">{{ __('Download History') }}</a>
                                </div>
                        	</li>


                    </ul>
                </div>
            </div>
        </nav>

<body style="background-image: url('/images/bg1.jpg')">

<div class="overflow-auto">
<div class="table-responsive">

<table class="table table-light">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><a href='/history?galaxy_id'>Galaxy ID</th>
      <th scope="col"><a href='/history?optical_u'>Optical u</th>
     <th scope="col"><a href='/history?optical_g'>Optical g</th>
        <th scope="col"><a href='/history?optical_r'>Optical r</th>
         <th scope="col"><a href='/history?optical_i'>Optical i</th>
          <th scope="col"><a href='/history?optical_z'>Optical z</th>
          <th scope="col"><a href='/history?infrared_three_six'>Infrared 3.6</th>
          <th scope="col"><a href='/history?infrared_four_five'>Infrared 4.5</th>
          <th scope="col"><a href='/history?infrared_five_eight'>Infrared 5.8</th>
          <th scope="col"><a href='/history?infrared_eight_zero'>Infrared 8.0</th>
          <th scope="col"><a href='/history?infrared_J'>Infrared j</th>
          <th scope="col"><a href='/history?infrared_K'>Infrared k</th>
          <th scope="col"><a href='/history?radio_1.4'>Radio 1.4</th>
          <th scope="col"><a href='/history?redshift_result'>Redshift Result</th>


    </tr>
  </thead>
  <tbody>

        @foreach($calculations as $calculation  )
         <tr>
    <th scope="row">{{ $calculation->assigned_calc_id }}</th>
      <td>{{ $calculation->optical_u }}</td>
      <td>{{ $calculation->optical_g }}</td>
     <td>{{ $calculation->optical_r }}</td>
    <td>{{ $calculation->optical_i }}</td>
      <td>{{ $calculation->optical_z }}</td>
      <td>{{ $calculation->infrared_three_six }}</td>
      <td>{{ $calculation->infrared_four_five }}</td>
      <td>{{ $calculation->infrared_five_eight }}</td>
      <td>{{ $calculation->infrared_eight_zero }}</td>
      <td>{{ $calculation->infrared_J }}</td>
      <td>{{ $calculation->infrared_K }}</td>
      <td>{{ $calculation->radio_one_four }}</td>
      <td>{{ $calculation->redshift_result }}</td>
 </tr>
        @endforeach

  </tbody>
</table>
</div>

{{ $calculations->links()}}
</div>

</body>
         @endsection
