$(document).ready(function() {
    $('.js-ajax').change(function() {
        let regionId = $(this).val();
        let element = $(this);

        $.ajax({
            url: element.data('url') + regionId,
            method: 'GET',
            success: function(response) {
                var cities = response;
                var citiesDropdown = $('#' + element.data('child'));
                citiesDropdown.empty(); //
                $.each(cities, function(index, row) {
                    citiesDropdown.append(
                        $('<option></option>').val(row.id).text(row.name)
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    });
});
