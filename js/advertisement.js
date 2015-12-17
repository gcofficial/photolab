jQuery(document).on(
    "click", 
    ".upload_image_button",  
    function(e){
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var $button = jQuery(this);
        wp.media.editor.send.attachment = function(props, attachment){
            $button.prev('input').val(attachment.sizes[props.size].url);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open($button);
        return false;
    }
);