<select name="categorie" id="categories">
    <?php     
        $categories = obtenir_categories();                       
        if(isset($categories)){                                
            foreach($categories as $row){
                $id = $row['id'];
                $titre = $row['titre'];
                echo "                    
                    <option value='$id' >$titre</option>";
            }
        }else
            echo "<option value='6'>divers</option>";
    ?>
</select>