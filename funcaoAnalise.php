<?php
    $q = strtolower($_GET['q']);
	if (!$q) return;
    
    include_once('conexao.php');
    
    #$sql = "SELECT protocolo.idprotocolo,protocolo.codigo, IF (protocolo.idprotocolo = analise.protocolo_idprotocolo,'true','false') FROM protocolo,analise WHERE protocolo.idprotocolo = analise.protocolo_idprotocolo AND protocolo.monitor = 'O' ORDER BY protocolo.codigo";
    $sql = "SELECT idprotocolo,codigo FROM protocolo WHERE monitor = 'O' ORDER BY codigo";
    $res = mysql_query($sql);
    $ret = mysql_num_rows($res);
    
        if($ret != 0) {
            while($lin = mysql_fetch_object($res)) {
                $items[$lin->codigo] = ($lin->idprotocolo);
            }
            
            foreach ($items as $key=>$value) {
                if (strpos(strtolower($key), $q) !== false) {
                    echo "$key|$value\n";
                }	
            }
        }
    
    mysql_close($conexao);
    unset($conexao,$charset,$sql,$res,$ret,$lin,$items,$key,$value);
?>