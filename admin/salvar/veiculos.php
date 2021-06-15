<?php
if (!isset($_SESSION['submarino']['id'])) exit;

if ($_POST) {

    //veiculos //veiculo

    include "libs/docs.php";
    include "libs/imagem.php";

    foreach ($_POST as $key => $value) {
        //echo "<p>{$key} - {$value}</p>";
        $$key = trim($value);
    }

    if (empty($modelo)) {
        $titulo = "Erro ao salvar";
        $mensagem = "Preencha o campo modelo";
        $icone = "error";

        mensagem($titulo, $mensagem, $icone);
    } else if (empty($opcionais)) {

        mensagem(
            "Erro ao salvar",
            "Preencha o campo descrição",
            "error"
        );
    }

    /*echo formatarValor($valor);

    	$v = "1.456,98";
    	echo "<br>".formatarValor($v);

    	echo "<br>".formatarValor('1.672,91');*/

    $valor = formatarValor($valor);

    //programação para copiar uma fotodestaque
    //no insert envio da foto é obrigatório
    //no update só se for selecionada uma nova fotodestaque

    //print_r ( $_FILES );

    //se o id estiver em branco e o fotodestaque tbém - erro
    if ((empty($id)) and (empty($_FILES['fotodestaque']['name']))) {
        mensagem(
            "Erro ao enviar foto de destaque",
            "Selecione um arquivo JPG válido",
            "error"
        );
    }

    $usuario = $_SESSION['submarino']['id'];

    //se existir fotodestaque - copia para o servidor
    if (!empty($_FILES['fotodestaque']['name'])) {
        //calculo para saber quantos mb tem o arquivo
        $tamanho = $_FILES['fotodestaque']['size'];
        $t = 8 * 1024 * 1024; //byte - kbyte - megabyte

        $fotodestaque = time();

        //definir um nome para a fotodestaque
        $fotodestaque = "veiculo_{$fotodestaque}_{$usuario}";

        //echo "<p>{$fotodestaque}</p>"; exit;

        //validar se é jpg
        if (empty($fotodestaque)){
            mensagem(
                "OK",
                "Registro salvo/alterado com sucesso!",
                "ok"
            );

        }
        if ($_FILES['fotodestaque']['type'] != 'image/jpeg') {
            mensagem(
                "Erro ao enviar Foto",
                "O arquivo enviado não é um JPG válido, selecione um arquivo JPG",
                "error"
            );
        } else if ($tamanho > $t) {
            mensagem(
                "Erro ao enviar Foto",
                "O arquivo é muito grande e não pode ser enviado. Tente arquivos menores que 8 MB",
                "error"
            );
        } else if (!copy($_FILES['fotodestaque']['tmp_name'], '../veiculos/' . $_FILES['fotodestaque']['name'])) {
            mensagem(
                "Erro ao enviar Foto",
                "Não foi possível copiar o arquivo para o servidor",
                "error"
            );
        }

        //redimensionar a fotodestaque
        $pastaFotos = '../veiculos/';
        loadImg(
            $pastaFotos . $_FILES['fotodestaque']['name'],
            $fotodestaque,
            $pastaFotos
        );
    } //fim da verificação da foto
    //se vai dar insert ou update
    if (empty($id)) {

        $sql = "insert into veiculo(id, modelo, usuario_id, opcionais, valor, anomodelo, anofabricacao, fotodestaque, tipo, cor_id, marca_id) values( NULL, :modelo, :usuario_id, :opcionais, :valor, :anomodelo, :anofabricacao, :fotodestaque, :tipo, :cor_id, :marca_id)";
        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(':modelo', $modelo);
        $consulta->bindParam(':usuario_id', $usuario);
        $consulta->bindParam(':opcionais', $opcionais);
        $consulta->bindParam(':valor', $valor);
        $consulta->bindParam(':anomodelo', $anomodelo);
        $consulta->bindParam(':anofabricacao', $anofabricacao);
        $consulta->bindParam(':fotodestaque', $fotodestaque);
        $consulta->bindParam(':tipo', $tipo);
        $consulta->bindParam(':cor_id', $cor_id);
        $consulta->bindParam(':marca_id', $marca_id);
    } else if (empty($fotodestaque)) {

        $sql = "update veiculo set modelo = :modelo, usuario_id = :usuario_id, opcionais = :opcionais, valor = :valor, 
                                       anomodelo = :anomodelo, anofabricacao = :anofabricacao, tipo = :tipo, 
                                       cor_id = :cor_id, marca_id = :marca_id
                    where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':modelo', $modelo);
        $consulta->bindParam(':usuario_id', $usuario);
        $consulta->bindParam(':opcionais', $opcionais);
        $consulta->bindParam(':valor', $valor);
        $consulta->bindParam(':anomodelo', $anomodelo);
        $consulta->bindParam(':anofabricacao', $anofabricacao);
        $consulta->bindParam(':tipo', $tipo);
        $consulta->bindParam(':cor_id', $cor_id);
        $consulta->bindParam(':marca_id', $marca_id);
        $consulta->bindParam(':id', $id);
    } else {

        $sql = "update veiculo set modelo = :modelo, usuario_id = :usuario_id, opcionais = :opcionais, valor = :valor, 
                                       anomodelo = :anomodelo, anofabricacao = :anofabricacao,
                                       fotodestaque = :fotodestaque, tipo = :tipo, cor_id = :cor_id, marca_id = :marca_id
                    where id = :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':modelo', $modelo);
        $consulta->bindParam(':usuario_id', $usuario);
        $consulta->bindParam(':opcionais', $opcionais);
        $consulta->bindParam(':valor', $valor);
        $consulta->bindParam(':anomodelo', $anomodelo);
        $consulta->bindParam(':anofabricacao', $anofabricacao);
        $consulta->bindParam(':fotodestaque', $fotodestaque);
        $consulta->bindParam(':tipo', $tipo);
        $consulta->bindParam(':cor_id', $cor_id);
        $consulta->bindParam(':marca_id', $marca_id);
        $consulta->bindParam(':id', $id);
    }

    //executar e verificar se foi salvo de verdade
    if ($consulta->execute()) {
        mensagem(
            "OK",
            "Registro salvo/alterado com sucesso!",
            "ok"
        );
    } else {
        echo $erro = $consulta->errorInfo()[2];

        mensagem(
            "Erro",
            "Erro ao salvar ou alterar registro",
            "error"
        );
    }
}
