$(document).ready(function () {
    // CARREGA DADOS DA TELA DAS OBRAS
    var obrasColumnDefs = [
        { className: "dt-body-center", targets: 0 },
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 },
        { className: "dt-body-center", targets: 3 },
        { className: "dt-body-center", targets: 4 },
    ];
    var obrasOrder = [
        [0, 'asc']
    ];
    initializeDataTable("#tableObras", base_url + "api/projeto/tabela/obras", obrasColumnDefs, obrasOrder);

    // CARREGA DADOS DA TELA DAS OBRAS EM ANDAMENTO
    var obrasandamentoColumnDefs = [
        { className: "dt-body-center", targets: 0 },
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 },
        { className: "dt-body-center", targets: 3 },
        { className: "dt-body-center", targets: 4 },
    ];
    var obrasandamentoOrder = [
        [0, 'asc']
    ];
    initializeDataTable("#tableObrasAndamento", base_url + "api/projeto/tabela/obrasandamento", obrasandamentoColumnDefs, obrasandamentoOrder);

    // CARREGA DADOS DA TELA DAS OBRAS EM ANDAMENTO
    var obrasfinalizadasColumnDefs = [
        { className: "dt-body-center", targets: 0 },
        { className: "dt-body-center", targets: 1 },
        { className: "dt-body-center", targets: 2 },
        { className: "dt-body-center", targets: 3 },
        { className: "dt-body-center", targets: 4 },
    ];
    var obrasfinalizadasOrder = [
        [0, 'asc']
    ];
    initializeDataTable("#tableObrasFinalizadas", base_url + "api/projeto/tabela/obrasfinalizadas", obrasfinalizadasColumnDefs, obrasfinalizadasOrder);

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
            console.log(dado);
            document.getElementById('modalTitleObra').innerHTML = 'ATUALIZANDO A OBRA ' + dado.cad_obra;
            $('#cod_pessoa').val(dado.pessoa_id).trigger('change');

            $('#cod_obra').val(dado.cod_obra);
            $('#cad_obra').val(dado.cad_obra);
            $('#cad_datainicio').val(dado.cad_datainicio);

            $('#cod_endereco').val(dado.cod_endereco);

            $('#cad_cep').val(dado.cad_cep);
            $('#cad_endereco').val(dado.cad_endereco);
            $('#cad_numero').val(dado.cad_numero);
            $('#cad_bairo').val(dado.cad_setor);
            $('#cad_cidade').val(dado.cad_cidade);
            $('#cad_uf').val(dado.cad_estado);
            $('#cad_complemento').val(dado.cad_complemento);
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

// GERENCIAMENTO DOS LOCAIS DA OBRA

function getEditLocal(Paramentro) {
    $.ajax({
        "url": base_url + "api/projeto/exibir/local/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleLocal').innerHTML = 'ATUALIZANDO A LOCAL ' + dado.cad_local;
            $('#id_local').val(dado.cod_local);
            $('#cod_pessoa').val('').trigger('change');
            $('#cod_local_obra').val(dado.cod_obra);
            $('#cad_local').val(dado.cad_local);
            $('#cad_datainicio').val(dado.cad_datainicio);

            if (dado.cad_observacao != null) {
                $('#cad_observacao').summernote('pasteHTML', dado.cad_observacao);
            } else {
                console.log(1);
                $('#cad_observacao').summernote('reset');
            }

            $('#cad_cep').val(dado.cad_cep);
            $('#cad_endereco').val(dado.cad_endereco);
            $('#cad_numero').val(dado.cad_numero);
            $('#cad_bairo').val(dado.cad_bairo);
            $('#cad_cidade').val(dado.cad_cidade);
            $('#cad_uf').val(dado.cad_uf);
            $('#cad_complemento').val(dado.cad_complemento);

        }
    });
}

function setNewLocal(cod_obra = null) {
    document.getElementById('modalTitleLocal').innerHTML = 'CADASTRO DOS LOCAIS DA OBRA';
    if (cod_obra == null) {
        document.getElementById("cad_local").disabled = true;
        document.getElementById("cad_datainicio").disabled = true;
        document.getElementById("SalvarLocal").disabled = true;

        // Show an error message using Toastr
        toastr.error('ERRO: Não foi possível localizar a obra');
    }

    document.getElementById("cod_local_obra").value = cod_obra;

    var cod_local = document.getElementById('id_local').value;
    if (cod_local != '') {
        document.getElementById("id_local").value = '';
        document.getElementById("cad_local").value = '';
        document.getElementById("cad_datainicio").value = '';
    }
}

