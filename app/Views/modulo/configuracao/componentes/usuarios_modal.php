<div class="modal fade" id="modalUsuario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-pink">
        <h4 class="modal-title"><span id="modalTitleUsuario"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open(base_url('/api/configuracao/salvar/usuario'), ['method' => 'post', 'id' => 'formUsuario']) ?>
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="hidden">
              <input type="hidden" name="cod_usuario" id="cod_usuario">
            </div>
            <div class="row">
              <div class="form-group col-6">
                <label for="">NOME</label>
                <input name="cad_nome" id="cad_nome" type="text" class="form-control" placeholder="DIGITE O NOME DO USUARIO" required>
              </div>
              <div class="form-group col-3">
                <label for="">APELIDO</label>
                <input name="cad_apelido" id="cad_apelido" type="text" class="form-control" placeholder="DIGITE O APELIDO DO USUARIO" required>
              </div>
              <div class="form-group col-3">
                <label for="">TELEFONE</label>
                <input name="cad_telefone" id="cad_telefone" type="text" class="form-control" placeholder="DIGITE O TELEFONE DO USUARIO">
              </div>
              <div class="form-group col-6">
                <label for="">E-MAIL</label>
                <input name="cad_email" id="cad_email" type="email" class="form-control" placeholder="DIGITE O E-MAIL DO USUARIO" required>
              </div>

              <div class="form-group col-3">
                <label for="">PERMISSÃO</label>
                <select name="cad_permissao" id="cad_permissao" class="form-control">
                </select>
              </div>
              <div class="form-group col-3">
                <label for="">SAUDAÇÃO</label>
                <select name="cad_sexo" id="cad_sexo" class="form-control">
                  <option value="F">SENHORA</option>
                  <option value="M">SENHOR</option>
                </select>
              </div>
              <div class="form-group col-4">
                <label for="">USERNAME</label>
                <input name="cad_username" id="cad_username" type="text" class="form-control" placeholder="DIGITE O USERNAME DO USUARIO" required>
              </div>
              <div class="col-md-8" id="pes_container-status">
                <div class="form-group">
                  <label class="col-sm-3 col-form-label">SITUAÇÃO</label>
                  <div class="form-group row">
                    <div class="col-sm-3">
                      <div class="icheck-success d-inline">
                        <input type="radio" name="status" id="usuarioAtivo" value="1" checked>
                        <label for="usuarioAtivo"> HABILITADO </label>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="icheck-danger d-inline">
                        <input type="radio" name="status" id="usuarioInativo" value="2">
                        <label for="usuarioInativo"> DESABILITADO </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="row">
              <div class="form-group col-12">
                <label for="">FOTO</label><br>
                <img src="../../../dist/img/avatar/avatar.png" class="img-thumbnail" alt="...">
              </div>
              <div class="form-group col-12 row" id="pes_container-alterar">
                <div class="form-group col-12">
                  <label for="">ALTERAR</label>
                </div>
                <div class="form-group col-6">
                  <button type="button" class="btn btn-outline-primary btn-block btn-flat" data-toggle="modal" data-target="#modalAlterarAvatar"><i class="fas fa-image"></i> AVATAR </button>
                </div>
                <div class="form-group col-6">
                  <button type="button" class="btn btn-outline-info btn-block btn-flat" data-toggle="modal" data-target="#modalAlterarSenha" onclick="alterarSenhaUsuario()"><i class="fa fa-key"></i> SENHA </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
        <button type="submit" id="submitSalvarUsuario" class="btn btn-primary" onclick="salvarUsuario()">SALVAR</button>
      </div>
      <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAvatarUsuario">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-pink">
        <h4 class="modal-title"><span id="modalTitleAvatarUsuario"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open_multipart(base_url('/api/configuracao/salvar/avatar'), ['method' => 'post', 'id' => 'formAvatarUsuario']) ?>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="hidden">
              <input type="hidden" name="cod_usuario" id="cod_avatarUsuario">
            </div>
            <div class="form-group col-12">
              <label for="">USERNAME</label>
              <input name="cad_avatar" id="cad_avatar" type="file" class="form-control" placeholder="DIGITE O USERNAME DO USUARIO" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
        <button type="submit" id="submitSalvarAvatarUsuario" class="btn btn-primary" onclick="salvarAvatarUsuario()">SALVAR</button>
      </div>
      <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAlterarSenha" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-pink">
        <h4 class="modal-title"><span id="modalTitleSenhaUsuario"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <?= form_open(base_url('/api/configuracao/salvar/usuario/senha'), ['method' => 'post', 'id' => 'formSenhaUsuario']) ?>
      <div class="modal-body">
        <div class="hidden">
          <input type="hidden" name="cod_usuario" id="use_password">
        </div>

        <div class="form-group">
          <label>SENHA</label>
          <div class="input-group">
            <input name="cad_password" id="cad_password" type="password" class="form-control" placeholder="INFORME A NOVA SENHA" autocomplete="off" minlength="6" maxlength="12" onKeyUp="verificaForcaSenha();">
            <div class="input-group-append">
              <button class="btn btn-outline-info" type="button" onclick="mostrarPassword()"><i class="fa fa-eye-slash" id="btnEyePassword"></i></button>
            </div>
          </div>
          <span id="password-status"></span>
        </div>

        <div class="form-group">
          <label>CONFIRMAR SENHA</label>
          <div class="input-group">
            <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="CONFIRME A SENHA" autocomplete="off">
            <div class="input-group-append">
              <button class="btn btn-outline-info" type="button" onclick="mostrarConfirm()"><i class="fa fa-eye-slash" id="btnEyeConfirm"></i></button>
            </div>
          </div>
        </div>

        <!-- <div class="form-group col-12">
          <label for="">SENHA </label>
          <input name="cad_password" id="cad_password" type="password" class="form-control" placeholder="INFORME A NOVA SENHA" autocomplete="off" minlength="6" maxlength="12" onKeyUp="verificaForcaSenha();">
          <span id="password-status"></span>
        </div>

        <div class="form-group col-12">
          <label for="">CONFIRMAR SENHA</label>
          <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="CONFIRME A SENHA" autocomplete="off">
        </div> -->

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
        <button type="submit" id="submitSalvarSenhaUsuario" class="btn btn-primary" onclick="salvarSenhaUsuario()">SALVAR</button>
      </div>
      <?= form_close(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>