<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Listagem de cores</h3>

        <div class="float-right">
        	<a href="cadastros/cores" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/cores" class="btn btn-info">
        		<i class="fas fa-search"></i> Listar
        	</a>
        </div>
    </div>
    <div class="card-body">
        <p>Resultados:</p>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <td width="10%">ID</td>
                    <td width="80%">Nome da cor</td>
                    <td width="10%">Opções</td>
                </tr>      
            </thead>
            <tbody>
                <?php
                    //selecionat todas as cores
                    $sql = "select * from cor order by cor";
                    //pdo -> prepare
                    $consulta = $pdo->prepare($sql);
                    //executar o comando sql
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ){

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->cor?></td>
                            <td>
                                <a href="cadastros/cores/<?=$dados->id?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="javascript:excluir(<?=$dados->id?>)" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php

                    }

                ?>               
                
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function excluir(id) {

        Swal.fire({
          title: 'Deseja realmente excluir este registro?',
          showCancelButton: true,
          confirmButtonText: `Sim`,
          cancelButtonText: `Não`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            //enviar para excluir
            location.href='excluir/cores/'+id;
          } 
        })
    }
</script>
<script src="js/dataTable.js"></script>