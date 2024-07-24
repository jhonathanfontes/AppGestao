$(document).ready(function () {

    // CARREGA DADOS DA TELA DE COLABORADORES
    var colaboradoresColumnDefs = [
        { className: "dt-body-center", targets: [2, 3, 4, 5, 6] }
    ];
    var colaboradoresOrder = [
        [6, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableColaboradores", base_url + "api/rh/tabela/colaboradores", colaboradoresColumnDefs, colaboradoresOrder);
});

// GERENCIA OS PESSOAS
function getEditColaborador(Paramentro) {
    $.ajax({
        "url": base_url + "api/cadastro/exibir/colaborador/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleColaborador').innerHTML = 'EDITANDO CADASTRO DO ' + dado.cad_nome;
            $('#id').val(dado.cod_colaborador);
            $('#cod_colaborador').val(dado.cod_colaborador);
            $('#cad_tipocolaborador').val(dado.cad_tipocolaborador).trigger("change");
            $('#cad_natureza').val(dado.cad_natureza).trigger("change");
            if (dado.cad_natureza == 'F') {
                $('#cad_documento').val(mascaraCpf(dado.cad_cpf));
            }
            if (dado.cad_natureza == 'J') {
                $('#cad_documento').val(mascaraCnpj(dado.cad_cnpj));
            }
            $('#cad_nascimeto').val(dado.cad_nascimeto);
            $('#cad_rg').val(dado.cad_rg);
            $('#cad_nome').val(dado.cad_nome);
            $('#cad_apelido').val(dado.cad_apelido);
            $('#cad_cep').val(dado.cad_cep);
            $('#cad_endereco').val(dado.cad_endereco);
            $('#cad_numero').val(dado.cad_numero);
            $('#cad_setor').val(dado.cad_setor);
            $('#cad_cidade').val(dado.cad_cidade);
            $('#cad_estado').val(dado.cad_estado);
            $('#cad_complemento').val(dado.cad_complemento);
            $('#cad_telefone').val(dado.cad_telefone);
            $('#cad_celular').val(dado.cad_celular);
            $('#cad_email').val(dado.cad_email);
            $('#pes_profissao').val(dado.cod_profissao).trigger("change");
            if (dado.status == '1') {
                document.getElementById("colaboradorAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("colaboradorInativo").checked = true;
            }
        }
    });
}

function setNewColaborador() {
    document.getElementById('modalTitleColaborador').innerHTML = 'CADASTRO DE NOVO COLABORADOR';
    var cod_colaborador = document.getElementById('cod_colaborador').value;
    if (cod_colaborador != '') {
        document.getElementById("id").value = '';
        document.getElementById("cod_colaborador").value = '';
        $('#cad_tipocolaborador').val(1).trigger("change");
        $('#cad_natureza').val('F').trigger("change");
        document.getElementById("cad_documento").value = '';
        document.getElementById("cad_nascimeto").value = '';
        document.getElementById("cad_rg").value = '';
        document.getElementById("cad_nome").value = '';
        document.getElementById("cad_apelido").value = '';
        document.getElementById("cad_cep").value = '';
        document.getElementById("cad_endereco").value = '';
        document.getElementById("cad_numero").value = '';
        document.getElementById("cad_setor").value = '';
        document.getElementById("cad_cidade").value = '';
        document.getElementById("cad_estado").value = '';
        document.getElementById("cad_complemento").value = '';
        document.getElementById("cad_telefone").value = '';
        document.getElementById("cad_celular").value = '';
        document.getElementById("cad_email").value = '';
    }
}

function SalvaColaborador() {
    $("#formColaborador").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formColaborador').attr('action'),
                type: "POST",
                data: $('#formColaborador').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarColaborador").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarColaborador").disabled = false;
                }
            });
        }
    });

    $('#formColaborador').validate({
        rules: {
            cad_nome: {
                required: true,
            },
        },
        messages: {
            cad_nome: {
                required: "O Nome deve ser informada!",
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
