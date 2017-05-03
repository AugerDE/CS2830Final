<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getNotes(){
    return "<div class='notes'>
              <input class='noteTitle' type='text' />
              <textarea spellcheck='false'></textarea>
            </div>";
  }
?>
