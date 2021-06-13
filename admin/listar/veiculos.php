<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;
?>
<div class="card">
    <div class="card-header">
        <h3 class="float-left">Listagem de Veículos</h3>

        <div class="float-right">
        	<a href="cadastros/veiculos" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/veiculos" class="btn btn-info">
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
                    <td width="30%">Nome do Modelo</td>
                    <td width="10%">Modelo/Fabricação</td>
                    <td width="20%">Marca</td>
                    <td width="10%">Valor</td>
                    <td width="10%">Imagem</td>
                    <td width="10%">Opções</td>
                </tr>      
            </thead>
            <tbody>
                <?php

                    $sql = "select v.id, v.modelo, v.valor, v.anoFabricacao, v.anomodelo, v.fotoDestaque, c.cor, m.marca
                        from veiculo v, cor c, marca m
                        where v.marca_id = m.id
                          and c.id = v.cor_id
                        order by v.modelo";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

                        $valor  = number_format( $dados->valor,2, ',' , '.' );
                        
                        $fotoDestaque= "../veiculos/{$dados->fotoDestaque}p.jpg"; 
                        $imagemg = "../veiculos/{$dados->fotoDestaque}g.jpg";

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->modelo?></td>
                            <td><?=$dados->anomodelo?>/<?=$dados->anoFabricacao?></td>
                            <td><?=$dados->marca?></td>
                            <td><?=$valor?></td>
                            <td>
                                <a href="<?=$imagemg?>" data-lightbox="foto" title="<?=$dados->modelo?>">
                                    <img src="<?=$fotoDestaque?>" alt="<?=$dados->modelo?>" width="100px">
                                </a>
                            </td>
                            <td>
                                <a href="cadastros/veiculos/<?=$dados->id?>" class="btn btn-success btn-sm">
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
            location.href='excluir/veiculos/'+id;
          } 
        })
    }
</script>
<script src="js/dataTable.js"></script>