# Anotacoes para o trabalho:

## Como inserir uma imagem no banco de dados:

### Primeiro vai se criar a tabela de imagem no mysql e colocar a imagem como BLOB, depois no PHP vai criar um form que precisa ter enctype="multipart/form-data" como especificacao ao lado do action.

### o input para telechargher a imagem vai ser <input type="file" name="image"/>

### e na conexao do PHP com my sql vamos colocar a imagem como: 
$image = addslashes(file_get_contents($_FILES["image"]["tmp_name"])); 
- onde o image sera o name="" dado no input

### podemos colocar um alerta no javascript para avisar que a imagem foi criada:
if($query_run){
    echo '<script type="text/javascript"> alert("Image Uploaded")</script>';
}