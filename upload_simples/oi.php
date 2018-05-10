<?php
$conexao = mysql_connect('localhost','root','bcd127');
mysql_select_db('dbcontatos20181');

if(isset($_POST['btnSalvar'])){
    $nome = $_POST['txtnome'];
    //para recuperar um dado do tipo file, é obrigatório usar $_FILES

    //usar o comando basename quando não retornar apenas o nome (depende da versão do PHP)
    $nome_arquivo = basename($_FILES['flefoto']['name']);

    //retorna somente a escrita a partir da ocorrência do último caracter
    $ext = strrchr($nome_arquivo,".");

    //guarda apenas o nome do arquivo sem a sua extensão
    $nome_foto = pathinfo($nome_arquivo, PATHINFO_FILENAME);

    $nome_arquivo = md5(uniqid(time()).$nome_foto).$ext;

    echo($nome_arquivo);

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
                $sql="insert into tblfotos (nome, foto) values ('".$nome."', '".$caminho_imagem."')";
                mysql_query($sql);
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

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div>
            <form action="oi.php" method="post" name="form" enctype="multipart/form-data">
                Nome:<input type="text" name="txtnome"><br><br>
                Foto:<input type="file" name="flefoto"><br><br>
                <input id="btnSalvar" type="submit" name="btnSalvar" value="Salvar">
            </form>
        </div>
        <div>
            <table id="resultado">
                <tr>
                    <td>
                        <p>Nome</p>
                    </td>
                    <td>
                        <p>Foto</p>
                    </td>
                </tr>
                <?php
                $sql = "select * from tblfotos";
                $resultadoSelect = mysql_query($sql);
                while ($foto = mysql_fetch_array($resultadoSelect)){?>
                <tr>
                    <td>
                        <p><?php echo($foto['nome']) ?></p>
                    </td>
                    <td>
                        <img src='<?php echo($foto['foto']) ?>' id='img_tabela'>
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </body>
</html>