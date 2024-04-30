$(document).ready(function () {

    // CARREGA DADOS DA TELA DE BANCOS
    // Configuração da tabela "tableBancos"
    var bancosColumnDefs = [
        { className: "dt-body-center", targets: 0 },
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 }
    ];
    var bancosOrder = [
        [2, "desc"],
        [0, "asc"]
    ];
    initializeDataTable("#tableBancos", base_url + "api/configuracao/tabela/bancos", bancosColumnDefs, bancosOrder);

    // CARREGA DADOS DA TELA DE BANDEIRAS
    // Configuração da tabela "tableBandeira"
    var bandeiraColumnDefs = [
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 }
    ];
    var bandeiraOrder = [
        [2, "desc"],
        [0, "asc"]
    ];
    initializeDataTable("#tableBandeira", base_url + "api/configuracao/tabela/bandeiras", bandeiraColumnDefs, bandeiraOrder);

    // CARREGA DADOS DA TELA DOS CONTA BANCARIA
    // Configuração da tabela "tableContaBancaria"
    var contaBancariaColumnDefs = [
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 }
    ];
    var contaBancariaOrder = [
        [1, "desc"],
        [0, "asc"]
    ];
    initializeDataTable("#tableContaBancaria", base_url + "api/configuracao/tabela/contasbancarias", contaBancariaColumnDefs, contaBancariaOrder);

    // CARREGA DADOS DA TELA DOS Forma Pagamento
    // Configuração da tabela "tableFormaPagamento"
    var formaPagamentoColumnDefs = [
        { className: "dt-body-justify", targets: 0 },
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 },
        { className: "dt-body-center", targets: 3 },
        { className: "dt-body-center", targets: 4 },
        { className: "dt-body-center", targets: 5 }
    ];
    var formaPagamentoOrder = [
        [1, "desc"],
        [0, "asc"]
    ];
    initializeDataTable("#tableFormaPagamento", base_url + "api/configuracao/tabela/formaspagamentos", formaPagamentoColumnDefs, formaPagamentoOrder);

    // CARREGA DADOS DA TELA DOS Maquina Cartao
    // Configuração da tabela "tableMaquinaCartao"
    var maquinaCartaoColumnDefs = [
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 }
    ];
    var maquinaCartaoOrder = [
        [1, "desc"],
        [0, "asc"]
    ];
    initializeDataTable("#tableMaquinaCartao", base_url + "api/configuracao/tabela/maquinascartoes", maquinaCartaoColumnDefs, maquinaCartaoOrder);

    // CARREGA DADOS DA TELA DE EMPRESAS
    // Configuração da tabela "tableEmpresa"
    var empresaOrder = [
        [0, "desc"]
    ];
    initializeDataTable("#tableEmpresa", base_url + "api/configuracao/tabela/empresas", [], empresaOrder);

    // CARREGA DADOS DA TELA DE GRUPO DE ACESSO
    // Configuração da tabela "tableGrupoAcesso"
    var grupoAcessoOrder = [
        [0, "asc"]
    ];
    initializeDataTable("#tableGrupoAcesso", base_url + "api/configuracao/tabela/gruposdeacesso", [], grupoAcessoOrder);

    // CARREGA DADOS DA TELA DE EMPRESAS
    // Configuração da tabela "tableUsuarios"
    var usuariosOrder = [
        [0, "desc"]
    ];
    initializeDataTable("#tableUsuarios", base_url + "api/configuracao/tabela/usuarios", [], usuariosOrder);

    // CARREGA DADOS DA TELA DE VENDEDORES
    // Configuração da tabela "tableVendedor"
    var vendedorColumnDefs = [
        { className: "dt-body-center", targets: 0 },
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 },
        { className: "dt-body-center", targets: 3 },
        { className: "dt-body-center", targets: 4 },
        { className: "dt-body-center", targets: 5 },
        { className: "dt-body-center", targets: 6 }
    ];
    var vendedorOrder = [
        [5, "desc"],
        [1, "asc"]
    ];
    initializeDataTable("#tableVendedor", base_url + "api/configuracao/tabela/vendedores", vendedorColumnDefs, vendedorOrder);

});

// MODULO AUXILIAR FINANCEIRO 

$('#cad_cnpj').change(function () {
    var cod_empresa = document.getElementById('cod_empresa').value;
    if (cod_empresa === '') {
        carregaCnpjEmpresa();
    }
});