function salvarLocal() {
    $("#formLocal").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formLocal').attr('action'),
                type: "POST",
                data: $('#formLocal').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarLocal").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response, true)
                },
                error: function () {
                    document.getElementById("SalvarLocal").disabled = false;
                }
            });
        }
    });

    $('#formLocal').validate({
        rules: {
            cad_local: {
                required: true,
            },
        },
        messages: {
            cad_local: {
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

function getCarregaLocal(Paramentro) {

    $.ajax({
        "url": base_url + "api/projeto/exibir/local/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            var htmlLocalSelecionado = '<div class="alert alert-success alert-dismissible">ORÇAMENTO DO LOCAL: ' + dado.cad_local + '. </div>'
            document.getElementById('modalTitleLocal').innerHTML = 'CADASTRO DOS LOCAIS DA OBRA';
            document.getElementById('setLocalSeleiconado').innerHTML = htmlLocalSelecionado;
            $('#cod_local').val(dado.cod_local);
            $('#cod_obra').val(dado.cod_obra);
            document.getElementById("searchProduto").disabled = false;
            document.getElementById("quantidade").disabled = false;
            carregaLocal(dado.cod_obra, dado.cod_local);
        }
    });
}

// INICIANDO A INCLUSÃO DOS PRODUTOS/SERVIÇO

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
                        return {
                            label: obj.cad_produto + '  /  ' + obj.tam_abreviacao,
                            value: obj.cad_produto + '  /  ' + obj.tam_abreviacao,
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
            $('#produto_id').val(data.cod_produto);
            $('#cod_produto').val(data.cod_produto);
            $('#est_produto').val(data.estoque);
            $('#val_avista').val(formatMoneyBR(data.cad_valor1));
            $('#valor_avista').val(formatMoneyBR(data.cad_valor1));
            $('#quantidade').val('1');
            document.getElementById("submitAdicionar").disabled = false;
        }
    }
});

function addProdutoOrcamento() {
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
                    respostaSwalFire(response, false);
                    carregaLocal(response.data.cod_obra, response.data.cod_local);

                    document.getElementById("formAddProduto").reset();
                    $('#cod_local').val(response.data.cod_local);
                    $('#cod_obra').val(response.data.cod_obra);
                },
                error: function () {
                    document.getElementById("submitAdicionar").disabled = false;
                }
            });
        }
    });

    $('#formAddProduto').validate({
        rules: {
            cod_local: {
                required: true,
            },
        },
        messages: {
            cod_local: {
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

function salvarDetalheProduto() {
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
                    document.getElementById("submitAdicionar").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response, false);
                    carregaLocal(response.data.cod_obra, response.data.cod_local);

                    document.getElementById("formUpdateGradeProduto").reset();
                    $('#cod_local').val(response.data.cod_local);
                    $('#cod_obra').val(response.data.cod_obra);
                    $('#modalProdutoLocalServico').modal('hide');
                },
                error: function () {
                    document.getElementById("submitAdicionar").disabled = false;
                }
            });
        }
    });

    $('#formUpdateGradeProduto').validate({
        rules: {
            cod_local: {
                required: true,
            },
        },
        messages: {
            cod_local: {
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

function carregaLocal(cod_obra, cod_local) {
    carregaProdutoOrcamento(cod_obra, cod_local);
    carregaResumoProdutoOrcamento(cod_obra, cod_local);
    carregaServicoOrcamento(cod_obra, cod_local);
    carregaResumoServicoOrcamento(cod_obra, cod_local);
}

function carregaProdutoOrcamento(cod_obra, cod_local) {
    const table = $("#tableProdutoOrcamento").DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        processing: true,
        ajax: {
            type: "POST",
            url: base_url + "api/projeto/tabela/produtoorcamento",
            data: { cod_obra, cod_local },
            dataType: "json",
            async: true
        },
        columnDefs: [
            { className: "dt-body-center", targets: 0, width: "10%" },
            { className: "text-justify", targets: 1 },
            { className: "dt-body-center", targets: 2, width: "10%" },
            { className: "dt-body-center", targets: 3, width: "10%" },
            { className: "dt-body-center", targets: 4, width: "10%" },
            { className: "dt-body-center no-print", targets: 5, width: "10%" },
            { className: "dt-body-center no-print", targets: 6, width: "5%" }

            // { targets: [0, 2], className: 'text-center' },
            // { targets: [1], className: 'text-justify' },
            // { targets: [5, 6], className: 'no-print' }
        ],
        order: [[0, 'asc']]
    });

    // Destruir a tabela anterior antes de inicializar uma nova
    table.destroy();
}

function carregaServicoOrcamento(cod_obra, cod_local) {
    const table = $("#tableServicoOrcamento").DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        processing: true,
        ajax: {
            type: "POST",
            url: base_url + "api/projeto/tabela/servicoorcamento",
            data: { cod_obra, cod_local },
            dataType: "json",
            async: true
        },
        columnDefs: [
            { className: "dt-body-center", targets: 0, width: "10%" },
            { className: "text-justify", targets: 1 },
            { className: "dt-body-center", targets: 2, width: "10%" },
            { className: "dt-body-center", targets: 3, width: "10%" },
            { className: "dt-body-center", targets: 4, width: "10%" },
            { className: "dt-body-center no-print", targets: 5, width: "10%" },
            { className: "dt-body-center no-print", targets: 6, width: "5%" }
        ],
        order: [[0, 'asc']]
    });

    // Destruir a tabela anterior antes de inicializar uma nova
    table.destroy();
}

