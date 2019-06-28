@extends('admin.layouts.admin')

@section('title')
Add Server
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <form method="POST" action="/admin/servers/addServer" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{csrf_field()}}
  
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ip">
                Server IP
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="ip" type="text" value="" class="form-control col-md-7 col-xs-12 " name="ip" required="">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ip">
                Server Domain
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="ip" type="text" value="" class="form-control col-md-7 col-xs-12 " name="domain" required="">
              </div>
            </div>
           
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port">
                Server Port
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="port" type="number" value="" class="form-control col-md-7 col-xs-12 " name="port" required="">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">
                Server User
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="user" type="text" value="" class="form-control col-md-7 col-xs-12 " name="user" required="">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">
                Server Password
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="text" value="" class="form-control col-md-7 col-xs-12 " name="password" required="">
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">
                Server Root Path
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="text" type="text" value="" class="form-control col-md-7 col-xs-12 " name="basePath" required="">
              </div>
            </div>
  
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="active">
                Server Status
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="active" type="checkbox" value="true"  name="active" checked>
              </div>
            </div>
 
  
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-success">Save Server</button>
              </div>
            </div>
 
          </form>
        </div>
    </div>
@endsection
