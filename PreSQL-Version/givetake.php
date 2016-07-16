<?php
function s70($in){
	$a=substr($in."\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n",0,70);
	return $a;
}
function Int8($in){
	$a= substr($in."\n\n\n\n\n\n\n",0,8);
	return $a;
}

function st12($in){
	$a= substr($in."\n\n\n",0,12);
	return $a;
}

function listtake($fh,$item){
	$eof=fread($fh,12);
	$tvar=fseek($fh,12*$eof);
	$repl=st12(fread($fh,12));
	$eof=$eof-1;
	$eof=int8($eof);
	$tvar=rewind($fh);
	$tvar=fwrite($fh,$eof,12);
	if (trim($repl)==trim($item)){
		$tvar=fclose($fh);
		return $eof;
	}
	$tvar=rewind($fh);
	$tvar=fseek($fh,12);
	while (trim($tvar2)!=trim($item)){
	$tv=$tv+12;   //20
	$tvar2=fread($fh,12);}
	$tvar=fseek($fh,$tv);
	$tvar=fwrite($fh,$repl,12);
	$tvar=fclose($fh);
	return $eof;
} 
				     //20
function listadd($fh,$item){
	$eof=fread($fh,12);
	$tvar=rewind($fh);
	$eof=$eof+1;
	$eof="    "+int8($eof);
	$tvar=fwrite($fh,$eof,12);
	$tvar=fseek($fh,12*$eof);
	$tvar=fwrite($fh,$item,12);
	$tvar=fclose($fh);
	return $eof;
}
?>