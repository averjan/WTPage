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
        while ($required_array = $sth->fetch(PDO::FETCH_ASSOC)) {
            str_replace(' ', '', $required_array['FileName']);
            array_push($cocktail_array, $required_array);
        }

        return $cocktail_array;
        /*
        return array(
            array(
                'ID' => 0,
                'Name' => 'Sprite',
                'FileName' => 'Sprite',
                'Description' => 'Сладкий газированный напиток производят на основе содовой с добавлением сахара и лимонного экстракта.'
            ),
            array(
                'ID' => 1,
                'Name' => 'Ice',
                'FileName' => 'Ice',
                'Description' => 'При производстве этого незаменимого ингредиента основное внимание уделяют чистоте воды и скорости заморозки. Чем медленнее замораживается вода, тем прозрачнее получается продукт. Идеальные образцы не имеют полостей и медленнее тают в бокале.'
            ),

        );
        */
    }
}