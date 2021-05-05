<?php


class model_item_cocktail extends Model
{
    public function get_data(): ?array
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
        $sth = $dbo->prepare("SELECT * FROM cocktails");
        $sth->execute();
        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            $call_ingredients = $dbo->prepare("SELECT * FROM recipe WHERE cocktailID = :current");
            $call_ingredients->execute(array('current' => $required_array['ID']));

            $required_array['Recipe'] = array();
            while ($recipe_element = $call_ingredients->fetch(PDO::FETCH_ASSOC))
            {
                $call_recipe = $dbo->prepare("SELECT * FROM ingredients WHERE ID = :id");
                $call_recipe->execute(array('id' => $recipe_element['ingredientID']));
                $ingredient = array();
                $ingredient["ingredient"] = $call_recipe->fetch(PDO::FETCH_ASSOC);
                $ingredient["measure"] = $recipe_element["measure"];
                $ingredient["count"] = $recipe_element["count"];
                array_push( $required_array['Recipe'], $ingredient);
            }

            $required_array['Steps'] = explode(".", $required_array['Steps']);
            $required_array['Categories'] = array();
            array_push(
                $required_array['Categories'],
                $required_array['Strong'],
                $required_array['Taste'],
                $required_array['Base']);
            array_push($cocktail_array, $required_array);
        }

        return $cocktail_array;
    }

    public function get_data_filtered(array $filters): ?array
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
        $sth = $dbo->prepare("SELECT * FROM cocktails WHERE Base LIKE :base AND Strong LIKE :strong AND Taste LIKE :taste AND NAME LIKE :item");
        $sth->execute(array(
            'base' => $filters["Base"],
            'strong' => $filters['Strong'],
            'taste' => $filters['Taste'],
            'item' => $filters['Item']));
        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            $call_ingredients = $dbo->prepare("SELECT * FROM recipe WHERE cocktailID = :current");
            $call_ingredients->execute(array('current' => $required_array['ID']));

            $required_array['Recipe'] = array();
            while ($recipe_element = $call_ingredients->fetch(PDO::FETCH_ASSOC))
            {
                $call_recipe = $dbo->prepare("SELECT * FROM ingredients WHERE ID = :id");
                $call_recipe->execute(array('id' => $recipe_element['ingredientID']));
                $ingredient = array();
                $ingredient["ingredient"] = $call_recipe->fetch(PDO::FETCH_ASSOC);
                $ingredient["measure"] = $recipe_element["measure"];
                $ingredient["count"] = $recipe_element["count"];
                array_push( $required_array['Recipe'], $ingredient);
            }

            $required_array['Steps'] = explode(".", $required_array['Steps']);
            $required_array['Categories'] = array();
            array_push(
                $required_array['Categories'],
                $required_array['Strong'],
                $required_array['Taste'],
                $required_array['Base']);
            array_push($cocktail_array, $required_array);
        }

        return $cocktail_array;
    }

    function push($item)
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
        $sth = $dbo->prepare("INSERT INTO cocktails SET Base = :base, Strong = :strong, Taste = :taste, Name = :item, FileName = :filename, Steps = :steps, Description = :description");
        $sth->execute(array(
            'base' => $item["Base"],
            'strong' => $item['Strong'],
            'taste' => $item['Taste'],
            'item' => $item['Name'],
            'filename' => $item['FileName'],
            'steps' => $item['Steps'],
            'description' => $item['Description']));


        $insert_id = $dbo->lastInsertId();
        $this->set_ingredients(json_decode($item['list']), $insert_id);
        return $insert_id;
    }

    private function set_ingredients($ingredient_array, $id) {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        foreach ($ingredient_array as $item) {
            $item = (array) $item;
            $sth = $dbo->prepare("INSERT INTO `recipe` SET `cocktailID` = :cocktailid, `ingredientID` = :ingredientid, `count` = :count, `measure` = :measure");
            $sth->execute(array(
                ':cocktailid' => $id,
                ':ingredientid' => $item['id'],
                ':count' => $item['count'],
                ':measure' => $item['measure']
            ));
        }
    }

    function save($item) {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
        $sth = $dbo->prepare("UPDATE cocktails SET Base = :base, Strong = :strong, Taste = :taste, Name = :item, FileName = :filename, Steps = :steps, Description = :description WHERE ID = :id");
        $sth->execute(array(
            'base' => $item["Base"],
            'strong' => $item['Strong'],
            'taste' => $item['Taste'],
            'item' => $item['Name'],
            'filename' => $item['FileName'],
            'steps' => $item['Steps'],
            'description' => $item['Description'],
            'id' => $item['ID']));


        $this->update_ingredients(json_decode($item['list']), $item['ID']);
    }

    private function update_ingredients($ingredient_array, $id) {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $sth = $dbo->prepare("DELETE FROM `recipe` WHERE `cocktailID` = :id");
        $sth->execute(array(':id' => $id));
        foreach ($ingredient_array as $item) {
            $item = (array) $item;
            $sth = $dbo->prepare("INSERT INTO `recipe` SET `cocktailID` = :cocktailid, `ingredientID` = :ingredientid, `count` = :count, `measure` = :measure");
            $sth->execute(array(
                ':cocktailid' => $id,
                ':ingredientid' => $item['id'],
                ':count' => $item['count'],
                ':measure' => $item['measure']
            ));
        }
    }

    function get_id($item) {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $sth = $dbo->prepare("SELECT * FROM cocktails WHERE Base = :base AND Strong = :strong AND Taste = :taste AND Name = :item AND FileName = :filename AND Steps = :steps AND Description = :description");
        $sth->execute(array(
            'base' => $item["Base"],
            'strong' => $item['Strong'],
            'taste' => $item['Taste'],
            'item' => $item['Name'],
            'filename' => $item['FileName'],
            'steps' => $item['Steps'],
            'description' => $item['Description']));

        $item = $sth->fetch(PDO::FETCH_ASSOC);
        return $item['ID'];
    }

    function delete($id)
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
        $sth = $dbo->prepare("DELETE FROM cocktails WHERE ID = :id");
        $sth->execute(array(
            'id' => $id));
    }
}