(function( $ ) {
	'use strict'; 

	// delete post on dblclick 
	$(document).on( 'dblclick', '.single-task-container', function(e) { 
		e.preventDefault(); 

        var id = $(this).data('id');
        var nonce = $(this).data('nonce'); 

        $.ajax({
            type: 'POST',
            url: '../wp-admin/admin-ajax.php',  
            data: {
                action: 'mpc_delete_post',
                nonce: nonce,
                id: id
            },
            success: function( result ) { 
                if( result == 'success' ) {
					$(this).remove(); 


                     item.fadeOut( function(){
						$(this).remove();
						
                    }); 
                }
				$(".tasksList").load(location.href +" .tasksList  > * ");  
				$(".info ").html( "<p>Task deleted</p>"+result );
            },
			error: function(e) {
				console.log(e);
			}
        })
		 
        return false;
    }); 
	
	// change/update 'checked' status/icon 
	$(document).on( 'click', '.update_is_checked', function(e) {
		e.preventDefault();

        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
		var field = $(this).data('field'); 
		var val = $(this).val(); 
			  
        $.ajax({
            type: 'POST',
            url:  '../wp-admin/admin-ajax.php',  
            data: {
                action: 'mpc_save_meta_boxes_data',
                nonce: nonce,
                id: id,
				field: field
            }, 
            success: function( result ) { 
                if( result == 'success' ) { 
					 console.log(result); 
                }
 
				$(".tasksList").load(location.href +" .tasksList  > * ");  

				$(".info ").html( "<p>Task updated</p>"+result );
            },
			error: function(e) {
				console.log(e);
			}
        })
		 
        return false;
    });

	// mpc_save_new_post 
	$(document).on( 'keydown', '#title', function(e) {  
		//e.preventDefault(); 
			var title = $('#title').val();
			var nonce = $("#taskAddNonce").val();
			var is_checked=''; 

			if (e.which === 13) {  
			
				if($("#is_checked").is(':checked')) 
					is_checked = 'checked'; 
				  
			 
			if (title!='') {
				$.ajax({
					type: 'POST',
					url:   '../wp-admin/admin-ajax.php',  
					data: {
						action: 'mpc_save_new_post',
						title: title , 
						nonce: nonce,
						is_checked: is_checked 
					},
		
					success: function( result ) {    
							$(".tasksList").load(location.href +" .tasksList > * ");  
							$(".info ").html( "<p>New task added</p>"+result );
						
					},
					error: function(e) {
						console.log(e);
					}
				})
			} else $(".info ").html( "<p>Empty task</p>" );
			 
			return false;  
		}
		 
	  }); 
	   
	

// new update title
// keydown  
$(document).on( 'change', '.update-post', function(e) {
	
	//e.preventDefault();
	var title = $(this).val(); 
	var id = $(this).data('id'); 
	var nonce = $(this).data('nonce'); 
	  
        $.ajax({
            type: 'POST',
            url:  '../wp-admin/admin-ajax.php',  
            data: {   
                action: 'mpc_update_post',
				title: title,
				id: id,
                nonce: nonce
                 
            }, 
            success: function( result ) { 
                if( result == 'success' ) { 
					 console.log(result);
                } 
				$(".info ").html( "<p>Task updated</p>"+result );
            },
			error: function(e) {
				console.log(e);
			} 
        }); 
		
        return false; 
 
 });  
 
	
})( jQuery );