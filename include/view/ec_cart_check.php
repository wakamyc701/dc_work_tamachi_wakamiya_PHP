<script type="text/javascript">

    const idChangeQtyForm = document.getElementsByClassName('change_qty_form');
    const idChangeQtyBtn = document.getElementsByClassName('change_qty_btn');
    const idChangeQtyMsg = document.getElementsByClassName('change_qty_check_msg');
    
    for (let i = 0; i < idChangeQtyForm.length; i++) {
        idChangeQtyForm[i].addEventListener('input', function() {
            const check = /^[0-9]+$/;
            if (idChangeQtyForm[i].value < 1 || Number(idChangeQtyForm[i].value) > Number(idChangeQtyForm[i].max) || !(idChangeQtyForm[i].value).match(check)) {
                idChangeQtyMsg[i].textContent = '1～' + idChangeQtyForm[i].max + 'の整数を入力してください';
                idChangeQtyBtn[i].disabled = true;
            } else {
                idChangeQtyMsg[i].textContent = '';
                idChangeQtyBtn[i].disabled = false;
            }
        });
    }

</script>