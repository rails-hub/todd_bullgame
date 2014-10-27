<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Category extends ORM
{

    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty')
            )
        );
    }

    public function create_category($req)
    {
        $this->title = $req->post("title");
        $this->save();

    }

    public function update_category($category, $req)
    {
        $category->title = $req->post("title");
        $category->update();
    }

} // End  Category
