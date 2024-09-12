$(document).ready(function() {
    $('#tahun_ajaran').change(function() {
        var tahunAjaranId = $(this).val();
        var tingkatan = $('#tingkatan').val();

        $.ajax({
            url: '/get-kelas-by-tahun-ajaran-and-tingkatan',
            type: 'GET',
            data: {
                tahun_ajaran_id: tahunAjaranId,
                tingkatan: tingkatan
            },
            success: function(response) {
                updateDropdownKelas(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $('#tingkatan').change(function() {
        var tahunAjaranId = $('#tahun_ajaran').val();
        var tingkatan = $(this).val();

        $.ajax({
            url: '/get-kelas-by-tahun-ajaran-and-tingkatan',
            type: 'GET',
            data: {
                tahun_ajaran_id: tahunAjaranId,
                tingkatan: tingkatan
            },
            success: function(response) {
                updateDropdownKelas(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    function updateDropdownKelas(kelas) {
        var dropdown = $('#kelas');
        dropdown.empty(); // Kosongkan dropdown
        kelas.forEach(function(k) {
            dropdown.append($('<option>').text(k).attr('value', k));
        });
    }
});