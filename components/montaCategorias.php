<?php
function listaCategorias()
{
    include './sql/connection.php';
    $sql = "CALL lista_categorias()";
    $result = $connection->prepare($sql);
    $result->execute();
    $categorias = $result->fetchAll(PDO::FETCH_OBJ);

    return $categorias;
};

function montaCategorias(){
    $radio = '<div>';
    $categorias = listaCategorias();
    foreach ($categorias as $categoria) {
        $radio .= "
        <input type='radio' name='categoria' value={$categoria->resultado} />
        <label>.   {$categoria->resultado}</label>
        <br>
        ";
    }
    $radio .= '</div>';

    echo $radio;
}