@extends('admin.layouts.admin')

@section('title')
Edit {{$servers->ip}}
@endsection

@section('content')
  
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <form method="POST" action="/admin/servers/updateServers" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left">
            {{csrf_field()}}
  
            <input type="hidden" name="server_id" value="{{$servers->id}}">
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ip">
                Server IP
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="ip" type="text" value="{{$servers->ip}}" class="form-control col-md-7 col-xs-12 " name="ip" required="">
              </div>
            </div>
  
  
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ip">
                Server Domain
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="ip" type="text" value="{{$servers->domain}}" class="form-control col-md-7 col-xs-12 " name="domain" required="">
              </div>
            </div>
  
  
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port">
                Server Port
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="port" type="number" value="{{$servers->port}}" class="form-control col-md-7 col-xs-12 " name="port" required="">
              </div>
            </div>
    
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">
                Server User
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="user" type="text" value="{{$servers->user}}" class="form-control col-md-7 col-xs-12 " name="user" required="">
              </div>
            </div>
    
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">
                Server Password
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="text" value="{{$servers->password}}" class="form-control col-md-7 col-xs-12 " name="password" required="">
              </div>
            </div>
  
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">
                Server Root Path
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="text" type="text" value="{{$servers->sftp_root_path or ''}}" class="form-control col-md-7 col-xs-12 " name="basePath" required="">
              </div>
            </div>
    
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="active">
                Server Status
                <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  $active = $servers->active == 1 ? 'checked' : '';
                ?>
                <input id="active" type="checkbox" value="true"  name="active" {{$active}}>
              </div>
            </div>
    
    
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-success">Update Server</button>
              </div>
            </div>
  
          </form>
        </div>
    </div>
@endsection
