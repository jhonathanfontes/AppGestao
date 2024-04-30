<div class="modal fade" id="modalAbrirCaixa">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title">ABERTURA DO CAIXA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open(base_url('/api/caixa/processar/abertura'), ['method' => 'post', 'id' => 'formAberturaCaixa']) ?>
            <div class="modal-body">

                <div class="form-group col-12">
                    <label for="">MOEDAS</label>
                    <hr>
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="">R$ 0,01</label>
                            <input name="moeda_01" id="moeda_01" type="number" class="moeda form-control" placeholder="R$ 0,01">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,05</label>
                            <input name="moeda_05" id="moeda_05" type="number" class="moeda form-control" placeholder="R$ 0,05">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,10</label>
                            <input name="moeda_10" id="moeda_10" type="number" class="moeda form-control" placeholder="R$ 0,10">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,25</label>
                            <input name="moeda_25" id="moeda_25" type="number" class="moeda form-control" placeholder="R$ 0,25">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 0,50</label>
                            <input name="moeda_50" id="moeda_50" type="number" class="moeda form-control" placeholder="R$ 0,50">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 1,00</label>
                            <input name="moeda_1" id="moeda_1" type="number" class=" moeda form-control" placeholder="R$ 1,00">
                        </div>
                    </div>
                    <label for="">CEDULAS</label>
                    <hr>
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="">R$ 2,00</label>
                            <input name="cedula_2" id="cedula_2" class="cedula form-control" placeholder="R$ 2,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 5,00</label>
                            <input name="cedula_5" id="cedula_5" class="cedula form-control" placeholder="R$ 5,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 10,00</label>
                            <input name="cedula_10" id="cedula_10" class="cedula form-control" placeholder="R$ 10,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 20,00</label>
                            <input name="cedula_20" id="cedula_20" class="cedula form-control" placeholder="R$ 20,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 50,00</label>
                            <input name="cedula_50" id="cedula_50" class="cedula form-control" placeholder="R$ 50,00">
                        </div>
                        <div class="form-group col-2">
                            <label for="">R$ 100,00</label>
                            <input name="cedula_100" id="cedula_100" class="cedula form-control" placeholder="R$ 100,00">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="">TOTAL MOEDAS</label>
                            <input name="total_meda" id="total_moeda1" class="form-control" placeholder="R$ 0,00" hidden>
                            <input name="total_meda" id="total_moeda2" class="form-control" placeholder="R$ 0,00" disabled>
                        </div>
                        <div class="form-group col-3">
                            <label for="">TOTAL CEDULAS</label>
                            <input name="total_cedula" id="total_cedula1" class="form-control" placeholder="R$ 0,00" hidden>
                            <input name="total_cedula" id="total_cedula2" class="form-control" placeholder="R$ 0,00" disabled>
                        </div>
                        <div class="form-group col-3">
                            <label for="">TOTAL</label>
                            <input name="abrir_valor" id="abrir_valor1" class="form-control" placeholder="R$ 0,00" hidden>
                            <input name="abrir_valor" id="abrir_valor2" class="form-control" placeholder="R$ 0,00" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" id="submitAbertura" class="btn btn-success" onclick="salvarAberturaCaixa()">ABRIR CAIXA</button>
            </div>
            <?= form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- FIM ABRIR CAIXA -->

<div class="modal fade" id="modalReabrirCaixa">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title">REABRIR ULTIMO CAIXA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url(); ?>caixa/reabrirultimocaixa" method="post">
                <div class="modal-body">
                    <div class="form-group col-12">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="">MOTIVO</label>
                                <input name="cad_motivo" id="cad_motivo" type="text" class="moeda form-control" placeholder="Descreva o motivo de reabertura do caixa" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Reabrir</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- FIM REABRIR CAIXA -->