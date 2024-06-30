$(document).ready(function () {
    $('.js-ajax').change(function () {
        let regionId = $(this).val();
        let element = $(this);

        $.ajax({
            url: element.data('url') + regionId,
            method: 'GET',
            success: function (response) {
                var cities = response;
                var citiesDropdown = $('#' + element.data('child'));
                citiesDropdown.empty(); //
                $.each(cities, function (index, row) {
                    citiesDropdown.append(
                        $('<option></option>').val(row.id).text(row.name)
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    });

    $(".js-confirm").on("click", function (e) {
        element = $(this);
        e.preventDefault();
        Swal.fire({
            title: element.data('title'),
            text: element.data('text'),
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si,eliminar!",
            cancelButtonText: "Ni loco",
            preConfirm: async () => {
                try {
                    const url = element.attr('href')
                    const response = await fetch(url);
                    if (!response.ok) {
                        return Swal.showValidationMessage(`
                          ${JSON.stringify(await response.json().message)}
                        `);
                    }
                    return response.json();
                } catch (error) {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: result.value.title,
                    text: result.value.message
                });
                element.parents('tr')
                    .addClass('table-danger')
                    .hide('show')
            }
        });
    });

    $(".js-status").on("click", function (e) {
        element = $(this);
        e.stopImmediatePropagation();
        e.preventDefault();
        try {
            const url = element.attr('href')
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta');
                    }
                    return response.json();
                })
                .then(response => {
                    element.text(response.label);
                    Swal.fire({
                        title: "Notificación!",
                        text: response.message,
                        icon: "success"
                    });
                })
                .catch(error => {
                    throw new Error('Error en la respuesta');
                });

        } catch (error) {
            Swal.fire({
                title: "Notificación!",
                text: 'Error',
                icon: "error"
            });

        }
        return false;
    });


    $('.js-new-row').on("click", function (e) {
        var tr    = $(this).parents('tr')
        var clone = tr.clone();
        clone.find(':text').val('')
             .prop('required',true);
        clone.find('.hidden').removeClass('hidden');
        clone.find('.js-new-row').addClass('hidden');
        tr.after(clone)
    });




    $(document).on('click', '.js-remove-element', function (e) {
        let row =  $(this).parents('.element');
        row.fadeOut(500, function() {
            $(this).remove();
        });
    });


    $(document).on('click', '.js-remove-row', function (e) {
        let tr = $(this).parents('tr')
        tr.remove()
    });



});
