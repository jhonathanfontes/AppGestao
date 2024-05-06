$(document).ready(function () {

    // CARREGA DADOS DA TELA DE PESSOAS
    var pessoasColumnDefs = [
        { className: "dt-body-center", targets: [2, 3, 4, 5, 6, 7] }
    ];
    var pessoasOrder = [
        [6, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tablePessoas", base_url + "api/cadastro/tabela/pessoas", pessoasColumnDefs, pessoasOrder);

    // CARREGA DADOS DA TELA DAS PROFISSOES
    var profissoesColumnDefs = [
        { className: "dt-body-center", targets: [1, 2] }
    ];
    var profissoesOrder = [
        [1, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableProfissoes", base_url + "api/cadastro/tabela/profissoes", profissoesColumnDefs, profissoesOrder);

    // CARREGA DADOS DA TELA DE PRODUTOS
    var produtosColumnDefs = [
        { className: "dt-body-center", targets: [0, 3, 4, 5, 6, 7, 8, 9] }
    ];
    var produtosOrder = [
        [8, 'desc'],
        [1, 'asc']
    ];

    initializeDataTable("#tableProdutos", base_url + "api/cadastro/tabela/produtos", produtosColumnDefs, produtosOrder, 1);

    // CARREGA DADOS DA TELA DE SERVIÇOS
    var servicosColumnDefs = [
        { className: "dt-body-center", targets: [0, 3, 4, 5, 6, 7] }
    ];
    var servicosOrder = [
        [6, 'desc'],
        [1, 'asc']
    ];
    initializeDataTable("#tableServicos", base_url + "api/cadastro/tabela/produtos", servicosColumnDefs, servicosOrder, 2);

    // CARREGA DADOS DA TELA DOS CATEGORIA
    var categoriasColumnDefs = [
        { className: "dt-body-center", targets: [1, 2] }
    ];
    var categoriasOrder = [
        [1, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableCategorias", base_url + "api/cadastro/tabela/categorias", categoriasColumnDefs, categoriasOrder);

    // CARREGA DADOS DA TELA DOS SUBCATEGORIA
    var subCategoriasColumnDefs = [
        { className: "dt-body-center", targets: [2, 3] }
    ];
    var subCategoriasOrder = [
        [2, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableSubCategorias", base_url + "api/cadastro/tabela/subcategorias", subCategoriasColumnDefs, subCategoriasOrder);

    // CARREGA DADOS DA TELA DOS FABRICANTES
    var fabricantesColumnDefs = [
        { className: "dt-body-center", targets: [1, 2] }
    ];
    var fabricantesOrder = [
        [1, 'desc'],
        [0, 'asc']
    ];
    initializeDataTable("#tableFabricantes", base_url + "api/cadastro/tabela/fabricantes", fabricantesColumnDefs, fabricantesOrder);

    // CARREGA DADOS DA TELA DOS TAMANHOS
    var tamanhosColumnDefs = [
        { className: "dt-body-center", targets: [0, 1, 2, 3, 4] }
    ];
    var tamanhosOrder = [
        [3, 'desc'],
        [1, 'asc']
    ];
    initializeDataTable("#tableTamanhos", base_url + "api/cadastro/tabela/tamanhos", tamanhosColumnDefs, tamanhosOrder);
});

$(document).ready(function () {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#cad_cep").val("");
    }

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
                document.getElementById("cad_setor").disabled = true;
                document.getElementById("cad_cidade").disabled = true;
                document.getElementById("cad_estado").disabled = true;


                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cad_cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#cad_endereco").val(dados.logradouro);
                        $("#cad_setor").val(dados.bairro);
                        $("#cad_cidade").val(dados.localidade);
                        $("#cad_estado").val(dados.uf);

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
                    document.getElementById("cad_setor").disabled = false;
                    document.getElementById("cad_cidade").disabled = false;
                    document.getElementById("cad_estado").disabled = false;
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

// MODULO DE CADASTRO
// GERENCIA AS PESSOAS
$('#cad_natureza').change(function () {
    var natureza = document.getElementById('cad_natureza').value
    if (natureza == "F") {
        $('#nameDocumento').text('CPF');
        document.getElementById("container-sync").hidden = true;
        document.getElementById("container-nascimento").hidden = false;
        document.getElementById("container-rg").hidden = false;
    } else if (natureza == "J") {
        $('#nameDocumento').text('CNPJ');
        document.getElementById("container-sync").hidden = false;
        document.getElementById("container-nascimento").hidden = true;
        document.getElementById("container-rg").hidden = true;
    }
});

function formatarCampo(campoTexto) {
    var cod_pessoa = document.getElementById('cod_pessoa').value;
    if (campoTexto.value != '') {
        $.post(base_url + 'api/cadastro/consulta/pessoa/documento', { cad_documento: campoTexto.value })
            .done(function (data) {
                if (cod_pessoa == '' || cod_pessoa != data.cod_pessoa) {
                    if (data) {
                        $menssagem = "Documento já cadastrado - COD: " + data.cod_pessoa + " Pessoa: " + data.cad_nome;
                        showConfirmationDialog('O CNPJ informado já esta cadastrado em nome de ' + data.cad_nome + '!', 'Deseja atualizar os dados CNPJ!', 'Sim, Atualizar!')
                            .then((confirmed) => {
                                if (confirmed) {
                                    getEditPessoa(data.cod_pessoa);
                                } else {
                                    document.getElementById("cad_documento").value = '';
                                }
                            });
                    }
                }
            });

        if (campoTexto.value.length == 11) {
            document.getElementById("buttonSyncPessoa").value = null;
            campoTexto.value = mascaraCpf(campoTexto.value);
            $('#cad_natureza').val('F').trigger("change");
            document.getElementById("buttonSyncPessoa").disabled = true;
        } else if (campoTexto.value.length == 14) {
            //  consultaCNPJ(campoTexto.value);
            document.getElementById("buttonSyncPessoa").value = campoTexto.value;
            campoTexto.value = mascaraCnpj(campoTexto.value);
            $('#cad_natureza').val('J').trigger("change");
            document.getElementById("buttonSyncPessoa").disabled = false;
        } else {
            $(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                $(function () {
                    toastr.error('Documento informador não é valido');
                    campoTexto.value = '';
                });
            });
        }
    }
}

// Cerragar os dados do CNPJ informado
function consultaCNPJ(cnpj) {
    $.ajax({
        'url': "https://www.receitaws.com.br/v1/cnpj/" + cnpj.value,
        'type': "GET",
        'dataType': 'jsonp',
        'success': function (dado) {
            if (dado.nome == undefined) {
                $(function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $(function () {
                        toastr.error('CNPJ Não encontrado, Preencha Manualmente');
                    });
                });
            } else {
                document.getElementById("cad_nome").value = dado.nome;
                document.getElementById("cad_apelido").value = dado.fantasia;
                document.getElementById("cad_cep").value = dado.cep;
                document.getElementById("cad_endereco").value = dado.logradouro;
                document.getElementById("cad_numero").value = dado.numero;
                document.getElementById("cad_setor").value = dado.bairro;
                document.getElementById("cad_cidade").value = dado.municipio;
                document.getElementById("cad_estado").value = dado.uf;
                document.getElementById("cad_complemento").value = dado.complemento;
                document.getElementById("cad_telefone").value = dado.telefone;
                document.getElementById("cad_email").value = dado.email;
            }
        }
    });
}

// GERENCIA OS PESSOAS
function getEditPessoa(Paramentro) {
    $.ajax({
        "url": base_url + "api/cadastro/exibir/pessoa/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitlePessoa').innerHTML = 'EDITANDO CADASTRO DO ' + dado.cad_nome;
            $('#id').val(dado.cod_pessoa);
            $('#cod_pessoa').val(dado.cod_pessoa);
            $('#cad_tipopessoa').val(dado.cad_tipopessoa).trigger("change");
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
                document.getElementById("pessoaAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("pessoaInativo").checked = true;
            }
        }
    });
}

function setNewPessoa() {
    document.getElementById('modalTitlePessoa').innerHTML = 'CADASTRO DE NOVO CLIENTE / FORNECEDOR';
    var cod_pessoa = document.getElementById('cod_pessoa').value;
    if (cod_pessoa != '') {
        document.getElementById("id").value = '';
        document.getElementById("cod_pessoa").value = '';
        $('#cad_tipopessoa').val(1).trigger("change");
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

function SalvaPessoa() {
    $("#formPessoa").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formPessoa').attr('action'),
                type: "POST",
                data: $('#formPessoa').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarPessoa").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarPessoa").disabled = false;
                }
            });
        }
    });

    $('#formPessoa').validate({
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

function getProfissaoOption() {
    $.get(base_url + 'api/cadastro/exibir/profissoes', {
    }, function (response) {

        if (response.length > 0) {
            options = '<option value="">SELECIONE UMA PROFISSÃO</option>';
            for (var i = 0; i < response.length; i++) {
                options += '<option value="' + response[i].cod_profissao + '">' + response[i].cad_profissao + '</option>';
            }
        } else {
            options = '<option value="">NÃO TEM PROFISSÃO CADASTRADA</option>';
        }

        $('#pes_profissao').html(options);
    });
}

function getEditProfissao(Paramentro) {
    $.ajax({
        "url": base_url + "api/cadastro/exibir/profissao/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleProfissao').innerHTML = 'ATUALIZANDO A PROFISSÃO ' + dado.cad_profissao;
            $('#cod_profissao').val(dado.cod_profissao);
            $('#cad_profissao').val(dado.cad_profissao);
            if (dado.status == '1') {
                document.getElementById("profissaoAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("profissaoInativo").checked = true;
            }
        }
    });
}

function setNewProfissao() {
    document.getElementById('modalTitleProfissao').innerHTML = 'CADASTRO DE NOVA PROFISSÃO';
    var cod_profissao = document.getElementById('cod_profissao').value;
    if (cod_profissao != '') {
        document.getElementById("cod_profissao").value = '';
        document.getElementById("cad_profissao").value = '';
        document.getElementById("profissaoAtivo").checked = true;
    }
}

function salvarProfissao() {
    $("#formProfissao").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formProfissao').attr('action'),
                type: "POST",
                data: $('#formProfissao').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarProfissao").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarProfissao").disabled = false;
                }
            });
        }
    });

    $('#formProfissao').validate({
        rules: {
            cad_profissao: {
                required: true,
            },
        },
        messages: {
            cad_profissao: {
                required: "A Profissão deve ser informada!",
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

// GERENCIA OS PRODUTOS

function getEditProduto(Paramentro) {
    getProdutoCategoriaOption();
    $.ajax({
        "url": base_url + "api/cadastro/exibir/produto/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            console.log(dado);
            document.getElementById('modalTitleProduto').innerHTML = 'ATUALIZANDO O PRODUTO ' + dado.cad_produto;
            $('#cad_tipo').val(dado.cad_tipo);
            $('#cod_produto').val(dado.cod_produto);
            $('#cad_descricao').val(dado.cad_produto);
            $('#pro_categoria').val(dado.cod_categoria).trigger('change');
            $('#pro_tamanho').val(dado.cod_tamanho).trigger('change');
            if (dado.cad_tipo == 1) {
                $('#cad_custo').val(formatMoneyBR(dado.valor_custo));
                $('#cad_codbarras').val(dado.cad_codigobarras);
            } else {
                document.getElementById("cad_codbarras").disabled = true;
                document.getElementById("cad_custo").disabled = true;
            }
            $('#cad_valor1').val(formatMoneyBR(dado.valor_venda1));
            $('#cad_valor2').val(formatMoneyBR(dado.valor_venda2));

            if (dado.status == '1') {
                document.getElementById("produtoAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("produtoInativo").checked = true;
            }
        }
    });
}

function selectedSubcategoria() {
    var cod_produto = $('#cod_produto').val();
    if (cod_produto) {
        $.ajax({
            "url": base_url + "api/cadastro/exibir/produto/" + cod_produto,
            "type": "GET",
            "dataType": "json",
            success: function (response) {
                $('#pro_subcategoria').val(response.cod_subcategoria).trigger("change");
            }
        });
    } else {
        document.getElementById("pro_subcategoria").disabled = true;
    }
}

function setNewProduto() {

    document.getElementById('modalTitleProduto').innerHTML = 'CADASTRO DE NOVO PRODUTO ';
    document.getElementById("cad_tipo").value = 1;
    var cod_produto = document.getElementById('cod_produto').value;
    if (cod_produto != '') {
        document.getElementById("cod_produto").value = '';
        document.getElementById("cad_descricao").value = '';
        $('#pro_categoria').val('').trigger('change');
        $('#pro_tamanho').val('').trigger('change');
        document.getElementById("cad_custo").value = '';
        document.getElementById("cad_valor1").value = '';
        document.getElementById("cad_valor2").value = '';
        document.getElementById("cad_codbarras").value = '';
        document.getElementById("produtoAtivo").checked = true;
    }
}

function SalvaProdutos() {
    $("#formProduto").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formProduto');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formProduto').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvaProduto").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvaProduto").disabled = false;
                }
            });
        }
    });

    $('#formProduto').validate({
        rules: {
            cad_descricao: {
                required: true,
            },
            pro_subcategoria: {
                required: true,
            },
        },
        messages: {
            cad_descricao: {
                required: "A descrição do produto deve ser informada!",
            },
            pro_categoria: {
                required: "A categoria do produto deve ser selecionada!",
            },
            pro_subcategoria: {
                required: "A subcategoria do produto deve ser selecionada!",
            },
            pro_frabricante: {
                required: "O fabricante do produto deve ser selecionada!",
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

function setNewServico() {
    getProdutoCategoriaOption();
    document.getElementById('modalTitleProduto').innerHTML = 'CADASTRO DE NOVO SERVIÇO ';
    document.getElementById("cad_tipo").value = 2;
    document.getElementById("cad_codbarras").disabled = true;
    document.getElementById("cad_custo").disabled = true;

    var cod_produto = document.getElementById('cod_produto').value;
    if (cod_produto != '') {
        document.getElementById("cod_produto").value = '';
        document.getElementById("cad_descricao").value = '';
        $('#pro_categoria').val('').trigger('change');
        $('#pro_tamanho').val('').trigger('change');
        document.getElementById("cad_custo").value = '';
        document.getElementById("cad_valor1").value = '';
        document.getElementById("cad_valor2").value = '';
        document.getElementById("cad_codbarras").value = '';
        document.getElementById("produtoAtivo").checked = true;
    }
}

function getProdutoCategoriaOption() {
    $.get(base_url + 'api/cadastro/exibir/categorias', {
    }, function (response) {
        options = '<option value="">SELECIONE UMA CATEGORIA</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].cod_categoria + '">' + response[i].cad_categoria + '</option>';
        }
        $('#pro_categoria').html(options);
    });
}

function getProdutoTamanhoOption() {
    $.get(base_url + 'api/cadastro/exibir/tamanhos', {
    }, function (response) {
        options = '<option value="">SELECIONE UM TAMANHO</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].cod_tamanho + '">' + response[i].cad_abreviacao + ' - ' + response[i].cad_tamanho + '</option>';
        }
        $('#pro_tamanho').html(options);
    });
}

function getEditCategoria(Paramentro) {
    $.ajax({
        "url": base_url + "api/cadastro/exibir/categoria/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleCategoria').innerHTML = 'ATUALIZANDO A CATEGORIA ' + dado.cad_categoria;
            $('#cod_categoria').val(dado.cod_categoria);
            $('#cad_categoria').val(dado.cad_categoria);
            if (dado.status == '1') {
                document.getElementById("categoriaAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("categoriaInativo").checked = true;
            }
        }
    });
}

function setNewCategoria() {
    document.getElementById('modalTitleCategoria').innerHTML = 'CADASTRO DE NOVA CATEGORIA DO PRODUTO';
    var cod_categoria = document.getElementById('cod_categoria').value;
    if (cod_categoria != '') {
        document.getElementById("cod_categoria").value = '';
        document.getElementById("cad_categoria").value = '';
        document.getElementById("categoriaAtivo").checked = true;
    }
}

function salvarCategoria() {
    $("#formCategoria").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formCategoria');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formCategoria').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarCategoria").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("SalvarCategoria").disabled = false;
                }
            });
        }
    });

    $('#formCategoria').validate({
        rules: {
            cad_categoria: {
                required: true,
            },
        },
        messages: {
            cad_categoria: {
                required: "A Categoria deve ser informada!",
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

function setNewSubCategoria() {
    document.getElementById('modalTitleSubCategoria').innerHTML = 'CADASTRO DE NOVA SUBCATEGORIA DO PRODUTO';
    var cod_subcategoria = document.getElementById('cod_subcategoria').value;
    if (cod_subcategoria != '') {
        document.getElementById("cod_subcategoria").value = '';
        document.getElementById("cad_subcategoria").value = '';
        $('#sub_categoria').val('').trigger('change');
        document.getElementById("subcategoriaAtivo").checked = true;
    }
}

function getEditTamanho(Paramentro) {
    $.ajax({
        "url": base_url + "api/cadastro/exibir/tamanho/" + Paramentro,
        "type": "GET",
        "dataType": "json",
        success: function (dado) {
            document.getElementById('modalTitleTamanho').innerHTML = 'ATUALIZANDO O TAMANHO ' + dado.cad_tamanho;
            document.getElementById("cod_tamanho").value = dado.cod_tamanho;
            document.getElementById("cad_tamanho").value = dado.cad_tamanho;
            document.getElementById("cad_abreviacao").value = dado.cad_abreviacao;
            document.getElementById("cad_embalagem").value = dado.cad_embalagem;

            if (dado.status == '1') {
                document.getElementById("tamanhoAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("tamanhoInativo").checked = true;
            }
        }
    });
}

function setNewTamanho() {
    document.getElementById('modalTitleTamanho').innerHTML = 'CADASTRO DE NOVO TAMANHO DE PRODUTO';
    var cod_tamanho = document.getElementById('cod_tamanho').value;
    if (cod_tamanho != '') {
        document.getElementById("cod_tamanho").value = '';
        document.getElementById("cad_tamanho").value = '';
        document.getElementById("cad_abreviacao").value = '';
        document.getElementById("cad_embalagem").value = '1';
        document.getElementById("tamanhoAtivo").checked = true;
    }
}

function salvarTamanhos() {
    $("#formTamanho").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            $.ajax({
                url: $('#formTamanho').attr('action'),
                type: "POST",
                data: $('#formTamanho').serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("salvarTamanho").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response)
                },
                error: function () {
                    document.getElementById("salvarTamanho").disabled = false;
                }
            });
        }
    });

    $('#formTamanho').validate({
        rules: {
            cad_tamanho: {
                required: true,

            },
            cad_embalagem: {
                required: true,

            },
            cad_abreviacao: {
                required: true,
                maxlength: 5
            },
        },
        messages: {
            cad_tamanho: {
                required: "O Tamanho deve ser informado!",
            },
            cad_embalagem: {
                required: "O quantidade da embalagem deve ser informado!",
            },
            cad_abreviacao: {
                required: "A Abreviação deve ser informada!",
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
                executeAction(base_url + "api/cadastro/arquivar/", Paramentro, Codigo);
            }
        });
}

function getCancelar(Paramentro, Codigo) {
    showConfirmationDialog('Deseja Realmente Cancelar Este Registro?', 'Este Lançamento Não Poderá Ser Desfeito!', 'Sim, Cancelar!')
        .then((confirmed) => {
            if (confirmed) {
                executeAction(base_url + "api/cadastro/cancelar/", Paramentro, Codigo);
            }
        });
}