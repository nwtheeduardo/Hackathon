<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $tabela = "usuarios";

    $l = $nome = $email = $login = $senha = $foto = $tipo_id = $ativo = NULL;
    $r = " required data-parsley-required-message='Preencha a senha' ";
    $f = " required data-parsley-required-message='Selecione uma Imagem JPG' ";


    if ( !empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from usuario where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $id = $dados->id;
        $nome = $dados->nome;
        $login = $dados->login;
        $l = " readonly ";
        $r = $f = NULL;

    }
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Cadastro de Usuários</h3>

        <div class="float-right">
        	<a href="cadastros/<?=$tabela?>" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/<?=$tabela?>" class="btn btn-info">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="card-body">
        <form name="formCadastro" method="post" action="salvar/<?=$tabela?>" data-parsley-validate="" enctype="multipart/form-data">
        	<div class="row">
        		<div class="col-12 col-md-2">
        			<label for="id">ID:</label>
        			<input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
        		</div>
        		<div class="col-12 col-md-10">
        			<label for="nome">Nome do Usuário:</label>
        			<input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o nome" value="<?=$nome?>">
        		</div>
    
                <div class="col-12 col-md-12">
                    <label for="login">Login do Usuário:</label>
                    <input type="text" name="login" id="login" class="form-control" required data-parsley-required-message="Preencha o login" value="<?=$login?>" <?=$l?> >
                </div>
                <div class="col-12 col-md-6">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" <?=$r?> >
                </div>
                <div class="col-12 col-md-6">
                    <label for="redigite">Redigite a Senha:</label>
                    <input type="password" name="redigite" id="redigite" class="form-control" <?=$r?> data-parsley-equalto="#senha">
                </div>

        	</div>

        	<button type="submit" class="btn btn-success float-right">
        		<i class="fas fa-check"></i> Salvar / Alterar
        	</button>
        </form>
    </div>
</div>
<script type="text/javascript">
</script>