<?php


class model_item_ingredient extends Model
{
    public function get_data(): ?array
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
        $sth = $dbo->prepare("SELECT * FROM ingredients");
        $sth->execute();
        /*
        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            str_replace(' ', '', $required_array['FileName']);
            array_push($cocktail_array, $required_array);
        }
        */
        $cocktail_array = $sth->fetchAll();
        return $cocktail_array;

    }

    public function get_data_filtered(array $filters): ?array
    {
        $dbo = new PDO('mysql:dbname=elgusto_main;host=averkin.tim',
            'test_user',
            '',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $cocktail_array = array();
<<<<<<< HEAD
        $sth = $dbo->prepare("SELECT * FROM ingredients WHERE Base LIKE :base AND Strong LIKE :strong AND Taste LIKE :taste AND NAME LIKE :item");
        $sth->execute(array('base' => $filters["Base"], 'strong' => $filters['Strong'], 'taste' => $filters['Taste'], 'item' => $filters['Name']));
=======
        $sth = $dbo->prepare("SELECT * FROM ingredients WHERE Base LIKE :base AND Strong LIKE :strong AND Taste LIKE :taste");
        $sth->execute(array('base' => $filters["Base"], 'strong' => $filters['Strong'], 'taste' => $filters['Taste']));

>>>>>>> 412af657fd6c7ca38d71531ea5c0a5c1285e8a53
        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            str_replace(' ', '', $required_array['FileName']);
            array_push($cocktail_array, $required_array);
        }

        //$cocktail_array = $sth->fetchAll();
        return $cocktail_array;
    }
}