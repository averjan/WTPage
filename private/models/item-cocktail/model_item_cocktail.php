<?php


class model_item_cocktail extends Model
{
    public function get_data(): ?array
    {
        return array(
            array(
                'Name' => 'White Russian',
                'FileName' => 'WhiteRussian',
                'Description' => 'Промо-сайт темного пива Dunkel от немецкого производителя Löwenbraü выпускаемого в России пивоваренной компанией "CАН ИнБев".'
            ),
            array(
                'Name' => 'Bloody Mary',
                'FileName' => 'BloodyMary',
                'Description' => 'Русскоязычный каталог китайских телефонов компании Zopo на базе Android OS и аксессуаров к ним.'
            ),

        );
    }
}