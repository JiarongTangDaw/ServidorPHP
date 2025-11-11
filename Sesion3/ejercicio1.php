<form action="ejercicio1.php" method="post">
    <label>Editoriales</label><br>
    <input type="radio" name="editorial" value="marvel">Marvel<br/>
    <input type="radio" name="editorial" value="dc">DC<br/>
    <input type="radio" name="editorial" value="image">Image<br/>

    <label>Guionistas</label><br>
    <input type="checkbox" name="guionistas[]" value="guionista1"> Guionista1 <br/>
    <input type="checkbox" name="guionistas[]" value="guionista2"> Guionista2 <br/>
    <input type="checkbox" name="guionistas[]" value="guionista3"> Guionista3 <br/>
    <input type="checkbox" name="guionistas[]" value="guionista4"> Guionista4 <br/>
    <input type="checkbox" name="guionistas[]" value="guionista5"> Guionista5 <br/>
    <input type="checkbox" name="guionistas[]" value="guionista6"> Guionista6 <br/>

    <label>Personajes</label><br>
    <select name="personajes[]" size="6" multiple>
        <option value="personaje1">Personaje1</option>
        <option value="personaje2">Personaje2</option>
        <option value="personaje3">Personaje3</option>
        <option value="personaje4">Personaje4</option>
        <option value="personaje5">Personaje5</option>
        <option value="personaje6">Personaje6</option> 
    </select><br/>
    <input type="submit" value="Enviar"/><br>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<h3>Datos enviados:</h3>";
            foreach($_POST as $post){
                $tipo = gettype($post);
                if($tipo == "array"){
                    foreach($post as $valor){
                        echo $valor . "<br/>";
                    }
                } else {
                    print_r($post . "<br/>");
                }
            }
        }   
    ?>
</form>