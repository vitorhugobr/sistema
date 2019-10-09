<?php
session_start();
$_SESSION = array();
session_unset();
session_destroy();
session_start();

$_SESSION['loginSaida']="Saída do Sistema com sucesso!";
exit('<script>location.href = "index.php"</script>');

?>
