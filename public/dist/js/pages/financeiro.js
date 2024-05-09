$(document).ready(function () {

    // CARREGA DADOS DA TELA DE CONTA A PAGAR
    var contaPagarColumnDefs = [
        { className: "dt-body-left", targets: 0 },
        { className: "dt-body-center", targets: [1, 2, 3, 4, 5, 6, 7, 8] },
        { className: "dt-body-center no-print", targets: [9] }
    ];
    var contaPagarOrder = [
        [0, 'asc'],
        [5, 'asc']
    ];
    initializeDataTable("#tableContaPagar", base_url + "api/financeiro/tabela/contaspagar", contaPagarColumnDefs, contaPagarOrder);

    // CARREGA DADOS DA TELA DE CONTA A RECEBER
    var contaReceberColumnDefs = [
        { className: "dt-body-left", targets: 0 },
        { className: "dt-body-center", targets: [1, 2, 3, 4, 5, 6, 7, 8] },
        { className: "dt-body-center no-print", targets: [9] }
    ];
    var contaReceberOrder = [
        [6, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableContaReceber", base_url + "api/financeiro/tabela/contasreceber", contaReceberColumnDefs, contaReceberOrder);

    // CARREGA DADOS DA TELA DAS PROFISSOES
    var profissaoColumnDefs = [
        { className: "dt-body-center", targets: [1, 2, 3, 4] }
    ];
    initializeDataTable("#tableProfissoes", base_url + "api/financeiro/tabela/profissoes", profissaoColumnDefs);

    // CARREGA DADOS DA TELA DAS GRUPO
    var grupoColumnDefs = [
        { className: "dt-body-center", targets: [1, 2, 3, 4] }
    ];
    var grupoOrder = [
        [3, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableGrupos", base_url + "api/financeiro/tabela/grupos", grupoColumnDefs, grupoOrder);

    // CARREGA DADOS DA TELA DAS SUBGRUPO

    var subGrupoColumnDefs = [
        { className: "dt-body-center", targets: [2, 3] }
    ];
    var subGrupoOrder = [
        [2, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableSubGrupos", base_url + "api/financeiro/tabela/subgrupos", subGrupoColumnDefs, subGrupoOrder);
});

// GERENCIA AS CONTAS -- A RECEBER
const $modalTitleReceber = $('#modalTitleReceber');
const $modalTitlePagamentoReceber = $('#modalTitlePagamentoReceber');

const $cadCodigo = $('#cod_receber');
const $codPessoa = $('#cod_pessoa');
const $cadSubgrupo = $('#cod_subgrupo');
const $cadTotal = $('#cad_valor');
const $cadReferencia = $('#cad_referencia');
const $cadParcela = $('#cad_parcela');
const $cadParcelaTotal = $('#cad_parcela_total');
const $cadVencimento = $('#cad_vencimento');
const $cadObservacao = $('#cad_observacao');

function getEditReceber(Paramentro) {
    $.ajax({
        url: base_url + "api/financeiro/exibir/contareceber/" + Paramentro,
        type: "GET",
        dataType: "json",
        success: function (dado) {
            $modalTitleReceber.text(`ATUALIZANDO A CONTA A RECEBER CODIGO: ${dado.id_receber}`);
            $cadCodigo.val(dado.id_receber);
            $codPessoa.val(dado.pessoa_id).trigger('change');
            $cadSubgrupo.val(dado.subgrupo_id).trigger('change');
            $cadTotal.val(dado.rec_valor);
            $cadReferencia.val(dado.rec_referencia);
            $cadParcela.val(dado.rec_parcela);
            $cadParcelaTotal.val(dado.rec_parcela_total);
            $cadVencimento.val(dado.rec_vencimento);
            $cadObservacao.val(dado.rec_observacao);

            document.getElementById("container-parcela").hidden = false;
            document.getElementById("container-diasparc").hidden = true;
        }
    });
}

function setNewReceber() {

    $modalTitleReceber.text('CADASTRO DE CONTA A RECEBER');
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (cad_codigo != '') {
        $cadCodigo.val('');
        $codPessoa.val('').trigger('change');
        $cadSubgrupo.val('').trigger('change');
        $cadTotal.val('');
        $cadReferencia.val('');
        $cadParcela.val(1);
        $cadVencimento.val('');
        $cadObservacao.val('');

        document.getElementById("container-parcela").hidden = true;
        document.getElementById("container-diasparc").hidden = false;
    }
}

function salvarContaReceber() {
    $("#formContaReceber").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formContaReceber').attr('action'),
                type: "POST",
                data: $('#formContaReceber').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitContaReceber").disabled = true;
                },
                success: function (response) {
                    console.log(response);
                    respostaSwalFire(response, true)
                },
                error: function () {
                    document.getElementById("submitContaReceber").disabled = false;
                }
            });
        }
    });

    $('#formContaReceber').validate({
        rules: {
            cod_pessoa: {
                required: true,
            },
            cod_subgrupo: {
                required: true,
            },
            cad_valor: {
                required: true,
            },
            cad_referencia: {
                required: true,
            },
            cad_parcela: {
                required: true,
            },
            cad_vencimento: {
                required: true,
            }
        },
        messages: {
            cod_pessoa: {
                required: "O CLIENTE DEVE SER SELECIONADO!",
            },
            cod_subgrupo: {
                required: "O SUBGRUPO DEVE SER INFORMADA!",
            },
            cad_valor: {
                required: "O VALOR DEVE SER INFORMADO!",
            },
            cad_referencia: {
                required: "O REFERENCIA DEVE SER INFORMADA!",
            },
            cad_parcela: {
                required: "A PARCELA DEVE SER INFORMADA!",
            },
            cad_vencimento: {
                required: "O VENCIMENTO DEVE SER INFORMADO!",
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

$('.custom-control-input').change(function () {
    checkInputReceberPagamento();
});

function checkInputReceberPagamento() {
    event.preventDefault();
    var searchIDs = $("input:checkbox:checked").map(function () {
        return this.value;
    }).toArray();

    if (searchIDs.length > 0) {
        // document.getElementById("receberParcelaPagamento").hidden = false;
        document.getElementById("cardParcelaPagamento").hidden = false;
    } else {
        // document.getElementById("receberParcelaPagamento").hidden = true;
        document.getElementById("cardParcelaPagamento").hidden = true;
    }
}

function detalheAReceberPagamento() {
    event.preventDefault();
    var codReceber = aReceberSelecionado();
    $.ajax({
        url: base_url + "api/financeiro/exibir/contasreceber",
        type: "POST",
        data: { cod_receber: codReceber },
        dataType: "json",
        success: function (response) {
            let tablePagamentoReceber = document.getElementById('tablePagamentoReceber');

            $modalTitlePagamentoReceber.text('RECEBIMENTO DA CONTA A RECEBER');
            let inputPagamento = document.createElement("input");

            var attinput01 = document.createAttribute("value");

            for (let i = 0; i < response.length; i++) {

                var row = tablePagamentoReceber.insertRow();
                var valor = row.insertCell();
                var cancelado = row.insertCell();
                var recebido = row.insertCell();
                var saldo = row.insertCell();
                var saldo_pagamento = row.insertCell();

                valor.innerHTML = formatMoneyBR(response[i].valor);
                cancelado.innerHTML = formatMoneyBR(response[i].cancelado);
                recebido.innerHTML = formatMoneyBR(response[i].recebido);
                saldo.innerHTML = formatMoneyBR(response[i].saldo);
                inputPagamento.name = 'restantePagamento[]';
                attinput01.value = formatMoneyBR(response[i].saldo);
                saldo_pagamento.innerHTML = inputPagamento.setAttributeNode(attinput01);
                console.log(inputPagamento);
            }

        },
        error: function () {
            // $('#output').html('Bummer: there was an error!');
        },
    });
}

function aReceberSelecionado() {
    let seq = 0;
    let listaContaRecer = []
    inputs = document.getElementsByTagName('input');
    for (x = 0; x < inputs.length; x++) {
        if (inputs[x].type == 'checkbox') {
            if (inputs[x].checked == true && inputs[x].name == 'id_conta[]') {
                listaContaRecer[seq] = inputs[x].value;
                seq++;
            }
        }
    }
    return listaContaRecer;
}

function salvarPaymentReceber() {

    $("#formPaymentContaReceber").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formPaymentContaReceber').attr('action'),
                type: 'POST',
                data: $('#formPaymentContaReceber').serialize(),
                dataType: "json",
                beforeSend: function () {
                    //  document.getElementById("ReceberSubmit").disabled = true;
                },
                success: function (response) {
                    console.log(response);
                    // respostaSwalFire(response)
                },
                error: function () {
                    //  document.getElementById("ReceberSubmit").disabled = false;
                }
            });
        }
    });

    $('#formPaymentContaReceber').validate({
        rules: {
            pag_documento: {
                required: true,
            }
        },
        messages: {
            pag_documento: {
                required: "O DOCUMENTO DEVE SER INFORMADO!",
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
// GERENCIA AS CONTAS -- A PAGAR
const $modalTitlePagar = $('#modalTitlePagar');

const $cadPagCodigo = $('#cod_pagar');


function getEditPagar(Paramentro) {
    $.ajax({
        url: base_url + "api/financeiro/exibir/contapagar/" + Paramentro,
        type: "GET",
        dataType: "json",
        success: function (dado) {

            $modalTitlePagar.text(`ATUALIZANDO A CONTA A PAGAR - CODIGO: ${dado.id_pagar}`);
            $cadPagCodigo.val(dado.id_pagar);
            $codPessoa.val(dado.pessoa_id).trigger('change');
            $cadSubgrupo.val(dado.subgrupo_id).trigger('change');
            $cadTotal.val(dado.pag_valor);
            $cadReferencia.val(dado.pag_referencia);
            $cadParcela.val(dado.pag_parcela);
            $cadParcelaTotal.val(dado.pag_parcela_total);
            $cadVencimento.val(dado.pag_vencimento);
            $cadObservacao.val(dado.pag_observacao);

            document.getElementById("container-parcela").hidden = false;
            document.getElementById("container-diasparc").hidden = true;
        }
    });
}

function setNewPagar() {

    $modalTitlePagar.text('CADASTRO DE CONTA A PAGAR');
    var cod_pagar = document.getElementById('cod_pagar').value;
    if (cod_pagar != '') {
        $cadPagCodigo.val('');
        $codPessoa.val('').trigger('change');
        $cadSubgrupo.val('').trigger('change');
        $cadTotal.val('');
        $cadReferencia.val('');
        $cadParcela.val(1);
        $cadVencimento.val('');
        $cadObservacao.val('');

        document.getElementById("container-parcela").hidden = true;
        document.getElementById("container-diasparc").hidden = false;
    }
}

function salvarContaPagar() {
    $("#formContaPagar").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formContaPagar').attr('action'),
                type: "POST",
                data: $('#formContaPagar').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitContaPagar").disabled = true;
                },
                success: function (response) {
                    console.log(response);
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("submitContaPagar").disabled = false;
                }
            });
        }
    });

    $('#formContaPagar').validate({
        rules: {
            cod_pessoa: {
                required: true,
            },
            cod_subgrupo: {
                required: true,
            },
            cad_valor: {
                required: true,
            },
            cad_referencia: {
                required: true,
            },
            cad_parcela: {
                required: true,
            },
            cad_vencimento: {
                required: true,
            }
        },
        messages: {
            cod_pessoa: {
                required: "O FORNECEDOR DEVE SER SELECIONADO!",
            },
            cod_subgrupo: {
                required: "O SUBGRUPO DEVE SER INFORMADA!",
            },
            cad_valor: {
                required: "O VALOR DEVE SER INFORMADO!",
            },
            cad_referencia: {
                required: "O REFERENCIA DEVE SER INFORMADA!",
            },
            cad_parcela: {
                required: "A PARCELA DEVE SER INFORMADA!",
            },
            cad_vencimento: {
                required: "O VENCIMENTO DEVE SER INFORMADO!",
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


const $modalTitlePagamentoPagar = $('#modalTitlePagamentoPagar');

function detalheAPagarPagamento() {
    var codPagar = aPagarSelecionado();

    $.ajax({
        url: base_url + "api/financeiro/exibir/contaspagar",
        type: "POST",
        data: { cod_pagar: codPagar },
        dataType: "json",
        success: function (response) {
            console.log(response);

            $modalTitlePagamentoPagar.text('PAGAMENTO DE CONTA A PAGAR');

            let tablePagamentoPagar = document.getElementById('tablePagamentoPagar');

            for (let i = 0; i < response.length; i++) {
                // let inputPagamento = document.createElement("input");
                // let inputClass = document.createAttribute('class');
                // inputClass.value = 'valorbr form-control';

                // let inputType = document.createAttribute('type');
                // inputType.value = 'text';

                // let inputValor = document.createAttribute('value');

                // inputPagamento.setAttributeNode(inputClass);
                // inputPagamento.setAttributeNode(inputType);

                let tr = tablePagamentoPagar.insertRow();

                let td_valor = tr.insertCell();
                let td_cancelado = tr.insertCell();
                let td_recebido = tr.insertCell();
                let td_saldo = tr.insertCell();
                let td_pagamento = tr.insertCell();

                // inputValor.value = formatMoneyBR(response[i].saldo);
                // inputPagamento.setAttributeNode(inputValor);

                td_valor.innerHTML = formatMoneyBR(response[i].valor);
                td_cancelado.innerHTML = formatMoneyBR(response[i].cancelado);
                td_recebido.innerHTML = formatMoneyBR(response[i].recebido);
                td_saldo.innerHTML = formatMoneyBR(response[i].saldo);
                td_pagamento.innerHTML = '<input name="cad_valor[]" id="cad_valor' + i + '" type="text" class="valorbr form-control" placeholder="0,00" >';
                // td_pagamento.append(inputPagamento);

            }

        },
        error: function (error) {
            console.log(error);
            // $('#output').html('Bummer: there was an error!'); 
        },
    });
}

function aPagarSelecionado() {
    let seq = 0;
    let listaContaPagar = []
    inputs = document.getElementsByTagName('input');
    for (x = 0; x < inputs.length; x++) {
        if (inputs[x].type == 'checkbox') {
            if (inputs[x].checked == true && inputs[x].name == 'id_conta[]') {
                listaContaPagar[seq] = inputs[x].value;
                seq++;
            }
        }
    }
    return listaContaPagar;
}


$('#pag_valor').change(function () {

    let valSelecionado = document.getElementById('valSelecionado').value;
    let cadPagValor = document.getElementById('pag_valor').value;
    let restante = (formatMoneyUS(valSelecionado) - formatMoneyUS(cadPagValor)).toFixed(2);

    if (restante < 0) {
        alert('Corrigir depois');
    }
});
// GERENCIA OS SUBGRUPOS

const $modalTitleSubgrupo = $('#modalTitleSubgrupo');

function getEditSubgrupo(Paramentro) {

    const $codSubgrupo = $('#cod_subgrupo');
    const $codGrupo = $('#cod_grupo');
    const $cadSubgrupo = $('#cad_subgrupo');

    $.ajax({
        url: base_url + "api/financeiro/exibir/subgrupo/" + Paramentro,
        type: "GET",
        dataType: "json",
        success: function (dado) {
            console.log(dado);
            $modalTitleSubgrupo.text(`ATUALIZANDO A SUBGRUPO ${dado.cad_subgrupo}`);
            $codSubgrupo.val(dado.cod_subgrupo);
            $codGrupo.val(dado.cod_grupo).trigger('change');
            $cadSubgrupo.val(dado.cad_subgrupo);
            document.getElementById("subgrupoAtivo").checked = dado.status === '1';
            document.getElementById("subgrupoInativo").checked = dado.status === '2';
        }
    });
}

function setNewSubgrupo() {

    const codSubgrupoEl = document.getElementById('cod_subgrupo');
    const codGrupoEl = document.getElementById('cod_grupo');
    const cadSubgrupoEl = document.getElementById('cad_subgrupo');

    $modalTitleSubgrupo.text('CADASTRO DE NOVO SUBGRUPO');

    const cod_subgrupo = codSubgrupoEl.value;
    codSubgrupoEl.value = cod_subgrupo !== '' ? '' : cod_subgrupo;
    $(codGrupoEl).val('').trigger('change');
    cadSubgrupoEl.value = '';
    document.getElementById("subgrupoAtivo").checked = true;
}

function SalvaSubGrupos() {
    $("#formSubgrupo").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formSubgrupo').attr('action'),
                type: "POST",
                data: $('#formSubgrupo').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarSubGrupo").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarSubGrupo").disabled = false;
                }
            });
        }
    });

    $('#formSubgrupo').validate({
        rules: {
            cod_grupo: {
                required: true,
            },
            cad_subgrupo: {
                required: true,
            },
        },
        messages: {
            cod_grupo: {
                required: "O grupo deve ser selecionado!",
            },
            cad_subgrupo: {
                required: "O subgrupo deve ser informada!",
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

function getGrupoOption() {
    $.get(base_url + 'api/financeiro/exibir/grupos', {}, function (response) {
        options = '<option value="">SELECIONE UM GRUPO</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].cod_grupo + '">' + response[i].cad_grupo + '</option>';
        }
        $('#cod_grupo').html(options);
    });
}

// GERENCIA OS GRUPOS

function getEditGrupo(Paramentro) {
    $.ajax({
        "url": base_url + "api/financeiro/exibir/grupo/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            console.log(dado);
            document.getElementById('modalTitleGrupo').innerHTML = 'ATUALIZANDO O GRUPO ' + dado.cad_grupo;
            $('#cod_grupo').val(dado.cod_grupo);
            $('#cad_tipo').val(dado.cad_tipo).trigger('change');
            $('#cad_grupo').val(dado.cad_grupo);
            $('#cad_classificacao').val(dado.cad_classificacao).trigger('change');

            if (dado.status == '1') {
                document.getElementById("grupoAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("grupoInativo").checked = true;
            }
        }
    });
}

function setNewGrupo() {
    document.getElementById('modalTitleGrupo').innerHTML = 'CADASTRO DE NOVO GRUPO FINANCEIRO';
    var cod_grupo = document.getElementById('cod_grupo').value;
    if (cod_grupo != '') {
        document.getElementById("cod_grupo").value = '';
        $('#cad_tipo').val('').trigger('change');
        document.getElementById("cad_grupo").value = '';
        $('#cad_classificacao').val('').trigger('change');
        document.getElementById("grupoAtivo").checked = true;
    }
}

function SalvaGrupos() {
    $("#formGrupo").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formGrupo').attr('action'),
                type: "POST",
                data: $('#formGrupo').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarGrupo").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarGrupo").disabled = false;
                }
            });
        }
    });

    $('#formGrupo').validate({
        rules: {
            cad_grupo: {
                required: true,
            },
            cad_tipo: {
                required: true,
            },
            cad_classificacao: {
                required: true,
            },
        },
        messages: {
            cad_grupo: {
                required: "O Grupo deve ser informada!",
            },
            cad_tipo: {
                required: "Um tipo deve ser selecionado!",
            },
            cad_classificacao: {
                required: "Uma classificação deve ser selecionada!",
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
                executeAction(base_url + "api/financeiro/arquivar/", Paramentro, Codigo);
            }
        });
}

