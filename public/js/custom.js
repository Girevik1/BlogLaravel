jQuery(document).ready(function(){
    jQuery('#ajaxSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: '/sendmail',
            method: 'post',
            data: {
                name: jQuery('#name').val(),
                type: jQuery('#type').val(),
                price: jQuery('#price').val()
            },
            success: function(result){
                jQuery('.alert').show();
                jQuery('.alert').html(result.success);
            }});
    });
});
