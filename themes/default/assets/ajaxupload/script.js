$(function(){

    var ul = $('#photo_form div#uploadBox');

    // Initialize the jQuery File Upload plugin
    $('#photo_form').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#photo_form'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {
			
			var tpl = $('<div class="ar"><input type="hidden" id="imageName" name="image" value="" /><p></p><span></span></div><div class="an"></div>');
			
			$(this).removeClass('_up').addClass('_hash').addClass('_clicked').unbind('click');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
					tpl.find('a#remBut').click();
					//$('#selectForm').html('');
					$('._clicked').removeClass('_clicked').removeClass('_hash').addClass('_up');
					clickButton();
                    tpl.remove();
                });

            });

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },

        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if(progress == 100){
                data.context.removeClass('working');
            }
        },

        fail:function(e, data){
            // Something has gone wrong!
            data.context.addClass('error');
        },
		
		done: function(e, data) { alert(data.result);
			var fileData = jQuery.parseJSON(data.result);
			
			if(fileData.status == 'error') {
				
				var tpl = '<div class="error">'+fileData.message+'</div>';
				ele.prepend(tpl);
				
			} else {
			
				var ele = $('div#uploadBox div.ar');
				ele.find('canvas').remove();
				ele.find('input#imageName').val(fileData.image);
				
				var tpl = '<img src="'+fileData.file+'" alt="" /><a href="#" class="ajaxButton" data-url="'+fileData.removeUrl+'" id="remBut"></a>';
				ele.prepend(tpl);
				
				loadMore();
			}
		}

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }
	
	clickButton();

});

function clickButton() {
	$('#uploadBox a._up').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
		var upl = $(this).parent().find('input.upload');
		upl.attr('accept', $(this).attr('data-type'));
        upl.click();
    });
}