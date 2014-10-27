<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Fact extends ORM
{

    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty')
            ),
            'is_true' => array(
                array('not_empty')
            ),
            'category_id' => array(
                array('not_empty')
            )
        );
    }

    public function create_fact($req)
    {
        $this->title = $req->post("title");
        $this->category_id = $req->post("category");
        $this->is_true = $req->post("is_true");
        $this->save();
    }

    public function update_fact($fact, $req)
    {
        $fact->title = $req->post("title");
        $fact->category_id = $req->post("category");
        $fact->is_true = $req->post("is_true");
        $fact->update();
    }

} // End  Fact