function carregaCnpjEmpresa() {
    var cad_cnpj = document.getElementById('cad_cnpj').value;
    var cnpj = cad_cnpj.replace(/[^\d]+/g, '');

    $.ajax({
        url: `https://www.receitaws.com.br/v1/cnpj/${cnpj}`,
        type: "GET",
        dataType: 'jsonp',
        success: function (dado) {
            if (dado.nome == undefined) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                toastr.error('CNPJ Não encontrado, Preencha Manualmente');
            } else {
                document.getElementById("cad_razao").value = dado.nome;
                document.getElementById("cad_fantasia").value = dado.fantasia;
                document.getElementById("cad_cep").value = dado.cep;
                document.getElementById("cad_cidade").value = dado.municipio;
                document.getElementById("cad_uf").value = dado.uf;
                document.getElementById("cad_bairo").value = dado.bairro;
                document.getElementById("cad_endereco").value = dado.logradouro;
                document.getElementById("cad_complemento").value = dado.complemento;
                document.getElementById("cad_telefone").value = dado.telefone;
                document.getElementById("cad_email").value = dado.email;
            }
        }
    });
}

function getEditBanco(Paramentro) {

    $.ajax({
        "url": base_url + "api/configuracao/exibir/banco/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {

            document.getElementById('modalTitleBanco').innerHTML = 'ATUALIZANDO O BANCO ' + dado.cad_banco;
            $('#cod_banco').val(dado.cod_banco);
            $('#cad_codigo').val(dado.cad_codigo);
            $('#cad_banco').val(dado.cad_banco);
        }
    });
}

function setNewBanco() {
    document.getElementById('modalTitleBanco').innerHTML = 'CADASTRO DE NOVO BANCO';
    var cod_Banco = document.getElementById('cod_banco').value;
    if (cod_Banco != '') {
        document.getElementById("cod_banco").value = '';
        document.getElementById("cad_codigo").value = '';
        document.getElementById("cad_banco").value = '';
    }
}

