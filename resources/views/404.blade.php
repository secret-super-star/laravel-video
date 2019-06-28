@extends('client.layouts.app')

@section('content')
   
   <style>
      .minh500 {
         min-height: 500px
      }
   </style>
   
   <div class="row minh500">
      <div class="col-sm-9 center text-center col-sm-offset-1 colorWhite">
            <h1 >{{\Config::get('app.name')}}</h1>
         <h2>The Page You're looking for doesn't exist</h2>
      </div>
   </div>
@endsection