/**
 * Created by ahsan on 17/06/17.
 */
//	$(function () {
window.isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
	|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

$(function () {
	$('#parent_category').on('change', function () {
		if ($(this).prop('checked')) {
			$('#parent_category_name_div').hide('slow');
		} else {
			$('#parent_category_name_div').show('slow');
		}
	});
	
	$('#datatable_wrapper').dataTable({
		responsive: true
	});
	
	if (!window.isMobile) {
		window.oldIndex;
		// Sortable rows
		$('.sorted_table').sortable({
			containerSelector: 'table',
			itemPath: '> tbody',
			itemSelector: 'tr',
			placeholder: '<tr class="placeholder"/>',
			onDragStart: function ($item, container, _super) {
				window.oldIndex = $item.index();
				// alert(oldIndex);
			},
			onDrop: function ($item, container, _super) {
				var newIndex = $item.index();
				
				
				console.log($item.data('id'));
				console.log('old index' + window.oldIndex);
				console.log('newIndex index' + newIndex);
				
				var form = new FormData();
				form.append("newIndex", newIndex);
				form.append("id", $item.data('id'));
				form.append("_token", window.token);
				form.append("oldIndex", window.oldIndex);
				
				var settings = {
					"async": true,
					"crossDomain": true,
					"url": "categories/updateCustomOrder",
					"method": "POST",
					"headers": {},
					"processData": false,
					"contentType": false,
					"mimeType": "multipart/form-data",
					"data": form
				}
				
				$.ajax(settings).done(function (response) {
					console.log(response);
				});
			}
		});
	}
	
	$('#category').on('change', function () {
		var settings = {
			"async": true,
			"crossDomain": true,
			"url": "/api/subcategories/"+$(this).val(),
			"method": "POST",
			"headers": {
			},
			"processData": false,
			"contentType": false,
			"mimeType": "multipart/form-data",
			"data": ''
		}
		
		$.ajax(settings).done(function (response) {
			response = JSON.parse(response);
			console.log(response.data);
			var html = '';
			$.map(response.data.sub_categories, function (val, i) {
				console.log(val.category_title);
				html+= "<option value='"+val.id+"'> "+val.category_title+" </option>";
			});
			console.log('html:'+html);
			$('#subcategory').html(html);
		});
	})
	
	$('#celeb').on('change', function () {
		var form = new FormData();
		form.append("id", this.value);
		postRequest(form, '/api/celebrities/getCelebrityDetail', function (err, data) {
			var html = '';
			$.map(data.data.celebrities_videos, function (val, key) {
				var name = val.series_detail && val.series_detail.name ? val.series_detail.name : 'N/A';
				var id = val.series_detail && val.series_detail.id ? val.series_detail.id : '0';
				html += "<option value='"+id+"' > "+name+" </option>";
			});
			
			$('#celebrityVideo').html(html)
		})
	});
	
	$('#editceleb').on('change', function () {
		var form = new FormData();
		form.append("id", this.value);
		postRequest(form, '/api/celebrities/getCelebrityDetail', function (err, data) {
			console.log('response is' + JSON.stringify(data.data.celebrities_videos));
			var html = '';
			$.map(data.data.celebrities_videos, function (val, key) {
				console.log(val.series_detail.name);
				html += "<option value='"+val.series_detail.id+"' > "+val.series_detail.name+" </option>";
			});
			
			$("select").select2('val', '');
			$('#celebrityVideo').html(html)
		})
	});
	
	$('#celebrityVideo').select2({
		placeholder: 'Select Celebrity Videos'
	});
	
	$('#places').on('change', function () {
		var name_urd = $(this).find(':selected').attr('data-name');
		$('#placeName').val(name_urd);
	});
	$('#cities').on('change', function () {
		var id = this.value;
		
		var form = new FormData();
		form.append("city_id", id);
		
		var settings = {
			"url": '/api/getPlaces',
			"contentType":false,
			"cache": false,
			"processData":false,
			"method": "POST",
			"data": form
		};
		
		$.ajax(settings).done(function (response) {
			console.log(response);
			var html = "<option value='' > Select Place </option>";
			$.map(response.data, function (val, key) {
				html += "<option value='"+val.id+"' data-name='"+val.name_urd+"' > "+val.name+" </option>";
			});
			if (response.data.length < 1) {
				html += "<option value='' > No Places Found </option>";
			}
			$('#places').html(html);
		});
		
		var name_urd = $(this).find(':selected').attr('data-name');
		$('#cityName').val(name_urd);
	});
	
	$('#date_recorded').datepicker({
		'format' : 'd/m/yyyy'
	});
	$('#islamic_calender').datepicker({
		calendar: $.calendars.instance('islamic'),
	});
});

function postRequest(data, url, cb) {
	
	var settings = {
		"url": url,
		"contentType":false,
		"cache": false,
		"processData":false,
		"method": "POST",
		"data": data
	};
	
	$.ajax(settings).done(function (response) {
		console.log(response);
		cb(null, response);
	});
}

