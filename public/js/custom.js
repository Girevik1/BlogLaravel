jQuery(document).ready(function(){
    jQuery('#ajaxSubmit').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: '/ajax',
            method: 'POST',
            data: {
                name: jQuery('#name').val(),
                type: jQuery('#type').val(),
                price: jQuery('#price').val()
            },
            success: function(result){
                console.log(333);
                jQuery('.alert').show();
                jQuery('.alert').html(result.success);
            }});
    });
});
