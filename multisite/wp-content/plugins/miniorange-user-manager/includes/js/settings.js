jQuery(document).ready(function () {	
    $ = jQuery;

    $(".mo_wpum_title_panel").click(function () {
        $(this).next(".mo_wpum_help_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpum_help_curl_title").click(function () {
    	jQuery("#mo_wpum_help_curl_desc").slideToggle(400);
    });

    jQuery("#mo_wpum_register_title").click(function () {
        jQuery("#mo_wpum_register_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpum_help_editor").click(function () {
			jQuery("mo_wpum_help_editor_desc").slideToggle(400);
	});
	
	jQuery("#mo_wpum_help_otp_title").click(function () {
    	jQuery("#mo_wpum_help_otp_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpum_question1").click(function () {
    	jQuery("#mo_wpum_question1_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpum_question2").click(function () {
    	jQuery("#mo_wpum_question2_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpum_question3").click(function () {
    	jQuery("#mo_wpum_question3_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpum_question4").click(function () {
    	jQuery("#mo_wpum_question4_desc").slideToggle(400);
    });
    
    $("#wpum_role_edit_dropdown").change(function() {
    	$url = window.location.href;
    	$str = "&role_id";
    	if($url.indexOf($str) != -1){
    		$url = $url.substring(0,$url.indexOf($str));
    	}
    		$url = $url + "&role_id=" +$(this).val();
    	window.location.href = $url;
	});

    $(".overlay").click(function(){
        if($(this).data('action')=="add_role"){
            $(".wpum_modal_background").show();
            $("#add_role").show();
            $("#wpum_role_id").focus();
        }else if($(this).data('action')=="delete_role"){
            $(".wpum_modal_background").show();
            $("#delete_role").show();
        }else if($(this).data('action')=="change_default"){
            $(".wpum_modal_background").show();
            $("#default_role").show();
        }else if($(this).data('action')=="add_cap"){
            $(".wpum_modal_background").show();
            $("#add_cap").show();
            $("#wpum_cap_name").focus();
        }else if($(this).data('action')=="delete_cap"){
            $(".wpum_modal_background").show();
            $("#delete_cap").show();
        }else if($(this).data('action')=="rename_role"){
            $(".wpum_modal_background").show();
            $("#rename_role").show();
        }else if($(this).data('action')=="add_field"){
            $(".wpum_modal_background").show();
            $("#add_field").show();
        }
    });

    $(".cancel").click(function(){
        $(".wpum_modal_background").hide();
        $(".wpum_modal").hide();
    });

    $(".close").click(function(){
        $(".wpum_modal_background").hide();
        $(".wpum_modal").hide();
    });

    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $(".wpum_modal_background").hide();
            $(".wpum_modal").hide();
        }
    });

});
