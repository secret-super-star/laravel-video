(function(angular) {
  'use strict';
  var app = angular.module('openloadApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('|%');
    $interpolateProvider.endSymbol('%|');
  });

  app.controller('openloadCtrl', [
    '$scope', '$http', '$filter', '$window',
    function ($scope, $http, $filter, $window) {

      $scope.ticket = '';
      $scope.isStarted = false;

      var FILE_ID = 'EmleqP5dk8w'; //IB5V77ON1cg, EmleqP5dk8w

      var API_LOGIN = "0c5685460ea012fc"; // 18cd092c6ba63059, 0c5685460ea012fc, f390433282c42d67
      var API_KEY = "AkIMpFMB"; // 5bLMPY0N, AkIMpFMB, fI4LI01v

      var credentials = [];
      var user=[];

      credentials = [{login: '18cd092c6ba63059', key: '5bLMPY0N'},
        {login: '0c5685460ea012fc', key: 'AkIMpFMB'},
        {login: 'f390433282c42d67', key: 'fI4LI01v'},];

      $scope.changeurl = function () {
        // https://openload.co/f/EmleqP5dk8w/matched.mp4 //22,11
        $scope.fileid = $scope.openload_url.substring(22,22+11);
      };

      $scope.start = function () {

        $scope.isStarted = true;
        console.log(credentials);
        var success = false;
        FILE_ID = $scope.fileid;

        angular.forEach(credentials, function(value, key) {
          console.log(value.login);
          $scope.message = "";
          API_LOGIN = value.login;
          API_KEY = value.key;

          var url = 'https://api.openload.co/1/file/dlticket?file='+FILE_ID+'&login='+ API_LOGIN +'&key='+ API_KEY;
          console.log("GET TICKET URL: ");
          console.log(url);

          $scope.showCaptcha = false;

          $http.get(url)
            .then(
              function (response) {
                console.log("GET TICKET RESPONSE: ");
                console.log(response.data);

                if(response.data.status != 200)
                {
                  if(!success) {
                    $scope.message = response.data.msg;
                  }
                }
                else
                {
                  if(success) {
                    return;
                  }
                  $scope.ticket = response.data.result.ticket;
                  $scope.captcha_url = response.data.result.captcha_url;
                  $scope.captcha_w = response.data.result.captcha_w;
                  $scope.captcha_h = response.data.result.captcha_h;

                  success = true;

                  if($scope.captcha_url)
                  {
                    $scope.showCaptchaElements();
                    // $scope.message2 = "Solving Captcha...";
                  }
                  else
                  {
                    $scope.sendCaptcha();
                  }

                  $scope.message = response.data.msg;

                }
              },
              function () {

              }
            );
          if(success) return;
        });

      };

      $scope.sendCaptcha = function () {
        var url = 'https://api.openload.co/1/file/dl?file=' + FILE_ID + '&ticket=' + $scope.ticket + '&captcha_response=' + $scope.captcha_response;
        console.log("GET DLINK URL: ");
        console.log(url);

        $http.get(url)
          .then(
            function (response) {
              console.log("GET DLINK RESPONSE: ");
              console.log(response.data);

              if(response.data.status != 200)
              {
                $scope.message2 = response.data.msg;
                return;
              }
              else
              {
                $scope.message2 = response.data.result.url;
                var download_url = $scope.message2;

                var playerInstance = jwplayer("myElement");
                playerInstance.setup({
                  file: download_url,
                  type: "mp4",
                  width:200,
                  height:150,
                });
              }
            },
            function () {

            }
          );
      };

      $scope.showCaptchaElements = function () {
        $scope.showCaptcha = true;
      };

      $scope.copyToClipboard = function (element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        alert('copied');
      }

    }
  ]);

})(window.angular);