<?php
if(isset($_POST)){
    //para recuperar um dado do tipo file, é obrigatório usar $_FILES

    //usar o comando basename quando não retornar apenas o nome (depende da versão do PHP)
    $nome_arquivo = basename($_FILES['flefoto']['name']);

    //retorna somente a escrita a partir da ocorrência do último caracter
    $ext = strrchr($nome_arquivo,".");

    //guarda apenas o nome do arquivo sem a sua extensão
    $nome_foto = pathinfo($nome_arquivo, PATHINFO_FILENAME);

    $nome_arquivo = md5(uniqid(time()).$nome_foto).$ext;

    //echo($nome_arquivo);

    $tamanho_arquivo = round(($_FILES['flefoto']['size'])/1024);

    //nome da pasta que foi criada para guardar as fotos
    $upload_dir = "arquivos/";

    $arquivos_permitidos = array(".jpg", ".png", ".gif", ".svg",".jpeg");

    $caminho_imagem = $upload_dir.$nome_arquivo;

    if(in_array($ext, $arquivos_permitidos))
    {
        if($tamanho_arquivo<=5120){
            $arquivo_tmp = $_FILES['flefoto']['tmp_name'];
            if(move_uploaded_file($arquivo_tmp, $caminho_imagem)){
                /*
                $sql="insert into tblfotos (nome, foto) values ('".$nome."', '".$caminho_imagem."')";
                mysql_query($sql);
                */
                echo("<img src='".$caminho_imagem."'>");
                echo("
                    <script>
                        frmcadastro.txtfoto.value='$caminho_imagem';
                    </script>
                ");
            } else{
                echo("Erro ao enviar o arquivo para o servidor");
            }
        } else{
            echo("Tamanho de arquivo inválido");
        }
    } else
    {
        echo("Arquivo não permitido");
    }
}
?>