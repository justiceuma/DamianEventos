$wcfm_enquiry_submited=!1;jQuery(document).ready(function($){if($('.enquiry-form').length>1){$('.enquiry-form')[1].remove()}
$enquiry_form_show=!1;$('.add_enquiry').click(function(){if($enquiry_form_show){$('.enquiry_form_wrapper_hide').slideUp("slow");$enquiry_form_show=!1}else{$('.enquiry_form_wrapper_hide').slideDown("slow");$enquiry_form_show=!0}});$('#wcfm_enquiry_submit_button').click(function(event){event.preventDefault();$wcfm_enquiry_submited=!1;wcfm_enquiry_form_submit($(this).parent().parent())});$('.wcfm_catalog_enquiry, .wcfm_store_enquiry').each(function(){$(this).click(function(event){event.preventDefault();$.colorbox({inline:!0,href:"#enquiry_form_wrapper",width:$popup_width,onComplete:function(){$wcfm_enquiry_submited=!1;jQuery(document).ajaxComplete(function(){if($wcfm_enquiry_submited){setTimeout(function(){$wcfm_enquiry_submited=!1;$.colorbox.remove()},2000)}})},})})});function wcfm_enquiry_form_validate($enquiry_form){$is_valid=!0;jQuery('.wcfm-message').html('').removeClass('wcfm-success').removeClass('wcfm-error').slideUp();var enquiry_comment=jQuery.trim($enquiry_form.find('#enquiry_comment').val());if(enquiry_comment.length==0){$is_valid=!1;$enquiry_form.find('.wcfm-message').html('<span class="wcicon-status-cancelled"></span>'+wcfm_enquiry_manage_messages.no_enquiry).addClass('wcfm-error').slideDown()}
if($enquiry_form.find('#enquiry_author').length>0){var enquiry_author=jQuery.trim($enquiry_form.find('#enquiry_author').val());if(enquiry_author.length==0){if($is_valid)
$enquiry_form.find('.wcfm-message').html('<span class="wcicon-status-cancelled"></span>'+wcfm_enquiry_manage_messages.no_name).addClass('wcfm-error').slideDown();else $enquiry_form.find('.wcfm-message').append('<br /><span class="wcicon-status-cancelled"></span>'+wcfm_enquiry_manage_messages.no_name).addClass('wcfm-error').slideDown();$is_valid=!1}}
if($enquiry_form.find('#enquiry_email').length>0){var enquiry_email=jQuery.trim($enquiry_form.find('#enquiry_email').val());if(enquiry_email.length==0){if($is_valid)
$enquiry_form.find('.wcfm-message').html('<span class="wcicon-status-cancelled"></span>'+wcfm_enquiry_manage_messages.no_email).addClass('wcfm-error').slideDown();else $enquiry_form.find('.wcfm-message').append('<br /><span class="wcicon-status-cancelled"></span>'+wcfm_enquiry_manage_messages.no_email).addClass('wcfm-error').slideDown();$is_valid=!1}}
$wcfm_is_valid_form=$is_valid;$(document.body).trigger('wcfm_form_validate',$enquiry_form);$is_valid=$wcfm_is_valid_form;return $is_valid}
function wcfm_enquiry_form_submit($enquiry_form){$is_valid=wcfm_enquiry_form_validate($enquiry_form);if($is_valid){$enquiry_form.block({message:null,overlayCSS:{background:'#fff',opacity:0.6}});var data={action:'wcfm_ajax_controller',controller:'wcfm-enquiry-tab',wcfm_enquiry_tab_form:$enquiry_form.serialize(),status:'submit'}
jQuery.post(wcfm_params.ajax_url,data,function(response){if(response){$response_json=jQuery.parseJSON(response);$enquiry_form.find('.wcfm-message').html('').removeClass('wcfm-success').removeClass('wcfm-error').slideUp();wcfm_notification_sound.play();if($response_json.status){$enquiry_form.find('.wcfm-message').html('<span class="wcicon-status-completed"></span>'+$response_json.message).addClass('wcfm-success').slideDown("slow");setTimeout(function(){jQuery('.enquiry_form_wrapper_hide').slideUp("slow");$enquiry_form_show=!1;$enquiry_form.find('.wcfm-message').html('').removeClass('wcfm-success').removeClass('wcfm-error').slideUp();$enquiry_form.find('#enquiry_comment').val('')},2000);$wcfm_enquiry_submited=!0}else{$enquiry_form.find('.wcfm-message').html('<span class="wcicon-status-cancelled"></span>'+$response_json.message).addClass('wcfm-error').slideDown()}
if(jQuery('.wcfm_gglcptch_wrapper').length>0){if(typeof grecaptcha!="undefined"){grecaptcha.reset()}}
$enquiry_form.unblock()}})}}})