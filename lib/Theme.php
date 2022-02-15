<?php

class Theme{
    
    public function render($View,$Options = array()){
        ob_start();
        extract($Options);
        include(__DIR__ . '/../views/' .  $View . '.php');
        $content = ob_get_contents();
        // ob_end_clean();
        return $content;
    
    }
    
}
$theme = new Theme();
?>