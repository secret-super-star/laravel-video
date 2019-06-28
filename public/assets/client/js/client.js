/**
 * Created by ahsan on 19/07/17.
 */

function redirectMe(id){
  var link = $('#linkMe_'+id).val()
  window.location = '/video/'+link;
}

function redirectMeForGroup(id){
  var link = $('#linkMe_'+id).val()
  window.location = '/groups/'+link.toLowerCase();
}

function redirectMeWithPart(id, part){
  var link = $('#linkMe_'+id).val()
  window.location = '/video/'+link+'/?p='+part;
}


function previewFileWithSrc(id, src) {
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById(id).files[0]);
  oFReader.onload = function (oFREvent) {
    document.getElementById(src).src = oFREvent.target.result;
    $('#thumb').css('width', '100px');
    $('#thumb').css('height', '100px');
  };
}

function likeMe(id, action) {
  var form = new FormData();
  form.append("vid_id", id);
  form.append("action", action);
  form.append("_token", $('#_token').val());

  var settings = {
    "async": true,
    "crossDomain": true,
    "url": "/likeVideo",
    "method": "POST",
    "headers": {
      "cache-control": "no-cache",
    },
    "processData": false,
    "contentType": false,
    "mimeType": "multipart/form-data",
    "data": form
  };

  $.ajax(settings).done(function (response) {
    var response = JSON.parse(response);
    console.log((response.status));
    if (response.status == 'success') {
        $('#like_'+id).toggle();
        $('#unlike_'+id).toggle();
    }
  });
}

$(function () {
  $('#banner').on('change', function () {
    previewFileWithSrc('banner', 'bannerThumb')
  });

  $('#avatar').on('change', function () {
    previewFileWithSrc('avatar', 'avatarThumb')
  });
});