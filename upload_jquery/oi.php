<?php
$conexao = mysql_connect('localhost','root','bcd127');
mysql_select_db('dbcontatos20181');

if(isset($_POST['txtnome'])){
    $nome = $_POST['txtnome'];
    $nome_foto = $_POST['txtfoto'];

    $sql = "insert into tblfotos (nome, foto) values ('".$nome."', '".$nome_foto."')";

    mysql_query($sql);

    header("location:oi.php");
}

?>

<html>
    <head>
        <style>

        </style>
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.form.js"></script>

        <script>
            //Evento padrão para carregar as funções em jQuery.
            //O uso desse evento é obrigatório para colocar as funções do projeto
            $(document).ready(function(){
                //Função para o estado live do objeto file, que seria quando o objeto for acionado/modificado pelo evento change
                $('#fotos').live('change', function(){
                    //Criando uma imagem em .gif para colocar o gif animado
                    $('#visualizar').html('<img src="gifs/ajax-loader.gif">');
                    //Temporizador de 2 segundos para executar o gif animado e depois fazer o ajaxForm
                    setTimeout(function(){
                        //forçando via ajax um submit do form da foto, já que não temos um botão
                        $('#frmfoto').ajaxForm({
                            target:'#visualizar'
                            //target:'#visualizar' - retorna a imagem na div visualizar ('callback do formulário'). É um parâmetro da função.
                        }).submit();
                    },2000);

                });
                $('#btnSalvar').click(function(){
                    $('#visualizar').html('<img src="gifs/ajax-salvando.gif">');
                    setTimeout(function(){
                        frmcadastro.submit();
                    }, 2000);
                });
            });
        </script>
    </head>
    <body>
        <div>
            <form name="frmfoto" method="post" action="upload.php" enctype="multipart/form-data" id="frmfoto">
                Foto:<input type="file" name="flefoto" id="fotos"><br><br>
            </form>

            <form action="oi.php" method="post" name="frmcadastro" id="frmcadastro">
                Nome:<input type="text" name="txtnome">
                <input type="hidden" name="txtfoto">
                <br><br>
                <input id="btnSalvar" type="button" name="btnSalvar" value="Salvar">
            </form>
        </div>

        <div id="visualizar">
            oi
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