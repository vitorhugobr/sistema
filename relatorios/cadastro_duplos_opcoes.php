<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Parâmetros da Consulta</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
</script>
</head>
<body>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="javascript:window.history.back();">&times;</button>
                <h4 class="modal-title">Registros com Duplicidade no Cadastro</h4>
            </div>
            <div class="modal-body">
				<p>Mostrar os registros duplos com as seguintes opções de igualdade:</p>
                <form method="POST" action="cadastro_duplos.php" enctype="multipart/form-data">
                    <div class="checkbox">
					  <label><input name="cknome" type="checkbox" id="cknome" checked disabled>Nome</label>
					</div>
					<div class="checkbox">
					  <label><input name="cktelcelular" type="checkbox" id="ckcelular">Telefone Celular</label>
					</div>
					<div class="checkbox">
					  <label><input name="cktelresidencial" type="checkbox" id="ckresidencial">Telefone Residencial</label>
					</div>
                    <button type="submit" class="btn btn-sm btn-primary" >
					<i class="fas fa-list" aria-hidden="true text-muted" aria-hidden="true"></i> Visualizar
					</button>
                    <button type="button" class="btn btn-sm btn-voltar" onclick="javascript:window.history.back();">
					<i class="fas fa-backward" aria-hidden="true text-muted" aria-hidden="true"></i> Voltar
					</button>

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>                            