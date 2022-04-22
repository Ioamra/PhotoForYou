$(function(){

    $('#btn-switch-money').on('click', function() {
        if ($('#span-switch-money-1').html() == 'EUR') {
        //* Si EUR to CR, devient CR to EUR
            $('#span-switch-money-1').html('Crédits');
            $('#span-switch-money-2').html('EUR');
            $('#form-achat').html(
                '<div class="mb-3">'+
                    '<label for="rib" class="form-label">RIB</label>'+
                    '<input type="text" class="form-control" name="rib">'+
                '</div>');


            //* Convertion du prix
            let val = $('#input-switch-money-1').val() / 50;
            $('#input-switch-money-2').val(val);
        } else {
        //* Si CR to EUR, devient EUR to CR
            $('#span-switch-money-1').html('EUR');
            $('#span-switch-money-2').html('Crédits');
            $('#form-achat').html(
                '<div class="mb-3">'+
                    '<label for="nom-carte" class="form-label">Nom du détenteur de la carte</label>'+
                    '<input type="text" class="form-control" name="nom-carte" pattern="[a-zA-Zéè]{3,15}">'+
                '</div>'+
                '<div class="mb-3">'+
                    '<label for="num-carte" class="form-label">Numéros de la carte</label>'+
                    '<input type="int" class="form-control" name="num-carte" pattern="[0-9]{16}">'+
                '</div>'+
                '<div class="mb-3">'+
                    '<label for="date-carte" class="form-label">Date d\'expiration</label>'+
                    '<input type="text" class="form-control" name="date-carte" pattern="[0-9/]{5}">'+
                '</div>'+
                '<div class="mb-3">'+
                    '<label for="num-secu-carte" class="form-label">Code de sécurité</label>'+
                    '<input type="int" class="form-control" name="num-secu-carte" pattern="[0-9]{3}">'+
                '</div>');


            //* Convertion du prix
            let val = $('#input-switch-money-1').val() * 50;
            $('#input-switch-money-2').val(val);
        }
    })

    //* Convertion du prix
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
