jQuery(document).ready(function(){
    jQuery('.mo_media_restriction_redirect_radio').click(function(){
        var inputValue = jQuery(this).attr("value");
        var targetBox = jQuery("#" + inputValue + "-select");
        jQuery(".mo_media_restriction_select").not(targetBox).hide();
        jQuery(targetBox).show();
    });

    jQuery("#mo_enable_media_restriction").click(function(){
        jQuery("#mo_enable_media_restriction_form").submit();
    });
    
    jQuery("#mo_media_restriction_contact_us_phone").intlTelInput();
});


function mo_media_restriction_contact_us_valid_query(f) {
    !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(
        /[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
}

function mo_media_restriction_rules_confirmation(){
    document.getElementById("confirmation-popup").style.display = "block";
}

function mo_media_restriction_rules_alert_box(status,form_id){
    if(status == true){
        document.getElementById("mo_media_restriction_show_rules").value = 0;
    }else{
        document.getElementById("mo_media_restriction_show_rules").value = 1;
    }
    document.getElementById(form_id).submit();
}

function mo_media_restrict_display_folder(mo_media_restriciton_folder_id){
    jQuery( "#"+mo_media_restriciton_folder_id ).toggleClass( "active" );
    jQuery( "#"+mo_media_restriciton_folder_id+"-i" ).toggleClass( "active" );
}

function mo_media_restrict_delete_file(filename){
    var r = confirm("Are you sure you want to delete this item?");
    if (r == true) {
        document.getElementById("mo_media_restrict_filename").value = filename;
        document.getElementById("mo_media_restriction_delete_file").submit();
    }
}