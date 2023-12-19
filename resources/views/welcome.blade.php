@extends('layouts.app')

@section('content')
<section id="home" name="home"></section>
<div id="headerwrap">
    <div class="container">
        <div class="row text-center text-white">
            <div class="col-lg-12">
         <!--        <h1><b><a>Smedia</a></b></h1> -->
              <!--   <h3>A video conference application</h3> -->
                <h3><a href="{{ url('/login') }}" class="btn btn-lg btn-success">Get Started!</a></h3><br>
            </div>
        </div>
    </div> <!--/ .container -->
</div><!--/ #headerwrap -->

@endsection
