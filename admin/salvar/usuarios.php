<?php
include "libs/docs.php";

//verificar se está logado
if (!isset($_SESSION['submarino']['id'])) exit;

//verificar se foi dado um post
if ($_POST) {
	//recuperar os dados
	foreach ($_POST as $key => $value) {
		$$key = trim($value);
	}

	//validar os campos
	if (empty($login)) {
		mensagem("Erro", "Preencha o login", "error");
		exit;
	} else if ($senha != $redigite) {
		mensagem("Erro", "As senhas digitadas não são iguais", "error");
		exit;
	}

	$sql = $consulta = $dados = NULL;

	$sql = "select id from usuario where login = :login limit 1";
	$consulta = $pdo->prepare($sql);
	$consulta->bindParam(":login", $login);
	$consulta->execute();

	$dados = $consulta->fetch(PDO::FETCH_OBJ);

	/// Se tiver um usuário com o mesmo login
	//se for update 

	if (!empty($dados->id) && ($id != $dados->id)){
		mensagem("Erro", "Usuário já cadastrado com esse login, favor colocar um novo", "error");
		exit;
	}

	$sql = $consulta = $dados = NULL;

	//verificar se é insert ou update
	if (empty($id)) {
		//insert
		//criptografar a senh

		$senha = password_hash($senha, PASSWORD_DEFAULT);
		$sql = "insert into usuario values(NULL, :nome, :login, :senha)";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":nome", $nome);
		$consulta->bindParam(":login", $login);
		$consulta->bindParam(":senha", $senha);
	} else {

		//s de senha com null
		$f = $s = NULL;

		//verificar se existe senha
		if (!empty($senha)) {
			//criptografar a senha
			$senha = password_hash($senha, PASSWORD_DEFAULT);
			$s = ", senha = :senha ";
		}

		$sql = "update usuario set 
    			nome = :nome
    			$f 
    			$s
    			where id = :id limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":nome", $nome);
		$consulta->bindParam(":id", $id);

		if (!empty($s)) {
			$consulta->bindParam(":senha", $senha);
		}
	}

	//executar o insert ou update
	if ($consulta->execute()) {
		mensagem("Salvo", "Registro salvo com sucesso", "ok");
		exit;
	}

	mensagem("Erro", "Erro ao salvar", "error");
	exit;
}

//se tentar acessar sem passar pelo form
mensagem("Erro", "Requisição inválida", "error");
