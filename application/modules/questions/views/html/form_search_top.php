<div class="mod_questions form_search_top">
<?php 
echo form_open('questions/create_search', 'id=form_search onsubmit=" if(this.q.value == \'\' ) return false; " class="accept_enter"');
echo form_input('q', str_replace("+"," ",$this->lib_url->_GET('q')) , "placeholder = 'từ khóa tìm kiếm' class='q'");
echo form_submit('submit','', "class='submit btn'");
echo form_close(); ?>
</div>