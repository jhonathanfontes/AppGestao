$(document).ready(function () {

    // CARREGA DADOS DA TELA DE BANCOS
    $("#tableCaixaCloset").DataTable({
        "ajax": {
            "url": base_url + "api/venda/tabela/caixa/fechado",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        order: [
            [0, 'DESC']
        ],
    });

    // CARREGA DADOS DA TELA DE ORÇAMENTO ABERTOS - 30 DIAS
    $("#tableOrcamentoOpem").DataTable({
        "ajax": {
            "url": base_url + "api/venda/tabela/orcamento/aberto",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 1 },
            { className: "dt-body-center", targets: 2 },
            { className: "dt-body-center", targets: 3 },
            { className: "dt-body-center", targets: 4 }
        ],
        order: [
            [3, 'desc'],
            [0, 'desc']
        ],
    });

    // CARREGA DADOS DA TELA DOS Conta Bancaria
    $("#tableContaBancaria").DataTable({
        "ajax": {
            "url": base_url + "api/configuracao/tabela/contasbancarias",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 1 },
            { className: "dt-body-center", targets: 2 },
        ],
        order: [
            [1, 'desc'],
            [0, 'asc']
        ],
    });

    // CARREGA DADOS DA TELA DOS Forma Pagamento
    $("#tableFormaPagamento").DataTable({
        "ajax": {
            "url": base_url + "api/configuracao/tabela/formaspagamentos",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-justify", targets: 0 },
            { className: "dt-body-center", targets: 1 },
            { className: "dt-body-center", targets: 2 },
            { className: "dt-body-center", targets: 3 },
            { className: "dt-body-center", targets: 4 },
            { className: "dt-body-center", targets: 5 },
        ],
        order: [
            [1, 'desc'],
            [0, 'asc']
        ],
    });

    // CARREGA DADOS DA TELA DOS Maquina Cartao
    $("#tableMaquinaCartao").DataTable({
        "ajax": {
            "url": base_url + "api/configuracao/tabela/maquinascartoes",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 1 },
            { className: "dt-body-center", targets: 2 },
        ],
        order: [
            [1, 'desc'],
            [0, 'asc']
        ],
    });

    // CARREGA DADOS DA TELA DE EMPRESAS
    $("#tableEmpresa").DataTable({
        "ajax": {
            "url": base_url + "api/configuracao/tabela/empresas",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        order: [
            [0, 'desc']
        ],
    });


    // CARREGA DADOS DA TELA DE EMPRESAS
    $("#tableUsuarios").DataTable({
        "ajax": {
            "url": base_url + "api/configuracao/tabela/usuarios",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        order: [
            [0, 'desc']
        ],
    });

    // CARREGA GRADE DOS PRODUTOS
    $('#searchProduto').autocomplete({
        minLength: 2,
        autoFocus: true,
        delay: 300,
        maxShowItems: 10,
        source: function (request, cb) {
            $.ajax({
                url: base_url + 'api/cadastro/exibir/busca/produto/' + request.term.replace(" ", "_"),
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    var result;
                    result = [{
                        label: 'PRODUTO NÃO ENCONTRADO COMO ' + request.term,
                        value: ''
                    }];
                    if (res.length) {
                        result = $.map(res, function (obj) {
                            // console.log(obj);
                            return {
                                label: obj.cad_produto + '  /  ' + obj.fab_descricao,
                                value: obj.cad_produto + '  /  ' + obj.fab_descricao,
                                data: obj
                            }
                        })
                    }
                    cb(result);
                }
            })
        },
        select: function (event, selectedData) {
            if (selectedData && selectedData.item && selectedData.item.data) {
                var data = selectedData.item.data;
                $.post(base_url + 'api/cadastro/exibir/busca/grade/produtos', {
                    cod_produto: data.cod_produto
                }, function (data) {
                    $('#cat_grade').html(data);
                    document.getElementById("cat_grade").disabled = false;
                });
            }
        }
    });

    $('#PdvSearchProduto').autocomplete({
        minLength: 2,
        autoFocus: true,
        delay: 300,
        maxShowItems: 10,
        source: function (request, cb) {
            $.ajax({
                url: base_url + 'api/cadastro/exibir/busca/produtograde/' + request.term.replace(" ", "_"),
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    var result;
                    result = [{
                        label: 'PRODUTO NÃO ENCONTRADO COMO ' + request.term,
                        value: ''
                    }];
                    if (res.length) {
                        result = $.map(res, function (obj) {
                            return {
                                label: obj.des_produto + ' - ' + obj.des_tamanho + ' / ' + obj.cad_fabricante,
                                value: obj.des_produto + ' - ' + obj.des_tamanho + ' / ' + obj.cad_fabricante,
                                data: obj
                            }
                        })
                    }
                    cb(result);
                }
            })
        },
        select: function (event, selectedData) {
            if (selectedData && selectedData.item && selectedData.item.data) {
                var data = selectedData.item.data;
                // console.log(data);
                $('#produtoSelect').text(data.codigo + ' ' + data.des_produto + ' - ' + data.des_tamanho + ' / ' + data.cad_fabricante);
                $('#cat_grade').val(data.codigo);
                $('#produto_id').val(data.produto_id);
                $('#cod_produto').val(data.produto_id);
                $('#est_produto').val(data.estoque);
                $('#cod_grade').val(data.tamanho_id);
                $('#val_venda').val(formatMoneyBR(data.valor_vendaavista));
                $('#valor_venda').val(formatMoneyBR(data.valor_vendaavista));
                // $('#val_aprazo').val(formatMoneyBR(data.valor_vendaprazo));
                // $('#valor_aprazo').val(formatMoneyBR(data.valor_vendaprazo));
                $('#quantidade').val('1');

                document.getElementById("submitAdicionar").disabled = false;
            }
        }
    });

    $('#cat_grade').change(function () {
        var cod_grade = $('#cat_grade').val();
        $.post(base_url + 'api/cadastro/exibir/busca/grade/produto', {
            cod_grade: cod_grade
        }, function (r) {
            data = JSON.parse(r);

            $('#produto_id').val(data[0].produto_id);
            $('#cod_produto').val(data[0].produto_id);
            $('#est_produto').val(data[0].estoque);
            $('#cod_grade').val(data[0].tamanho_id);
            $('#val_avista').val(formatMoneyBR(data[0].valor_vendaavista));
            $('#valor_avista').val(formatMoneyBR(data[0].valor_vendaavista));
            $('#val_aprazo').val(formatMoneyBR(data[0].valor_vendaprazo));
            $('#valor_aprazo').val(formatMoneyBR(data[0].valor_vendaprazo));
            $('#quantidade').val('1');

            document.getElementById("submitAdicionar").disabled = false;
        });
    });

    $('#vendaAVista').change(function () {
        var tipo_atual = $('#tipo_atual').val();
        if (tipo_atual == 1) {
            document.getElementById("submitAlterar").disabled = true;
            document.getElementById("submitFinalizar").disabled = false;
            document.getElementById("buttonDescVista").disabled = false;
        } else {
            document.getElementById("submitAlterar").disabled = false;
            document.getElementById("submitFinalizar").disabled = true;
            document.getElementById("buttonDescPrazo").disabled = true;
        }
    });

    $('#vendaAPrazo').change(function () {
        var tipo_atual = $('#tipo_atual').val();
        if (tipo_atual == 2) {
            document.getElementById("submitAlterar").disabled = true;
            document.getElementById("submitFinalizar").disabled = false;
            document.getElementById("buttonDescPrazo").disabled = false;
        } else {
            document.getElementById("submitAlterar").disabled = false;
            document.getElementById("submitFinalizar").disabled = true;
            document.getElementById("buttonDescVista").disabled = true;
        }
    });

    // CAIXA

    $('#radioRetirada').change(function () {
        document.getElementById("div_conta").hidden = true;
        document.getElementById("cod_conta").required = false;
    }); //Dinheiro

    $('#radioDeposito').change(function () {
        document.getElementById("div_conta").hidden = false;
        document.getElementById("cod_conta").required = true;
        $.post(base_url + 'api/configuracao/consulta/contabancaria', {
            forma: 1
        }, function (data) {
            $('#cod_conta').html(data);
            document.getElementById("cod_conta").disabled = false;
        });
    }); // Transferencia

});