function salvarBanco() {
    $("#formBanco").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formBanco').attr('action'),
                type: "POST",
                data: $('#formBanco').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarBanco").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarBanco").disabled = false;
                }
            });
        }
    });

    $('#formBanco').validate({
        rules: {
            cad_codigo: {
                required: true,
            },
            cad_banco: {
                required: true,
            },
        },
        messages: {
            cad_codigo: {
                required: "O Codigo do banco deve ser informada!",
            },
            cad_banco: {
                required: "O Nome do banco deve ser informada!",
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

function getEditMaquinaCartao(Paramentro) {
    $.ajax({
        "url": base_url + "api/configuracao/exibir/maquinacartao/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleMaquinaCartao').innerHTML = 'ATUALIZANDO A MAQUINA DE CARTÃO ' + dado.cad_maquinacartao;
            $('#cod_maquinacartao').val(dado.cod_maquinacartao);
            $('#cad_maquinacartao').val(dado.cad_maquinacartao);
            if (dado.status == '1') {
                document.getElementById("maquinacartaoAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("maquinacartaoInativo").checked = true;
            }
        }
    });
}

function setNewMaquinaCartao() {
    document.getElementById('modalTitleMaquinaCartao').innerHTML = 'CADASTRO DE NOVA MAQUINA DE CARTÃO';
    var cod_maquinacartao = document.getElementById('cod_maquinacartao').value;
    if (cod_maquinacartao != '') {
        document.getElementById("cod_maquinacartao").value = '';
        document.getElementById("cad_maquinacartao").value = '';
        document.getElementById("maquinacartaoAtivo").checked = true;
    }
}

function salvarMaquinaCartao() {
    $("#formMaquinaCartao").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formMaquinaCartao');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formMaquinaCartao').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarMaquinaCartao").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarMaquinaCartao").disabled = false;
                }
            });
        }
    });

    $('#formMaquinaCartao').validate({
        rules: {
            cad_maquinacartao: {
                required: true,
            },
        },
        messages: {
            cad_maquinacartao: {
                required: "O nome da maquininha deve ser informada!",
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

function getEditContaBancaria(Paramentro) {
    $.ajax({
        "url": base_url + "api/configuracao/exibir/contabancaria/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleContaBancaria').innerHTML = 'ATUALIZANDO A CONTA ' + dado.cad_contabancaria;

            document.getElementById("cod_contabancaria").value = dado.cod_contabancaria;
            $('#cad_banco').val(dado.cad_banco).trigger('change');
            document.getElementById("cad_agencia").value = dado.cad_agencia;
            document.getElementById("cad_conta").value = dado.cad_conta;
            document.getElementById("cad_contabancaria").value = dado.cad_contabancaria;
            $('#cad_tipo').val(dado.cad_tipo).trigger('change');
            $('#cad_empresa').val(dado.cad_empresa).trigger('change');
            $('#cad_pagamento').val(dado.cad_pagamento).trigger('change');
            $('#cad_recebimento').val(dado.cad_recebimento).trigger('change');
            $('#cad_natureza').val(dado.cad_natureza).trigger('change');
            document.getElementById("cad_titular").value = dado.cad_titular;
            document.getElementById("cad_documento").value = dado.cad_documento;
            if (dado.status == '1') {
                document.getElementById("contabancariaAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("contabancariaInativo").checked = true;
            }
        }
    });
}

function setNewContaBancaria() {

    document.getElementById('modalTitleContaBancaria').innerHTML = 'CADASTRO DE NOVA CONTA BANCARIA';
    var cod_contabancaria = document.getElementById('cod_contabancaria').value;
    if (cod_contabancaria != '') {
        document.getElementById("cod_contabancaria").value = '';
        $('#cad_banco').val('').trigger('change');
        document.getElementById("cad_agencia").value = '';
        document.getElementById("cad_conta").value = '';
        document.getElementById("cad_contabancaria").value = '';
        $('#cad_tipo').val('C').trigger('change');
        $('#cad_empresa').val('').trigger('change');
        $('#cad_pagamento').val('S').trigger('change');
        $('#cad_recebimento').val('S').trigger('change');
        $('#cad_natureza').val('F').trigger('change');
        document.getElementById("cad_titular").value = '';
        document.getElementById("cad_documento").value = '';
        document.getElementById("contabancariaAtivo").checked = true;
    }
}

function salvarContaBancaria() {
    $("#formContaBancaria").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formContaBancaria');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formContaBancaria').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarContaBancaria").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarContaBancaria").disabled = false;
                }
            });
        }
    });

    $('#formContaBancaria').validate({
        rules: {
            cad_contabancaria: {
                required: true,
            },
        },
        messages: {
            cad_contabancaria: {
                required: "O nome da maquininha deve ser informada!",
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

function getEditFormaPagamento(Paramentro) {
    $.ajax({
        "url": base_url + "api/configuracao/exibir/formapagamento/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleFormaPagamento').innerHTML = 'ATUALIZANDO A FORMA DE PAGAMENTO: ' + dado.cad_descricao;

            document.getElementById("cod_formapagamento").value = dado.cod_forma;
            document.getElementById("cad_descricao").value = dado.cad_descricao;
            $('#cad_forma').val(dado.cad_forma).trigger('change');
            $('#cad_maquininha').val(dado.cod_maquinacartao).trigger('change');
            $('#cad_conta').val(dado.cad_conta).trigger('change');
            $('#cad_parcela').val(dado.cad_parcela).trigger('change');
            $('#cad_antecipa').val(dado.cad_antecipa).trigger('change');
            document.getElementById("cad_fprazo").value = dado.cad_fprazo;
            document.getElementById("cad_ftaxa").value = dado.cad_ftaxa;

            if (dado.status == '1') {
                document.getElementById("formapagamentoAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("formapagamentoInativo").checked = true;
            }
        }
    });
}

function setNewFormaPagamento() {
    document.getElementById('modalTitleFormaPagamento').innerHTML = 'CADASTRO DE NOVA FORMA DE PAGAMENTO';
    var cod_formapagamento = document.getElementById('cod_formapagamento').value;
    if (cod_formapagamento != '') {
        document.getElementById("cod_formapagamento").value = '';
        document.getElementById("cad_descricao").value = '';

        $('#cad_forma').val(1).trigger('change');
        $('#cad_maquininha').val('').trigger('change');
        $('#cad_parcela').val('N').trigger('change');
        $('#cad_antecipa').val('N').trigger('change');
        document.getElementById("formapagamentoAtivo").checked = true;

    }
}

function salvarFormaPagamento() {
    $("#formFormaPagamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formFormaPagamento');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formFormaPagamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarFormaPagamento").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarFormaPagamento").disabled = false;
                }
            });
        }
    });

    $('#formFormaPagamento').validate({
        rules: {
            cad_maquinacartao: {
                required: true,
            },
        },
        messages: {
            cad_maquinacartao: {
                required: "O nome da maquininha deve ser informada!",
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

$('#cad_forma').change(function () {
    var cad_forma = document.getElementById('cad_forma').value
    if (cad_forma == 3 || cad_forma == 4) {
        document.getElementById("container-cartao").hidden = false;
    } else {
        document.getElementById("container-cartao").hidden = true;
    }
});

$('#cad_parcela').change(function () {
    var cad_parcela = document.getElementById('cad_parcela').value
    if (cad_parcela == 'N') {
        document.getElementById("container-taxaPrazo").hidden = false;
    } else {
        document.getElementById("container-taxaPrazo").hidden = true;
    }
});

function getEditEmpresa(Paramentro) {

    $.ajax({
        "url": base_url + "api/configuracao/exibir/empresa/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {

            document.getElementById('modalTitleEmpresa').innerHTML = 'ATUALIZANDO A EMPRESA ' + dado.cad_razao;
            $('#cod_empresa').val(dado.cod_empresa);
            $('#cad_razao').val(dado.cad_razao);
            $('#cad_fantasia').val(dado.cad_fantasia);

            document.getElementById("cad_slogan").value = dado.cad_slogan;
            document.getElementById("cad_cnpj").value = dado.cad_cnpj;
            document.getElementById("cad_cep").value = dado.cad_cep;
            document.getElementById("cad_cidade").value = dado.cad_cidade;
            document.getElementById("cad_uf").value = dado.cad_uf;
            document.getElementById("cad_bairo").value = dado.cad_bairo;
            document.getElementById("cad_endereco").value = dado.cad_endereco;
            document.getElementById("cad_complemento").value = dado.cad_complemento;
            document.getElementById("cad_telefone").value = dado.cad_telefone;
            document.getElementById("cad_email").value = dado.cad_email;
        }
    });
}

function setNewEmpresa() {
    document.getElementById('modalTitleEmpresa').innerHTML = 'CADASTRO DE NOVA EMPRESA';
    var cod_empresa = document.getElementById('cod_empresa').value;
    if (cod_empresa != '') {
        $('#formEmpresa')[0].reset();
    }
}

function salvarEmpresa() {
    $("#formEmpresa").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formEmpresa').attr('action'),
                type: "POST",
                data: $('#formEmpresa').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarEmpresa").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarEmpresa").disabled = false;
                }
            });
        }
    });

    $('#formEmpresa').validate({
        rules: {
            cad_razao: {
                required: true,
            },
            cad_fantasia: {
                required: true,
            },
        },
        messages: {
            cad_razao: {
                required: "A razão deve ser informada!",
            },
            cad_fantasia: {
                required: "O Nome fantasia deve ser informado!",
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

function getEditBandeira(Paramentro) {
    $.ajax({
        "url": base_url + "api/configuracao/exibir/bandeira/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleBandeira').innerHTML = 'ATUALIZANDO A BANDEIRA ' + dado.cad_bandeira;
            $('#cod_bandeira').val(dado.cod_bandeira);
            $('#cad_bandeira').val(dado.cad_bandeira);
            if (dado.status == '1') {
                document.getElementById("bandeiraAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("bandeiraInativo").checked = true;
            }
        }
    });
}

function setNewBandeira() {
    document.getElementById('modalTitleBandeira').innerHTML = 'CADASTRO DE NOVA BANDEIRA';
    var cod_bandeira = document.getElementById('cod_bandeira').value;
    if (cod_bandeira != '') {
        document.getElementById("cod_bandeira").value = '';
        document.getElementById("cad_bandeira").value = '';
        document.getElementById("bandeiraAtivo").checked = true;
    }
}

function salvarBandeira() {
    $("#formBandeira").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formBandeira');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formBandeira').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarBandeira").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarBandeira").disabled = false;
                }
            });
        }
    });

    $('#formBandeira').validate({
        rules: {
            cad_bandeira: {
                required: true,
            },
        },
        messages: {
            cad_bandeira: {
                required: "O nome da maquininha deve ser informada!",
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

function carregaParcelamentoBandeira(cod_forma, cod_bandeira) {
    const table = $("#tableFormaPagamentoParcelamento").DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        processing: true,
        ajax: {
            type: "POST",
            url: base_url + "api/configuracao/tabela/formasparcelamentos",
            data: { cod_forma, cod_bandeira },
            dataType: "json",
            async: true
        },
        columnDefs: [
            { className: "dt-body-center", targets: [0, 1, 2] }
        ],
        order: [[0, 'asc']]
    });

    // Destruir a tabela anterior antes de inicializar uma nova
    table.destroy();
}

function getParcelamentoBandeiraSelecionado(cod_forma, cod_bandeira) {
    $.get(base_url + 'api/configuracao/exibir/formasparcelamentos/bandeira/' + cod_forma + '/' + cod_bandeira, {
    }, function (response) {
        options = '<option value="">SELECIONE UMA PARCELA</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].parcela + '">' + response[i].parcela + '</option>';
        }
        $('#cad_parcela').html(options);
    });
}

function salvarParcelamentoBandeira() {
    $("#formFormaParcelamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formFormaParcelamento').attr('action'),
                type: "POST",
                data: $('#formFormaParcelamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("incluirFormaParcelamento").disabled = true;
                },
                success: function (response) {
                    var cod_forma = response.data.forma_id;
                    var cod_bandeira = response.data.bandeira_id;
                    if (response.status === true) {
                        carregaParcelamentoBandeira(cod_forma, cod_bandeira);
                        getParcelamentoBandeiraSelecionado(cod_forma, cod_bandeira);
                        document.getElementById("incluirFormaParcelamento").disabled = false;
                    }
                },
                error: function () {
                    document.getElementById("incluirFormaParcelamento").disabled = false;
                }
            });
        }
    });

    $('#formFormaParcelamento').validate({
        rules: {
            cad_parcela: {
                required: true,
            },
            cad_prazo: {
                required: true,
            },
            cad_taxa: {
                required: true,
            },
        },
        messages: {
            cad_parcela: {
                required: "A parcela deve ser selecionada!",
            },
            cad_prazo: {
                required: "O prazo deve ser informado!",
            },
            cad_taxa: {
                required: "A taxa deve ser informada!",
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

function gerenciarParcelamentoBandeira(cod_forma, cod_bandeira) {
    document.getElementById('modalTitleFormasParcelamentos').innerHTML = 'ATUALIZANDO O PARCELAMENTO DO CARTÃO';
    $.get(base_url + 'api/configuracao/exibir/formasparcelamentos/' + cod_forma + '/' + cod_bandeira, {
    }, function (response) {
        const formFormasAtributos = document.querySelector("#formFormasAtributos");
        for (var i = 0; i < response.length; i++) {

            console.log(response[i]);
        }

    });
}

function getEditVendedor(Paramentro) {
    $.ajax({
        "url": base_url + "api/configuracao/exibir/vendedor/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleVendedor').innerHTML = 'ATUALIZANDO O VENDEDOR ' + dado.pessoa;
            $('#cod_vendedor').val(dado.cod_vendedor);
            $('#cod_pessoa').val(dado.cod_pessoa).trigger('change');
            $('#cod_usuario').val(dado.cod_usuario).trigger('change');

            if (dado.status == '1') {
                document.getElementById("vendedorAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("vendedorInativo").checked = true;
            }
        }
    });
}

function setNewVendedor() {
    document.getElementById('modalTitleVendedor').innerHTML = 'CADASTRO DE NOVO BANCO';
    var cod_vendedor = document.getElementById('cod_vendedor').value;
    if (cod_vendedor != '') {
        document.getElementById("cod_vendedor").value = '';
        document.getElementById("cod_pessoa").value = '';
        document.getElementById("cod_usuario").value = '';
        document.getElementById("vendedorAtivo").checked = true;
    }
}

function salvarVendedor() {
    $("#formVendedor").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formVendedor').attr('action'),
                type: "POST",
                data: $('#formVendedor').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarVendedor").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarVendedor").disabled = false;
                }
            });
        }
    });

    $('#formVendedor').validate({
        rules: {
            cod_pessoa: {
                required: true,
            },
            cod_usuario: {
                required: true,
            },
        },
        messages: {
            cod_pessoa: {
                required: "A Pessoa deve ser informada!",
            },
            cod_usuario: {
                required: "O Usuario deve ser informada!",
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

function getArquivar(Paramentro, Codigo) {
    showConfirmationDialog('Deseja Realmente Arquivar Este Registro?', 'Este Lançamento Não Poderá Ser Desfeito!', 'Sim, Arquivar!')
        .then((confirmed) => {
            if (confirmed) {
                executeAction(base_url + "api/configuracao/arquivar/", Paramentro, Codigo);
            }
        });
}

function getCancelar(Paramentro, Codigo) {
    showConfirmationDialog('Deseja Realmente Cancelar Este Registro?', 'Este Lançamento Não Poderá Ser Desfeito!', 'Sim, Cancelar!')
        .then((confirmed) => {
            if (confirmed) {
                executeAction(base_url + "api/configuracao/cancelar/", Paramentro, Codigo);
            }
        });
}

// GERENCIAMENTO DO USUARIO
function newGrupoAcesso() {
    document.getElementById('modalTitleGrupoAcesso').innerHTML = 'CADASTRO DE GRUPO DE USUÁRIO - PERMISSÕES DE ACESSO';
    var cod_gruposdeacesso = document.getElementById('cod_gruposdeacesso').value;
    if (cod_gruposdeacesso != '') {
        document.getElementById("cod_gruposdeacesso").value = '';
        document.getElementById("cad_grupodeacesso").value = '';
    }
}

function getEditGrupoAcesso(Paramentro) {
    $.ajax({
        "url": base_url + "api/configuracao/exibir/grupodeacesso/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleGrupoAcesso').innerHTML = 'ATUALIZANDO O GRUPO DE USUÁRIO - ' + dado.cad_permissao;
            $('#cod_gruposdeacesso').val(dado.cod_permissao);
            $('#cad_grupodeacesso').val(dado.cad_permissao);
        }
    });
}

function salvarGrupoAcesso() {
    $("#formGrupoAcesso").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formGrupoAcesso').attr('action'),
                type: "POST",
                data: $('#formGrupoAcesso').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarGrupoAcesso").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarGrupoAcesso").disabled = false;
                }
            });
        }
    });

    $('#formGrupoAcesso').validate({
        rules: {
            cad_grupodeacesso: {
                required: true,
            },
        },
        messages: {
            cad_grupodeacesso: {
                required: "A DESCRIÇÃO DO GRUPO DE ACESSO DEVE SER INFORMADA!",
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

function getEditUsuario(Paramentro) {
    $.ajax({
        "url": base_url + "api/configuracao/exibir/usuario/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleUsuario').innerHTML = 'ATUALIZANDO O USUARIO - ' + dado.cad_apelido;
            $('#cod_usuario').val(dado.cod_usuario);
            $('#cad_nome').val(dado.cad_usuario);
            $('#cad_apelido').val(dado.cad_apelido);
            $('#cad_telefone').val(dado.cad_telefone);
            $('#cad_email').val(dado.cad_email);
            $('#cad_permissao').val(dado.permissao_id).trigger('change');
            $('#cad_sexo').val(dado.cad_sexo).trigger('change');
            $('#cad_username').val(dado.cad_username);
            document.getElementById("pes_container-alterar").hidden = false;
            if (dado.status == '1') {
                document.getElementById("usuarioAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("usuarioInativo").checked = true;
            }
        }
    });
}

function setNewUsuario() {
    document.getElementById('modalTitleUsuario').innerHTML = 'CADASTRO DE NOVO USUARIO';
    var cod_usuario = document.getElementById('cod_usuario').value;
    if (cod_usuario != '') {
        document.getElementById("cod_usuario").value = '';
        document.getElementById("cad_nome").value = '';
        document.getElementById("cad_apelido").value = '';
        document.getElementById("cad_telefone").value = '';
        document.getElementById("cad_email").value = '';
        $('#cad_permissao').val('').trigger('change');
        $('#cad_sexo').val('F').trigger('change');
        document.getElementById("cad_username").value = '';
        document.getElementById("cad_password").value = '';
        document.getElementById("confirm_password").value = '';
        document.getElementById("usuarioAtivo").checked = true;
        document.getElementById("pes_container-alterar").hidden = true;
    }
}

function salvarUsuario() {
    $("#formUsuario").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formUsuario').attr('action'),
                type: "POST",
                data: $('#formUsuario').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitSalvarUsuario").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response);
                },
                error: function () {
                    document.getElementById("submitSalvarUsuario").disabled = false;
                }
            });
        }
    });

    $('#formUsuario').validate({
        rules: {
            cad_nome: {
                required: true,
            },
            cad_apelido: {
                required: true,
            },
            cad_email: {
                required: true,
            },
            cad_username: {
                required: true,
            },
            cad_permissao: {
                required: true,
            },
            cad_sexo: {
                required: true,
            }
        },
        messages: {
            cad_nome: {
                required: "O NOME DEVE SER INFORMADA!",
            },
            cad_apelido: {
                required: "O APELIDO DEVE SER INFORMADA!",
            },
            cad_email: {
                required: "O E-MAIL DEVE SER INFORMADA!",
            },
            cad_username: {
                required: "O USERNAME DEVE SER INFORMADA!",
            },
            cad_permissao: {
                required: "SELECIONE UM GRUPO DE PERMISSÃO!",
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

function alterarSenhaUsuario() {
    document.getElementById('modalTitleSenhaUsuario').innerHTML = 'ALTERAR A SENHA DO ' + document.getElementById("cad_nome").value;
    $('#use_password').val(document.getElementById("cod_usuario").value);
}

function salvarSenhaUsuario() {
    $("#formSenhaUsuario").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formSenhaUsuario').attr('action'),
                type: "POST",
                data: $('#formSenhaUsuario').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitSalvarSenhaUsuario").disabled = true;
                },
                success: function (response) {
                    console.log(response);
                    // respostaSwalFire(response);
                },
                error: function () {
                    document.getElementById("submitSalvarSenhaUsuario").disabled = false;
                }
            });
        }
    });

    var cad_password = document.getElementById("cad_password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    jQuery.validator.addMethod('validatePassword', function (value, element) {
        if (cad_password != confirm_password) {
            return (this.optional(element) || false);
        }
        return (this.optional(element) || true);
    }, 'CONFIRMAÇÃO DE SENHA NÃO CONFERE!');

    $('#formSenhaUsuario').validate({
        rules: {
            cod_usuario: {
                required: true,
            },
            cad_password: {
                required: true,
            },
            confirm_password: {
                required: true,
                validatePassword: true,
            },
        },
        messages: {
            cad_password: {
                required: "A SENHA DEVE SER INFORMADA!",
            },
            confirm_password: {
                required: "A CONFIRMAÇÃO DE SENHA DEVE SER INFORMADA!",
            }
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

function verificaForcaSenha() {
    var numeros = /([0-9])/;
    var alfabetoa = /([a-z])/;
    var alfabetoA = /([A-Z])/;
    var chEspeciais = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

    if ($('#cad_password').val().length < 6) {
        $('#password-status').html("<span style='color:red'>Insira no mínimo 6 caracteres</span>");
    } else {
        if ($('#cad_password').val().match(numeros) && $('#cad_password').val().match(alfabetoa) && $('#cad_password').val().match(alfabetoA) && $('#cad_password').val().match(chEspeciais)) {
            $('#password-status').html("<span style='color:green'><b>Forte</b></span>");
        } else {
            $('#password-status').html("<span style='color:orange'>Médio</span>");
        }
    }
}

function getPermissaoUsuarioOption() {
    $.get(base_url + 'api/configuracao/exibir/gruposdeacesso', {
    }, function (response) {
        options = '<option value="">SELECIONE UMA PERMISSÃO</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].cod_permissao + '">' + response[i].cad_permissao + '</option>';
        }
        $('#cad_permissao').html(options);
    });
}

const cadPasswordInput = document.getElementById("cad_password");
const btnEyePassword = document.getElementById("btnEyePassword");

const confirmPasswordInput = document.getElementById("confirm_password");
const btnEyeConfirm = document.getElementById("btnEyeConfirm");

function mostrarPassword() {
    let inputTypeIsPassword = cadPasswordInput.type == 'password';
    if (inputTypeIsPassword) {
        cadPasswordInput.setAttribute('type', 'text');
        btnEyePassword.setAttribute('class', 'fa fa-eye');
    } else {
        cadPasswordInput.setAttribute('type', 'password');
        btnEyePassword.setAttribute('class', 'fa fa-eye-slash');
    }
}

function mostrarConfirm() {
    let inputTypeIsConfirm = confirmPasswordInput.type == 'password';
    if (inputTypeIsConfirm) {
        confirmPasswordInput.setAttribute('type', 'text');
        btnEyeConfirm.setAttribute('class', 'fa fa-eye');
    } else {
        confirmPasswordInput.setAttribute('type', 'password');
        btnEyeConfirm.setAttribute('class', 'fa fa-eye-slash');
    }
}