function getCancelar(Paramentro, Codigo) {
    showConfirmationDialog('Deseja Realmente Cancelar Este Registro?', 'Este Lançamento Não Poderá Ser Desfeito!', 'Sim, Cancelar!')
        .then((confirmed) => {
            if (confirmed) {
                executeAction(base_url + "api/financeiro/cancelar/", Paramentro, Codigo);
            }
        });
}

// SUBGRUPOS CLASSIFICAÇÃO RECEITA E DESPESAS

function getContasOption(url, placeholder) {
    $.get(url, {}, function (response) {
        var options = '<option value="">' + placeholder + '</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].cod_subgrupo + '">' + response[i].cad_subgrupo + '</option>';
        }
        $('#cod_subgrupo').html(options);
    });
}

function getContasReceitaOption() {
    var url = base_url + 'api/financeiro/exibir/subgrupos/receitas';
    var placeholder = 'SELECIONE A CLASSIFICAÇÃO DA RECEITA';
    getContasOption(url, placeholder);
}

function getContasDespesaOption() {
    var url = base_url + 'api/financeiro/exibir/subgrupos/despesas';
    var placeholder = 'SELECIONE A CLASSIFICAÇÃO DA DESPESA';
    getContasOption(url, placeholder);
}

function receberCheckbox() {
    var inputs, x, selecionados = 0;
    var valor = 0;
    var cancelado = 0;
    var recebido = 0;
    var saldo = 0;
    inputs = document.getElementsByTagName('input');
    for (x = 0; x < inputs.length; x++) {
        if (inputs[x].type == 'checkbox') {
            if (inputs[x].checked == true && inputs[x].name == 'id_conta[]') {
                valor = Number.parseFloat(valor) + Number.parseFloat($("#valor_" + inputs[x].value).val());
                cancelado = Number.parseFloat(cancelado) + Number.parseFloat($("#cancelado_" + inputs[x].value).val());
                recebido = Number.parseFloat(recebido) + Number.parseFloat($("#recebido_" + inputs[x].value).val());
                saldo = Number.parseFloat(saldo) + Number.parseFloat($("#saldo_" + inputs[x].value).val());
            }
        }
    }
    $('#total_valor').text(formatMoneyBR(valor));
    $('#total_cancelado').text(formatMoneyBR(cancelado));
    $('#total_recebido').text(formatMoneyBR(recebido));
    $('#total_saldo').text(formatMoneyBR(saldo));
    $('#valSelecionado').val(formatMoneyBR(saldo));
    $('#pag_valor').val(formatMoneyBR(saldo));

    var searchIDs = $("input:checkbox:checked").map(function () {
        return this.value;
    }).toArray();

    $('#selecionados').text(searchIDs.length);
}

receberCheckbox();
$(':checkbox').click(receberCheckbox);