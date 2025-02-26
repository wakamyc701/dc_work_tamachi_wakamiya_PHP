<form method="post">
    <p>ユーザー名
    <input id="name_form" type="text" name="user_name" pattern="^\w{5,}$" title="「5文字以上」かつ「半角英数字とアンダースコア」で入力してください"></p>
    <p id="name_check_msg" class="red_text small_text caution_msg_bottom">「5文字以上」かつ「半角英数字とアンダースコア」で入力してください</p>
    <p>パスワード
    <input id="pwd_form" type="password" name="user_password" pattern="^\w{8,}$" title="「8文字以上」かつ「半角英数字とアンダースコア」で入力してください"></p>
    <p id="pwd_check_msg" class="red_text small_text caution_msg_bottom">「8文字以上」かつ「半角英数字とアンダースコア」で入力してください</p>
    <button class="form_btn"><?php echo $btn_title; ?></button>
</form>
