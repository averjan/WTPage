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
}