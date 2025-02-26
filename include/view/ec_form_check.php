<script type="text/javascript">

    function checkNameForm() {
        const check = /^\w{5,}$/;

        if (!(idNameForm.value.match(check))) {
            idNameMsg.textContent = '「5文字以上」かつ「半角英数字とアンダースコア」で入力してください';
        } else {
            idNameMsg.textContent = '';
        }
    }

    function checkPwdForm() {
        const check = /^\w{8,}$/;

        if (!(idPwdForm.value).match(check)) {
            idPwdMsg.textContent = '「8文字以上」かつ「半角英数字とアンダースコア」で入力してください';
        } else {
            idPwdMsg.textContent = '';
        }
    }

    let idNameForm = document.getElementById('name_form');
    let idPwdForm = document.getElementById('pwd_form');
    let idNameMsg = document.getElementById('name_check_msg');
    let idPwdMsg = document.getElementById('pwd_check_msg');

    idNameForm.addEventListener('input', checkNameForm);
    idPwdForm.addEventListener('input', checkPwdForm);

</script>