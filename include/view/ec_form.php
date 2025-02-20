<form method="post">
    <p>ユーザー名
    <input type="text" name="user_name" pattern="^\w{5,}$" title="「5文字以上」かつ「半角英数字とアンダースコア」のみ有効です"></p>
    <p>パスワード
    <input type="password" name="user_password" pattern="^\w{8,}$" title="「8文字以上」かつ「半角英数字とアンダースコア」のみ有効です"></p>
    <button class="form_btn"><?php echo $btn_title; ?></button>
</form>
