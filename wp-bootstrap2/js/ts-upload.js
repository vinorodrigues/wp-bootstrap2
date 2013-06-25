/**
 * Thanks to Ignacio Cruz Moreno
 * @see http://wp.tutsplus.com/tutorials/creative-coding/how-to-integrate-the-wordpress-media-uploader-in-theme-and-plugin-options/
 */

jQuery(document).ready(function($){
	// Prepare variables.
	var ts_media_formlabel;

	// Show Open Media buttons if they are hidden
	$('.ts-open-media').show();

	// Bind to click event in order to open up the upload manager.
	$(document.body).on('click.tsUploadManager', '.ts-open-media', function(e){

		// Prevent the default action from occuring.
		e.preventDefault();
		ts_media_formlabel = jQuery(this).parent();

		var tb_url = 'media-upload.php?referer='+ts_upload.referer+'&type=file&post_id=0&TB_iframe=true';
		tb_show(ts_upload.title, tb_url, false);
	});

	window.send_to_editor = function(html) {
		var media_attachment_url = $('img',html).attr('src');
		if ( !media_attachment_url ) media_attachment_url = $(html).attr('src');

		var inputfield = ts_media_formlabel.find('input[type="url"]');
		if ( inputfield.length == 0 ) inputfield = ts_media_formlabel.find('input[type="text"]');
		if ( inputfield.length > 0 ) inputfield.val(media_attachment_url);
		else alert('Both <input> and <button> should be enclosed in one <label> tag.');

		tb_remove();
	}
});
