<script type="text/javascript">

    const idNameForm = document.getElementById('name_form');
    const idPwdForm = document.getElementById('pwd_form');
    const idNameMsg = document.getElementById('name_check_msg');
    const idPwdMsg = document.getElementById('pwd_check_msg');
    const idFormBtn = document.getElementById('form_btn');

    let hoge = 0;
    let hogehoge = 0;

    function funchoge() {
        if (hoge == 1 && hogehoge == 1) {
            idFormBtn.disabled = false;
        } else {
            idFormBtn.disabled = true;
        }
    }

    idNameForm.addEventListener('input', function() {
        const check = /^\w{5,}$/;
        if (!(idNameForm.value.match(check))) {
            idNameMsg.textContent = '「5文字以上」かつ「半角英数字とアンダースコア」で入力してください';
            idFormBtn.disabled = true;
            hoge = 0;
        } else {
            idNameMsg.textContent = '';
            //idFormBtn.disabled = false;
            hoge = 1;
            funchoge();
        }
    });

    idPwdForm.addEventListener('input', function() {
        const check = /^\w{8,}$/;
        if (!(idPwdForm.value).match(check)) {
            idPwdMsg.textContent = '「8文字以上」かつ「半角英数字とアンダースコア」で入力してください';
            idFormBtn.disabled = true;
            hogehoge = 0;
        } else {
            idPwdMsg.textContent = '';
            //idFormBtn.disabled = false;
            hogehoge = 1;
            funchoge();
        }
    });

</script>