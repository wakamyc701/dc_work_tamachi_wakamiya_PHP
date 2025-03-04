<script type="text/javascript">

    const idInputValue = document.getElementsByClassName('input_value');
    const idInputMsg = document.getElementsByClassName('input_check_msg');

    for (let i = 0; i < idInputValue.length; i++) {
        idInputValue[i].addEventListener('input', function() {
            const check = /^[0-9]+$/;
            if (idInputValue[i].value < 1 || Number(idInputValue[i].value) > Number(idInputValue[i].max)) {
                idInputMsg[i].textContent = '1～' + idInputValue[i].max + 'の整数を入力してください';
            } else {
                idInputMsg[i].textContent = '';
            }
        });
    }

</script>