<?php

namespace Quiz\models;

class RenderModel
{

    /**
     * renders a txt template and stores
     * the results in a variable
     * @param string $file
     * @param array mixed $data
     * @return string
     */
    protected $data = array("username_error" => "",
        "password_error" => "",
        "username" => "",
        "password" => "",
        "credential_error"=>"",
        "register"=>0,
        "error"=>"false");

    public function render($view, $data = array())
    {
        ob_start();
        include $view;
        $buffer = ob_get_contents();
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $buffer = str_replace("{{" . $key . "}}", $value, $buffer);
            }
        }
        $buffer = str_replace("{%%", "<?php", $buffer);
        $buffer = str_replace("%}", "?>", $buffer);
        ob_end_clean();
        file_put_contents(VIEW_PATH . "template_view.php", $buffer);
        return include VIEW_PATH . "template_view.php";
    }

    public function getRenderData()
    {
        return $this->data;
    }

}