function submitForm(formId, submitButtonId) {
    $(formId).submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $(formId).attr('action'),
                type: "POST",
                data: $(formId).serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById(submitButtonId).disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response);
                }
            });
        }
    });

    $(formId).validate({
        rules: {
            cod_caixa: {
                required: true,
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

// GERENCIA OS ORÇAMENTOS
function NovoOrcamento() {
    $("#formNovoOrcamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formNovoOrcamento').attr('action'),
                type: "POST",
                data: $('#formNovoOrcamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("GerarNovoOrcamento").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response, false)
                    window.location.href = base_url + "/app/venda/orcamento/selling/" + response.data.serial;
                },
                error: function () {
                    document.getElementById("GerarNovoOrcamento").disabled = false;
                }
            });
        }
    });

    $('#formNovoOrcamento').validate({
        rules: {
            cod_pessoa: {
                required: true,
            }
        },
        messages: {
            cod_pessoa: {
                required: "O Cliente deve ser selecionado!",
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

function AddProdutoOrcamento() {
    $("#formAddProduto").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formAddProduto').attr('action'),
                type: "POST",
                data: $('#formAddProduto').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitAdicionar").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response);
                }
            });
        }
    });

    $('#formAddProduto').validate({
        rules: {
            cat_grade: {
                required: true,
            }
        },
        messages: {
            cat_grade: {
                required: "O Produto deve ser selecionado!",
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

function FormaPagOrcamento() {
    $("#formFormaPagOrcamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formFormaPagOrcamento').attr('action'),
                type: "POST",
                data: $('#formFormaPagOrcamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitAlterar").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                    //  window.location.href = base_url + "/app/venda/orcamento/selling/" + response.data.serial;
                }
            });
        }
    });

    $('#formFormaPagOrcamento').validate({
        rules: {
            tipo_atual: {
                required: true,
            }
        },
        messages: {
            tipo_atual: {
                required: "O tipo deve ser informado!",
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

function ClienteOrcamento() {
    const formCliemteOrcamento = $("#formCliemteOrcamento");
    const salvarCliemteOrcamento = document.getElementById(
        "salvarCliemteOrcamento"
    );

    formCliemteOrcamento.submit(e => e.preventDefault());

    $.validator.setDefaults({
        submitHandler: () => {
            const formData = formCliemteOrcamento.serialize();

            $.ajax({
                url: formCliemteOrcamento.attr("action"),
                type: "POST",
                data: formData,
                dataType: "json",
                beforeSend: () => {
                    salvarCliemteOrcamento.disabled = true;
                },
                success: response => {
                    respostaSwalFire(response);
                },
            });
        },
    });

    $('#formCliemteOrcamento').validate({
        rules: {
            cod_cliente: {
                required: true,
            },
        },
        messages: {
            cod_cliente: {
                required: 'O Cliente deve ser informado!',
            },
        },
        errorElement: 'span',
        errorPlacement: (error, element) => {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: (element, errorClass, validClass) => {
            $(element).addClass('is-invalid');
        },
        unhighlight: (element, errorClass, validClass) => {
            $(element).removeClass('is-invalid');
        },
    });
}

function VendedorOrcamento() {
    const formVendedorOrcamento = $("#formVendedorOrcamento");
    const salvarVendedorOrcamento = document.getElementById(
        "salvarVendedorOrcamento"
    );

    formVendedorOrcamento.submit(e => e.preventDefault());

    $.validator.setDefaults({
        submitHandler: () => {
            const formData = formVendedorOrcamento.serialize();

            $.ajax({
                url: formVendedorOrcamento.attr("action"),
                type: "POST",
                data: formData,
                dataType: "json",
                beforeSend: () => {
                    salvarVendedorOrcamento.disabled = true;
                },
                success: response => {
                    respostaSwalFire(response);
                },
            });
        },
    });

    $('#formVendedorOrcamento').validate({
        rules: {
            cod_vendedor: {
                required: true,
            },
        },
        messages: {
            cod_vendedor: {
                required: 'O Vendedor deve ser informado!',
            },
        },
        errorElement: 'span',
        errorPlacement: (error, element) => {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: (element, errorClass, validClass) => {
            $(element).addClass('is-invalid');
        },
        unhighlight: (element, errorClass, validClass) => {
            $(element).removeClass('is-invalid');
        },
    });
}

function salvarGradeProduto() {
    $("#formUpdateGradeProduto").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formUpdateGradeProduto').attr('action'),
                type: "POST",
                data: $('#formUpdateGradeProduto').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitGradeProduto").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response)
                }
            });
        }
    });

    $('#formUpdateGradeProduto').validate({
        rules: {
            cod_orcamento: {
                required: true,
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

function editarGradeProduto(idDetalhe) {
    var nameGradeProduto = $('#nameGradeProduto');
    var idDetalheInput = document.getElementById("id_detalhe");
    var codtipoInput = document.getElementById("cod_tipo");
    var qntProdutoInput = document.getElementById("qnt_produto");
    var valorUnidadeInput = document.getElementById("valor_unidade");
    var valorDescInput = document.getElementById("valor_desc");
    var valorTotalInput = document.getElementById("valor_total");

    $.ajax({
        type: "POST",
        url: base_url + "api/venda/orcamento/exibir/produto",
        data: { cod_grade: idDetalhe },
        success: function (dado) {
            let textModalTitle;
            if (dado.cod_tipo === 1) {
                textModalTitle = 'GRADE A VISTA: ' + dado.produto + ' / ' + dado.tamanho;
            } else if (dado.cod_tipo === 2) {
                textModalTitle = 'GRADE A PRAZO: ' + dado.produto + ' / ' + dado.tamanho;
            }
            nameGradeProduto.text(textModalTitle);
            idDetalheInput.value = dado.cod_detalhe;
            codtipoInput.value = dado.cod_tipo;
            qntProdutoInput.value = dado.qtn_produto;
            valorUnidadeInput.value = formatMoneyBR(dado.val_un);
            valorDescInput.value = formatMoneyBR(dado.val_unad);
            valorTotalInput.value = formatMoneyBR(dado.val_unad);
            $('#presente').val(dado.presente).trigger("change");
        }
    });
}

function atualizaGradeProduto() {
    var qnt_produto = $("#qnt_produto").val() != "" ? $("#qnt_produto").val() : 0;
    var valor_unidade = $("#valor_unidade").val() != "" ? $("#valor_unidade").val() : 0;
    var valor_desc = $("#valor_desc").val() != "" ? $("#valor_desc").val() : 0;
    var val_desc = valor_desc.replace('.', '').replace(',', '.');

    if (val_desc == 0) {
        document.getElementById("valor_desc").value = formatMoneyBR(valor_unidade);
        var valor_desc = valor_unidade;
    }

    var new_valor = qnt_produto * val_desc;
    document.getElementById("valor_total").value = formatMoneyBR(new_valor);
}

// APLICAR DESCONTO NAS VENDAS
function atualizaValorOrcamento() {
    var desc_percentual = $('#desc_percentual').val();
    var desc_val_final = $('#desc_val_final').val();
    var compra_total = $('#compra_total').val().replace('.', '').replace(',', '.');

    if (desc_percentual != '') {

        if (desc_percentual > 100) {
            alert('Percentual informado é maior que o permitido!');
        }
        var valor_desconto = (compra_total * (desc_percentual / 100));
        var compra_final = (compra_total - valor_desconto);

        $('#perc_percentual_view').val(desc_percentual + '%');
        $('#perc_percentual').val(desc_percentual);
        $('#desconto_compra').val(formatMoneyBR(valor_desconto));
        $('#valor_compra').val(formatMoneyBR(compra_final));
        document.getElementById("desc_val_final").disabled = true;
        document.getElementById("submitDesconto").disabled = false;

    } else {
        document.getElementById("desc_val_final").disabled = false;
    }
    if (desc_val_final != '') {

        if (desc_val_final > compra_total) {
            alert('O Valor informado é maior que o valor da compra!');
        }

        var desconto = desc_val_final.replace('.', '').replace(',', '.');
        var perc_total = parseFloat(((desconto * 100) / compra_total).toFixed(2));
        var percentual = parseFloat((100 - perc_total).toFixed(2));

        var desc_desconto = compra_total - desconto;
        if (percentual) {
            $('#perc_percentual_view').val(percentual + '%');
            $('#perc_percentual').val(percentual);
            $('#desconto_compra').val(formatMoneyBR(desc_desconto));
            $('#valor_compra').val(formatMoneyBR(desconto));
            document.getElementById("desc_percentual").disabled = true;
            document.getElementById("submitDesconto").disabled = false;
        }
    } else {
        document.getElementById("desc_percentual").disabled = false;
    }
    if (desc_percentual == '' && desc_val_final == '') {
        $('#perc_percentual_view').val('');
        $('#perc_percentual').val('');
        $('#desconto_compra').val('');
        $('#valor_compra').val(compra_total);
        document.getElementById("submitDesconto").disabled = true;
    }
}

function descontoValorOrcamento() {
    $("#formDescontoValorOrcamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formDescontoValorOrcamento').attr('action'),
                type: "POST",
                data: $('#formDescontoValorOrcamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitDescVista").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response)
                }
            });
        }
    });

    $('#formDescontoValorOrcamento').validate({
        rules: {
            cod_orcamento: {
                required: true,
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

function DeletarDetalhe(idDetalhe) {
    var codOrcamento = document.getElementById('conf_codOrcamento').value;
    var Serial = document.getElementById('conf_Serial').value;

    Swal.fire({
        title: 'Dejesa excluir este produto?',
        text: "Essa operação não pode ser desfeita",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Quero Excluir!',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + 'api/venda/orcamento/remove/produto',
                type: "POST",
                data: {
                    cod_orcamento: codOrcamento,
                    serial: Serial,
                    cod_detalhe: [cod_detalhe => idDetalhe]
                },
                success: function (data) {
                    if (data) {
                        document.location.reload(true);
                    }
                }
            });
        }
    })
}

function DeletarDetalhes() {
    var inputs, x, selecionado = 0;

    var codOrcamento = document.getElementById('conf_codOrcamento').value;
    var Serial = document.getElementById('conf_Serial').value;

    inputs = document.getElementsByTagName('input');

    Swal.fire({
        title: 'Dejesa excluir este produto?',
        text: "Essa operação não pode ser desfeita",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, Quero Excluir!',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            var cod_detalhe = [];
            for (x = 0; x < inputs.length; x++) {
                if (inputs[x].type == 'checkbox') {
                    if (inputs[x].checked == true && inputs[x].name == 'cod_detalhe[]') {
                        cod_detalhe[selecionado] = inputs[x].value;
                        selecionado++;
                    }
                }
            }

            $.ajax({
                url: base_url + 'api/venda/orcamento/remove/produto',
                type: "POST",
                data: {
                    cod_orcamento: codOrcamento,
                    serial: Serial,
                    cod_detalhe: cod_detalhe
                },
                success: function (data) {
                    document.location.reload(true);
                }
            });
        }
    })
}

// DELETA DETALHES
function MarcarDesmarcar() {
    $('.custom-control-input').each(
        function () {
            if ($(this).prop("checked")) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        }
    );
    checkInputDetalhe();
}

$('.custom-control-input').change(function () {
    checkInputDetalhe();
});

function checkInputDetalhe() {
    event.preventDefault();
    var searchIDs = $("input:checkbox:checked").map(function () {
        return this.value;
    }).toArray();

    if (searchIDs.length > 0) {
        document.getElementById("DeletarDetalheSelect").hidden = false;
    } else {
        document.getElementById("DeletarDetalheSelect").hidden = true;
    }
}

// FINALIZAR ORÇAMENTO
function salvarPaymentVenda() {
    $("#formPaymentVenda").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formPaymentVenda').attr('action'),
                type: "POST",
                data: $('#formPaymentVenda').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("ReceberSubmit").disabled = true;
                },
                success: function (response) {
                    console.log(response);
                    respostaSwalFire(response)
                }
            });
        }
    });

    jQuery.validator.addMethod('isValorPagamento', function (value, element) {
        var val_pagamento = parseFloat(value.replace(/[^0-9,]*/g, '').replace(',', '.'));
        if (val_pagamento <= 0 || val_pagamento <= '0.00') {
            return (this.optional(element) || false);
        }
        return (this.optional(element) || true);
    }, 'O VALOR NÃO PODE SER INFERIOR A R$ 0,01!');

    $('#formPaymentVenda').validate({
        rules: {
            cod_orcamento: {
                required: true,
            },
            pag_valor: {
                isValorPagamento: true,
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

function finishOrcamento() {
    $("#formfinishOrcamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formfinishOrcamento').attr('action'),
                type: "POST",
                data: $('#formfinishOrcamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitFinalizar").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response, false)
                    setTimeout(function () {
                        window.location.href = base_url + "app/caixa/receber/" + response.data.serial;
                    }, 1500);
                }
            });
        }
    });

    $('#formfinishOrcamento').validate({
        rules: {
            cod_orcamento: {
                required: true,
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

$('#cod_creditosaldo').change(function () {
    var cod_credito = $("#cod_creditosaldo").val();
    $.ajax({
        type: "POST",
        url: base_url + "ajax/getCreditoFinanceiro/" + cod_credito,
        success: function (r) {
            dado = JSON.parse(r);
            var valor_apagar = $("#valor_apagar").val() != "" ? $("#valor_apagar").val() : 0;
            var verifica_saldo = dado.cred_restante - valor_apagar;
            if (verifica_saldo < 0) {
                var saldo_credito = dado.cred_restante;
                document.getElementById("valor_creditofinan").disabled = false;
                document.getElementById("valor_creditofinan").required = true;
            } else {

                var saldo_credito = valor_apagar;
                document.getElementById("valor_creditofinan").disabled = false;
                document.getElementById("valor_creditofinan").required = true;
            }
            //  console.log(dado.cred_restante - valor_apagar);
            document.getElementById("valor_creditofinan").value = formatMoneyBR(saldo_credito);
            document.getElementById("valor_creditosaldo").value = formatMoneyBR(dado.cred_restante);
        }
    });
}); // CREDITO 

$('#valor_creditofinan').change(function () {
    var apagar = parseFloat($("#valor_apagar").val().replace(/[.,]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')) || 0;
    var creditofinan = parseFloat($("#valor_creditofinan").val().replace(/[.,]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')) || 0;
    var creditosaldo = parseFloat($("#valor_creditosaldo").val().replace(/[.,]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')) || 0;
    var verifica_saldo = creditosaldo - creditofinan;
    var verifica_pagamento = apagar - creditofinan;

    if (verifica_saldo < 0) {
        toastr.error('O VALOR INFORMADO É SUPERIOR AO CRÉDITO!');
        $("#valor_creditofinan").val('');
    } else {
        if (verifica_pagamento < 0) {
            toastr.error('O VALOR INFORMADO É SUPERIOR AO PAGAMENTO!');
            $("#valor_creditofinan").val(formatMoneyBR(apagar));
        }
    }
});

// CALCULA TROCO

$('#pag_valor').change(function () {
    var formaPagamento = document.getElementById('radioDinheiro').checked;
    if (formaPagamento) {
        VerificaTroco();
    }
});

$('#dinheiro_valor').change(function () {
    var formaPagamento = document.getElementById('radioDinheiro').checked;
    if (formaPagamento) {
        VerificaTroco();
    }
});

function VerificaTroco() {
    var pagamento = parseFloat($("#dinheiro_valor").val().replace('.', '').replace(',', '.')) || 0;
    var valor = parseFloat($("#pag_valor").val().replace('.', '').replace(',', '.')) || 0;
    var troco = pagamento - valor;

    if (troco >= 0) {
        document.getElementById('dinheiro_troco').value = formatMoneyBR(troco);
    }
}

function salvarSuplemento() {
    $("#formIncluirSuplemento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formIncluirSuplemento').attr('action'),
                type: "POST",
                data: $('#formIncluirSuplemento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitSuplemento").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                }
            });
        }
    });

    $('#formIncluirSuplemento').validate({
        rules: {
            cod_caixa: {
                required: true,
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

function getReceberVenda(serialVenda) {
    $.post(base_url + 'api/venda/consulta/orcamento', {
        serial: serialVenda
    }, function (data) {
        if (data) {
            var valor_apagar = (data.ven_tipo == 1 ? data.val_avista : data.val_aprazo);
            document.getElementById('modalTitleReceberVenda').innerHTML = `RECEBIMENTO DO ORÇAMENTO Nº ${data.orcamento_id} VENDA Nº ${data.id_venda}`;
            document.getElementById('val_total_venda').value = formatMoneyBR(valor_apagar);
            console.log(data);
        }
    });
}

function salvarSangria() {
    $("#formIncluirSangria").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formIncluirSangria').attr('action'),
                type: "POST",
                data: $('#formIncluirSangria').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitSuplemento").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response)
                }
            });
        }
    });

    $('#formIncluirSangria').validate({
        rules: {
            cod_caixa: {
                required: true,
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

function updateMoedaValues() {
    var tm = calcularmoedas();
    document.getElementById("total_moeda1").value = tm.toFixed(2);
    document.getElementById("total_moeda2").value = `R$ ${formatMoneyBR(tm)}`;
    var total = calculartotal();
    document.getElementById("abrir_valor1").value = total.toFixed(2);
    document.getElementById("abrir_valor2").value = `R$ ${formatMoneyBR(total)}`;
}

function calcularmoedas() {
    var m_01 = $("#moeda_01").val() || 0;
    var m_05 = $("#moeda_05").val() || 0;
    var m_10 = $("#moeda_10").val() || 0;
    var m_25 = $("#moeda_25").val() || 0;
    var m_50 = $("#moeda_50").val() || 0;
    var m_1 = $("#moeda_1").val() || 0;

    var total_meda = (m_01 * 0.01) + (m_05 * 0.05) + (m_10 * 0.1) + (m_25 * 0.25) + (m_50 * 0.5) + (m_1 * 1);
    return total_meda;
}

$('.moeda').change(function () {
    updateMoedaValues();
});

function updateCedulaValues() {
    var tc = calcularnotas();
    document.getElementById("total_cedula1").value = tc.toFixed(2);
    document.getElementById("total_cedula2").value = `R$ ${formatMoneyBR(tc)}`;
    var total = calculartotal();
    document.getElementById("abrir_valor1").value = total.toFixed(2);
    document.getElementById("abrir_valor2").value = `R$ ${formatMoneyBR(total)}`;
}

function calcularnotas() {
    var c_2 = $("#cedula_2").val() || 0;
    var c_5 = $("#cedula_5").val() || 0;
    var c_10 = $("#cedula_10").val() || 0;
    var c_20 = $("#cedula_20").val() || 0;
    var c_50 = $("#cedula_50").val() || 0;
    var c_100 = $("#cedula_100").val() || 0;

    var total_cedula = (c_2 * 2) + (c_5 * 5) + (c_10 * 10) + (c_20 * 20) + (c_50 * 50) + (c_100 * 100);
    return total_cedula;
}

$('.cedula').change(function () {
    updateCedulaValues();
});

function calculartotal() {
    var tm = calcularmoedas();
    var tc = calcularnotas();

    var total = tm + tc;
    return total;
}

function salvarFechamentoCaixa() {
    submitForm('#formFechamentoCaixa', 'submitFechamento');
}

function salvarAberturaCaixa() {
    submitForm('#formAberturaCaixa', 'submitAbertura');
}

function salvarRetornaOrcamento() {
    $("#formRetornaOrcamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formRetornaOrcamento').attr('action'),
                type: "POST",
                data: $('#formRetornaOrcamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitRetornaOrcamento").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response)
                }
            });
        }
    });

    $('#formRetornaOrcamento').validate({
        rules: {
            cod_caixa: {
                required: true,
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

function salvarFinalizaVenda() {
    $("#formFinalizaVenda").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formFinalizaVenda').attr('action'),
                type: "POST",
                data: $('#formFinalizaVenda').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitFinalizaVenda").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response)
                }
            });
        }
    });

    $('#formFinalizaVenda').validate({
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

function salvarFinalizaVendaPDV() {
    $("#formFinalizaVendaPDV").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formFinalizaVendaPDV').attr('action'),
                type: "POST",
                data: $('#formFinalizaVendaPDV').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("submitFinalizaVenda").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response, false);
                    setTimeout(function () {
                        window.location.href = base_url + "app/venda/pdv";
                    }, 1500);
                }
            });
        }
    });

    $('#formFinalizaVendaPDV').validate({
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

function buscaCaixaAnterior() {
    // Exemplo de uso da função
    buscarUltimoCaixaAberto()
        .then(caixaAberto => {
            console.log(caixaAberto);
        })
        .catch(error => {
            console.error(error);
        });
}

function buscarUltimoCaixaAberto() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: base_url + '/api/caixa/consulta/abertura',
            type: 'GET',
            dataType: 'json',
            contentType: 'application/json',
            success: function (ultimoCaixa) {
                resolve(ultimoCaixa);
            },
            error: function (xhr, status, error) {
                reject(new Error('ERRO AO BUSCAR OS DADOS DO CAIXA ABERTO'));
            }
        });
    });
}

function DeletarPagamento(RotaDestino, idDetalhe) {
    Swal.fire({
        title: 'DEJESA EXCLUIR ESTE PAGAMENTO?',
        text: "ESSA OPERAÇÃO NÃO PODE SER DESFEITA",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SIM, QUERO EXCLUIR!',
        cancelButtonText: 'CANCELAR',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: `${base_url}api/caixa/remover/${RotaDestino}/${idDetalhe}`,
                type: "GET",
                success: function (response) {
                    respostaSwalFire(response)
                }
            });

        }
    })
}