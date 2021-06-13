<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    if ( $_POST ) {

    	//recuperar o id e o nome da cor//cores
    	$id 	   = trim ( $_POST['id'] ?? NULL );
    	$cor = trim ( $_POST['cor'] ?? NULL );

        //verificar se este registro já está salvo no banco
        $sql = "select id from cor 
            where cor = :cor 
            AND id <> :id 
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':cor', $cor);
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //se vier preenchido já existe uma cor com este nome
        if ( ! empty ( $dados->id ) ) {
            ?>
            <script>
                //mostrar a telinha animada - alert
                Swal.fire(
                  'Erro',
                  'Já existe um registro cadastrado com essa característica',
                  'error'
                ).then((result) => {
                    //retornar para a tela anterior
                    history.back();
                })
            </script>
            <?php

            exit;
        }

    	//se o id estiver em branco - insert
    	if ( empty ( $id ) ) {
    		$sql = "insert into cor values(NULL, :cor)";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(':cor', $cor);

    	} else {
    		$sql = "update cor set cor = :cor where id = :id limit 1";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(':cor', $cor);
    		$consulta->bindParam(':id', $id);

    	}

    	//executar
    	if ( $consulta->execute() ) {
    		
            ?>
            <script>
                //mostrar a telinha animada - alert
                Swal.fire(
                  'Sucesso!',
                  'Registro salvo com sucesso!',
                  'success'
                ).then((result) => {
                    //retornar para a tela anterior
                    //history.back();
                    //mandar para tela de listagem
                    location.href='listar/cores';
                })
            </script>
            <?php

    		exit;
    	}

    	//mostrar mensagem de erro do sql
    	//echo $consulta->errorInfo()[2];
    	?>
        <script>
            //mostrar a telinha animada - alert
            Swal.fire(
              'Erro',
              'Erro ao salvar registro',
              'error'
            ).then((result) => {
                //retornar para a tela anterior
                history.back();
            })
        </script>
        <?php

    	exit;
    }

    //se não foi enviado nada por POST
    //echo "<script>alert('Requisição inválida');history.back();</script>";

    ?>
    <script>
        //mostrar a telinha animada - alert
        Swal.fire(
          'Erro',
          'Requisição Inválida',
          'error'
        ).then((result) => {
            //retornar para a tela anterior
            history.back();
        })
    </script>
    <?php