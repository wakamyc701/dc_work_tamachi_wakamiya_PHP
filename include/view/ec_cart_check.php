<script type="text/javascript">

    /*
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
    */

    // manage_checkからコピペしただけのもの
    const idChangeQtyForm = document.getElementsByClassName('change_qty_form');
    const idChangeQtyBtn = document.getElementsByClassName('change_qty_btn');
    const idChangeQtyMsg = document.getElementsByClassName('change_qty_check_msg');

    console.log(idChangeQtyForm.length);
    for (let i = 0; i < idChangeQtyForm.length; i++) {
        idChangeQtyForm[i].addEventListener('input', function() {
            const check = /^[0-9]+$/;
            console.log(idChangeQtyForm[i].value);
            if (!(idChangeQtyForm[i].value).match(check)) {
                idChangeQtyMsg[i].textContent = '0以上の整数を入力してください';
                idChangeQtyBtn[i].disabled = true;
            } else {
                idChangeQtyMsg[i].textContent = '';
                idChangeQtyBtn[i].disabled = false;
            }
        });
    }

</script>