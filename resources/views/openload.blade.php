<!-- <!DOCTYPE html>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.14/angular.min.js"></script>
    <script src="http://content.jwplatform.com/libraries/KjECmELD.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="{{asset('assets/admin/js/openLoad.js')}}"></script>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body ng-app='openloadApp' >
<div ng-controller='openloadCtrl'>
 
	<div class="col-sm-12">
		<div class="col-sm-4"> <input class="form-control" type=text placeholder='Openload URL' ng-model='openload_url' ng-change='changeurl()'></input></div>
		<div class="col-sm-4"><input class="form-control" type=text placeholder='File ID' ng-model='fileid' ng-init='fileid="eD_wQ6csFB0"' readonly /></div>
		<div class="col-sm-4"> <button data-ng-click='start()' class="btn btn-primary">Get Stream Link</button></div>
	</div>
   
    
    
   
    
    <div ng-hide='!isStarted' class="col-sm-12">
        {{--<p>|%message%|</p>--}}
        
        <div id='captcha-div' ng-hide='!showCaptcha'>
            <img width=|%captcha_w%| height=|%captcha_h%| src=|%captcha_url%| alt="Captcha image"/>
            <input type=text placeholder='Captcha' ng-model='captcha_response' />
            <button data-ng-click='sendCaptcha()' class="btn btn-primary">Send Captcha</button>
        </div>
        
	      <div class="col-sm-12">
		      <div class="col-sm-1">
			      <p class="label label-success">Link : </p>
		      </div>
		      <div class="col-sm-9">
			      <p class="" id="openLoadLink"> |%message2%| </p>
		      </div>
		      <div class="col-sm-1">
			      <p class="label label-warning" style="cursor: pointer" onclick="" ng-click="copyToClipboard('#openLoadLink')">Copy</p>
		      </div>
	      </div>
        {{--<p><b>Link:</b> <br/> |% message2 %|</p>--}}
        
        <div id="myElement"></div>
    
    
    </div>
</div>
</body>
</html> -->