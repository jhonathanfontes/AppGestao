$(document).ready(function () {
    // CARREGA DADOS DA TELA DAS OBRAS
    var pessoasColumnDefs = [
        { className: "dt-body-center", targets: [0, 1, 2] }
    ];
    var pessoasOrder = [
        [0, 'asc']
    ];
    initializeDataTable("#tableObras", base_url + "api/projeto/tabela/obras", pessoasColumnDefs, pessoasOrder);
});

// GERENCIAMENTO DAS OBRAS
function getEditObra(Paramentro) {
    $.ajax({
        "url": base_url + "api/projeto/exibir/obra/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleObra').innerHTML = 'ATUALIZANDO A PROFISSÃO ' + dado.cad_obra;
            $('#cod_obra').val(dado.cod_obra);
            $('#cad_obra').val(dado.cad_obra);
            $('#cad_datainicio').val(dado.cad_datainicio);
        }
    });
}

function setNewObra() {
    document.getElementById('modalTitleObra').innerHTML = 'CADASTRO DE NOVA OBRA';
    var cod_obra = document.getElementById('cod_obra').value;
    if (cod_obra != '') {
        document.getElementById("cod_obra").value = '';
        document.getElementById("cad_obra").value = '';
        document.getElementById("cad_datainicio").value = '';
    }
}

function salvarObra() {
    $("#formObra").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formObra').attr('action'),
                type: "POST",
                data: $('#formObra').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarObra").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarObra").disabled = false;
                }
            });
        }
    });

    $('#formObra').validate({
        rules: {
            cad_obra: {
                required: true,
            },
        },
        messages: {
            cad_obra: {
                required: "A descricção deve ser informada!",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
}




