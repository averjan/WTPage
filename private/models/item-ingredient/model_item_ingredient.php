<?php


class model_item_ingredient extends Model
{
    public function get_data(): ?array
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        //$cocktail_array = array();
        $sth = $dbo->prepare("SELECT * FROM ingredients");
        $sth->execute();
        /*
        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            str_replace(' ', '', $required_array['FileName']);
            array_push($cocktail_array, $required_array);
        }
        */
        //$cocktail_array = $sth->fetchAll();
        //return $cocktail_array;
        return $sth->fetchAll();
    }

    public function get_data_filtered(array $filters): ?array
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();

        $sth = $dbo->prepare("SELECT * FROM ingredients WHERE Base LIKE :base AND Strong LIKE :strong AND Taste LIKE :taste AND NAME LIKE :item");
        $sth->execute(array('base' => $filters["Base"], 'strong' => $filters['Strong'], 'taste' => $filters['Taste'], 'item' => $filters['Name']));

        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            str_replace(' ', '', $required_array['FileName']);
            array_push($cocktail_array, $required_array);
        }

        //$cocktail_array = $sth->fetchAll();
        return $cocktail_array;
    }

    function delete($id)
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $sth = $dbo->prepare("DELETE FROM ingredients WHERE ID = :id");
        $sth->execute(array(
            'id' => $id));
    }

    function push($item)
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
        $sth = $dbo->prepare("INSERT INTO ingredients SET Base = :base, Strong = :strong, Taste = :taste, Name = :item, FileName = :filename, Description = :description");
        $sth->execute(array(
            'base' => $item["Base"],
            'strong' => $item['Strong'],
            'taste' => $item['Taste'],
            'item' => $item['Name'],
            'filename' => $item['FileName'],
            'description' => $item['Description']));


        $insert_id = $dbo->lastInsertId();
        return $insert_id;
    }

    function save($item) {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $sth = $dbo->prepare("UPDATE ingredients SET Base = :base, Strong = :strong, Taste = :taste, Name = :item, FileName = :filename, Description = :description WHERE ID =:id");
        $sth->execute(array(
            'base' => $item["Base"],
            'strong' => $item['Strong'],
            'taste' => $item['Taste'],
            'item' => $item['Name'],
            'filename' => $item['FileName'],
            'description' => $item['Description'],
            'id' => $item['ID']));
    }
}