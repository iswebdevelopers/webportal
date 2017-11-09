$( function() {
    
    var token = $('#token').val();
    $("#supplier_box").autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "/portal/supplier/search/" + request.term + "/?token=" + token,
          // dataType: "jsonp",
          success: function( data ) {
            response($.map((data.data), function (item) {                                
                var AC = new Object();

                //autocomplete default values REQUIRED
                AC.label = item.name;
                AC.value = item.id;

                return AC
            }));   
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("Something has gone wrong. Please refresh."); 
          }
        });
      },
      minLength: 3,
      select: function (event, ui) {                    
        $('#extra-fields input[name=role_id]').val(ui.item.id);
     }     
    });

  $("button#btn_delete").on('click',function(){
  	var btn = $(this);
    $.confirm({
	    title: 'Are you sure?',
	    buttons: {
	        confirm: function () {
	        	console.log(btn);
	            btn.parent().parent().remove();
	        },
	        cancel: function () {
	            
	        }
    	}
	});
    
  });

  //initial set up
  $("div", "div#extra-fields").hide();
  $("#extra-fields input[name=role_id]").prop('disabled',true);

  $("select#role").change(function(){
        // hide previously shown in target div
        $("div", "div#extra-fields").hide();
        
        // read id from your select
        var value = $(this).val();
        // show element with selected id
        $("div#"+value).show();
        $("div#"+value+" input[name=role_id]").prop('disabled',false)
    });

  $('.venbobox').venobox({
        framewidth: '500px',        
        frameheight: 'auto',       
        border: '10px',             
        titleattr: 'Password Recovery',
  });

  $("#users-list").DataTable({
    "sPaginationType": "full_numbers",
    "bPaginate":true,
    "iDisplayLength": 10,
    "searching": true,
    "ordering": false
  });

  $("#printfiles").DataTable({
    "sPaginationType": "full_numbers",
    "bPaginate":true,
    "iDisplayLength": 10,
    "searching": false,
    "ordering": false
  });
});

