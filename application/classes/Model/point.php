<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Point extends ORM
{

    public function rules()
    {
        return array(
            'guess_right' => array(
                array('not_empty')
            ),
            'guess_wrong' => array(
                array('not_empty')
            )
        );
    }

    public function create_point()
    {
    }

} // End  Point
