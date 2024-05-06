$(document).ready(function () {
    // CARREGA DADOS DA TELA DAS OBRAS
    var pessoasColumnDefs = [
        { className: "dt-body-center", targets: [0, 1, 2] }
    ];
    var pessoasOrder = [
        [0, 'asc']
    ];
    initializeDataTable("#tableObras", base_url + "api/projeto/tabela/obras", pessoasColumnDefs, pessoasOrder);

    //Quando o campo cep perde o foco.
    $('#cad_cep').change(function () {

        //Nova variável "cep" somente com dígitos.
        var cad_cep = $(this).val().replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cad_cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if (validacep.test(cad_cep)) {
                //Desabilita os campos enquanto consulta webservice.
                document.getElementById("cad_endereco").disabled = true;
                document.getElementById("cad_bairo").disabled = true;
                document.getElementById("cad_cidade").disabled = true;
                document.getElementById("cad_uf").disabled = true;

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cad_cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        showConfirmationDialog('FOI LOCALIZADO OS DADOS REFERENTE AO CEP ' + cad_cep + '!', 'DESEJA ATUALIZAR OS DADOS!', 'Sim, Atualizar!')
                            .then((confirmed) => {
                                if (confirmed) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#cad_endereco").val(dados.logradouro);
                                    $("#cad_bairo").val(dados.bairro);
                                    $("#cad_cidade").val(dados.localidade);
                                    $("#cad_uf").val(dados.uf);
                                }
                            });
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        $(function () {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $(function () {
                                toastr.error('CEP não encontrado.');
                                campoTexto.value = '';
                            });
                        });
                    }
                    // Habilita após a consulta
                    document.getElementById("cad_endereco").disabled = false;
                    document.getElementById("cad_bairo").disabled = false;
                    document.getElementById("cad_cidade").disabled = false;
                    document.getElementById("cad_uf").disabled = false;
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                $(function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $(function () {
                        toastr.error('Formato de CEP inválido.');
                        campoTexto.value = '';
                    });
                });
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
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




