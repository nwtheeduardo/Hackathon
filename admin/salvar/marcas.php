<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    if ( $_POST ) {

    	//recuperar o id e o nome da marca
    	$id 	   = trim ( $_POST['id'] ?? NULL );
    	$marca = trim ( $_POST['marca'] ?? NULL );

        //verificar se este registro já está salvo no banco
        $sql = "select id from marca 
            where marca = :marca 
            AND id <> :id 
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':marca', $marca);
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        
        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //se vier preenchido já existe uma marca com este nome
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
    		$sql = "insert into marca values(NULL, :marca)";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(':marca', $marca);

    	} else {
    		$sql = "update marca set marca = :marca where id = :id limit 1";
    		$consulta = $pdo->prepare($sql);
    		$consulta->bindParam(':marca', $marca);
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
                    location.href='listar/marcas';
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