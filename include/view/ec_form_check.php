<script type="text/javascript">

    function funcBtn() {
        if (btnFlg0 == 1 && btnFlg1 == 1) {
            idFormBtn.disabled = false;
        } else {
            idFormBtn.disabled = true;
        }
    }

    let btnFlg0 = 0;
    let btnFlg1 = 0;

    const idNameForm = document.getElementById('name_form');
    const idPwdForm = document.getElementById('pwd_form');
    const idNameMsg = document.getElementById('name_check_msg');
    const idPwdMsg = document.getElementById('pwd_check_msg');
    const idFormBtn = document.getElementById('form_btn');

    idNameForm.addEventListener('input', function() {
        const check = /^\w{5,}$/;
        if (!(idNameForm.value.match(check))) {
            idNameMsg.textContent = '「5文字以上」かつ「半角英数字とアンダースコア」で入力してください';
            btnFlg0 = 0;
            idFormBtn.disabled = true;
        } else {
            idNameMsg.textContent = '';
            btnFlg0 = 1;
            funcBtn();
        }
    });

    idPwdForm.addEventListener('input', function() {
        const check = /^\w{8,}$/;
        if (!(idPwdForm.value).match(check)) {
            idPwdMsg.textContent = '「8文字以上」かつ「半角英数字とアンダースコア」で入力してください';
            btnFlg1 = 0;
            idFormBtn.disabled = true;
        } else {
            idPwdMsg.textContent = '';
            btnFlg1 = 1;
            funcBtn();
        }
    });

</script>