function carregaResumoProdutoOrcamento(cod_obra, cod_local) {
    $.ajax({
        type: "POST",
        url: base_url + "api/projeto/tabela/produtoorcamento",
        data: { cod_obra, cod_local },
        dataType: "json",
        success: function (dado) {
            if (dado.totalizador) {
                $("#calQuantidadeProdutos").text(dado.totalizador.qtn_produto);
                $("#totalProdutosLocal").val(dado.totalizador.val1_total);
                $("#calTotalProdutos").text(formatMoneyBR(dado.totalizador.val1_total));
            } else {
                $("#calQuantidadeProdutos").text(0);
                $("#totalProdutosLocal").val(0);
                $("#calTotalProdutos").text(formatMoneyBR(0));
            }
            totalizadorOrcamento();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);

            // Exibe uma mensagem de erro ao usuário
            alert("Ocorreu um erro ao carregar o resumo do produto orçamentário. Por favor, tente novamente.");
        }
    });
}

function carregaResumoServicoOrcamento(cod_obra, cod_local) {
    $.ajax({
        type: "POST",
        url: base_url + "api/projeto/tabela/servicoorcamento",
        data: { cod_obra, cod_local },
        dataType: "json",
        success: function (dado) {
            if (dado.totalizador) {
                $("#calQuantidadeServicos").text(dado.totalizador.qtn_produto);
                $("#totalServicosLocal").val(dado.totalizador.val1_total);
                $("#calTotalServicos").text(formatMoneyBR(dado.totalizador.val1_total));
            } else {
                $("#calQuantidadeServicos").text(0);
                $("#totalServicosLocal").val(0);
                $("#calTotalServicos").text(formatMoneyBR(0));
            }
            totalizadorOrcamento();

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);

            // Exibe uma mensagem de erro ao usuário
            alert("Ocorreu um erro ao carregar o resumo do produto orçamentário. Por favor, tente novamente.");
        }
    });
}

function totalizadorOrcamento() {
    var val_produto = $("#totalProdutosLocal").val() != "" ? parseFloat($("#totalProdutosLocal").val()) : 0;
    var val_servico = $("#totalServicosLocal").val() != "" ? parseFloat($("#totalServicosLocal").val()) : 0;
    var totalizador = val_produto + val_servico;

    if (totalizador > 0) {
        $("#totalOrcamento").text(formatMoneyBR(totalizador));
        $("#totalAPagarOrcamento").text(formatMoneyBR(totalizador));

    }
}

// ATUALIZAR A GRADE DO LOCAL 

function getEditProdutoLocalServico(Paramentro) {

    $.ajax({
        "url": base_url + "api/projeto/exibir/detalhe/produto/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleGradeProduto').innerHTML = 'ATUALIZANDO ' + dado.pro_descricao + ' - ' + dado.tam_abreviacao;

            document.getElementById("e_cod_detalhe").value = dado.id;
            document.getElementById("e_cod_local").value = dado.local_id;
            document.getElementById("e_cod_produto").value = dado.produto_id;
            document.getElementById("e_qnt_produto").value = dado.qtn_produto;
            document.getElementById("e_valor_unidade").value = formatMoneyBR(dado.val1_unad);
            document.getElementById("e_valor_desc").value = formatMoneyBR(dado.val1_unad);
            document.getElementById("e_valor_total").value = formatMoneyBR(dado.val1_total);
        }
    });
}

function atualizaGradeProduto() {
    var qnt_produto = $("#e_qnt_produto").val() != "" ? $("#e_qnt_produto").val() : 0;
    var valor_unidade = $("#e_valor_unidade").val() != "" ? $("#e_valor_unidade").val() : 0;
    var valor_desc = $("#e_valor_desc").val() != "" ? $("#e_valor_desc").val() : 0;
    var val_desc = valor_desc.replace('.', '').replace(',', '.');

    if (val_desc == 0) {
        document.getElementById("e_valor_desc").value = formatMoneyBR(valor_unidade);
        var valor_desc = valor_unidade;
    }

    var new_valor = qnt_produto * val_desc;
    document.getElementById("e_valor_total").value = formatMoneyBR(new_valor);
}


// FINALIZAR O PROJETO

function geraOrcamento() {
    $("#formGeraOrcamento").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formGeraOrcamento').attr('action'),
                type: "POST",
                data: $('#formGeraOrcamento').serialize(),
                dataType: "json",
                beforeSend: function () {
                    // document.getElementById("submitFinalizar").disabled = true;
                },
                success: function (response) {
                    // console.log(response);
                    respostaSwalFire(response, false)
                    // setTimeout(function () {
                    //     window.location.href = base_url + "app/caixa/receber/" + response.data.serial;
                    // }, 1500);
                }
            });
        }
    });

    $('#formGeraOrcamento').validate({
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