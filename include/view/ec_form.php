<form method="post">
    <p><label for="name_form">ユーザー名</label>
    <input id="name_form" type="text" name="user_name" pattern="^\w{5,}$" 
    title="「5文字以上」かつ「半角英数字とアンダースコア」で入力してください"></p>
    <p id="name_check_msg" class="red_text small_text caution_msg_bottom">「5文字以上」かつ「半角英数字とアンダースコア」で入力してください</p>
    <p><label for="pwd_form">パスワード</label>
    <input id="pwd_form" type="password" name="user_password" pattern="^\w{8,}$" 
    title="「8文字以上」かつ「半角英数字とアンダースコア」で入力してください"></p>
    <p id="pwd_check_msg" class="red_text small_text caution_msg_bottom">「8文字以上」かつ「半角英数字とアンダースコア」で入力してください</p>
    <button id="form_btn" class="form_btn" disabled="true"><?php echo $btn_title; ?></button>
</form>