function previewFile() {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById("category_image").files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById("thumb").src = oFREvent.target.result;
		$('#thumb').css('width', '100px');
		$('#thumb').css('height', '100px');
	};
}

function previewFileBySrc(id, src) {
	var oFReader = new FileReader();
	oFReader.readAsDataURL(document.getElementById(id).files[0]);
	oFReader.onload = function (oFREvent) {
		document.getElementById(src).src = oFREvent.target.result;
		$('#thumb').css('width', '100px');
		$('#thumb').css('height', '100px');
	};
}



/*Videos Module JS Starts Here*/
$(function () {
	function showHide() {
		if($(this).val() == 1) {
			$(this).closest('div.local').show();
			$(this).closest('div.outsource').hide();
		} else {
			$(this).closest('div.local').hide();
			$(this).closest('div.outsource').show();
		}
		$('.actions').show('show');
	}
	
	$('body').on('change', '.sourceType', function() {
		var val = $(this).val();
		if (parseInt(val) == 1) {
			$(this).parent().parent().children('.showHideClass').children('span.local').css('display', 'block');
			$(this).parent().parent().children('.showHideClass').children('span.outsource').css('display', 'none');
		} else {
			$(this).parent().parent().children('.showHideClass').children('span.local').css('display', 'none');
			$(this).parent().parent().children('.showHideClass').children('span.outsource').css('display', 'block');
		}
	});
	
	
	
	$('.addMore').on('click', function (e) {
		var src = $(this).parent().children('input#src').val();
		var len = (($('#videoDiv_src'+src).find('.videoDivInner')).length);
		var showHideDiv = $('#videoDivInner').clone().children().closest('div.col-md-3.showHideClass');
		(showHideDiv.children().closest('span.local').hide());
		(showHideDiv.children().closest('span.outsource').show());
		var button = $('#videoDivInner').clone().attr('id', 'videoDivInner_'+len).after("#videoDivInner");;
		
		button.children('div.col-md-3.showHideClass').children('span.outsource').children().attr('name', 'uploadFile'+src+'[]')
		console.log(button.children('div.col-md-3.sourceTypeDiv').children('select#sourceType.form-control.sourceType').attr('name', 'sourceType'+src+'[]'));
		// button.children('div.col-md-3.sourceTypeDiv').children().attr('name', 'sourceType'+src+'[]')
		button.children('div.col-md-3.showHideClass').children('span.local').children('input').attr('name', 'textSource'+src+'[]');
		$('#videoDiv_src'+src).append(button);
		
		/*Clearing Test For Newly Created TextBox*/
		button.children().closest('div.col-md-3.showHideClass').children().closest('span.local').children().val('');
		
		
		$('#videoDivInner_' + len+'.col-md-12.col-md-offset-1.videoDivInner').children().closest('.showHideClass').children().closest('span.local').show();
		$('#videoDivInner_' + len+'.col-md-12.col-md-offset-1.videoDivInner').children().closest('.showHideClass').children().closest('span.outsource').hide();
		
		($('#videoDivInner_' + len + '.col-md-12.col-md-offset-1.videoDivInner').children().closest('.sourceTypeDiv').children().closest('.sourceType').prop('selectedIndex', 1));
		
		
	});
	
	$("body").delegate(".removeMe", "click", function(){
		var src = $(this).parent().children('input#srcRemove').val();
		var len = (($('#videoDiv_src'+src).find('.videoDivInner')).length);
		if (len > 1) {
			$(this).parent().closest('div.videoDivInner').remove();
		}
	});
	
	$(".js-example-basic-multiple").select2({
		placeholder: "Select"
	});

//  for edit
	
	$("body").delegate(".removeMeNow", "click", function(){
		
		var src = $(this).parent().children('input#srcRemove').val();
		var len = (($('#videoDiv_src'+src).find('.videoDivInner')).length);
		
		if (len > 1) {
			var r = window.confirm('Are you sure you want to remove this video from database')
			if (r == true) {
				$(this).parent().closest('div.videoDivInner').remove();
				var data = $(this).parent().closest('div.videoDivInner').data('obj');
				var settings = {
					"async": true,
					"crossDomain": true,
					"url": "/admin/removeSeriesVideo/" + data.id,
					"method": "GET",
					"headers": {}
				}
				
				$.ajax(settings).done(function (response) {
					console.log(response);
				});
			}
		}
	})
	
});

function reTest(id) {
	var settings = {
		"async": true,
		"crossDomain": true,
		"url": "/admin/recheckSFTP?id="+id,
		"method": "GET",
		"headers": {
		}
	}
	
	$.ajax(settings).done(function (response) {
		console.log(response);
		console.log(response.status);
		if (response.status == false) {
			$('#server_sftp_status_'+id).html('<span style="color: red"> Failure </span>');
		} else {
			$('#server_sftp_status_'+id).html('<span style="color: green"> Successful</span>');
		}
	});
}