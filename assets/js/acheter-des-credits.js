$(function(){

    $('#btn-switch-money').on('click', function() {
        if ($('#span-switch-money-1').html() == 'EUR') {
            $('#span-switch-money-1').html('Crédits');
            $('#span-switch-money-2').html('EUR');
        } else {
            $('#span-switch-money-1').html('EUR');
            $('#span-switch-money-2').html('Crédits');
        }
    })

    $('#input-switch-money-1').on('keyup', function() {
        if ($('#span-switch-money-1').html() == 'EUR') {
            let val = $('#input-switch-money-1').val() * 50;
            $('#input-switch-money-2').val(val);
        } else {
            let val = $('#input-switch-money-1').val() / 50;
            $('#input-switch-money-2').val(val);
        }
            
    })
});
