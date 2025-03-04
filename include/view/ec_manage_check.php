<script type="text/javascript">

    const idNameForm = document.getElementById('name_form');
    const idPriceForm = document.getElementById('price_form');
    const idStockForm = document.getElementById('stock_form');
    const idNameMsg = document.getElementById('name_check_msg');
    const idPriceMsg = document.getElementById('price_check_msg');
    const idStockMsg = document.getElementById('stock_check_msg');
    const idInputValue = document.getElementsByClassName('input_value');
    const idInputMsg = document.getElementsByClassName('input_check_msg');

    idNameForm.addEventListener('input', function() {
        const check = /\S/;
        if (!(idNameForm.value.match(check))) {
            idNameMsg.textContent = '　商品名を入力してください';
        } else {
            idNameMsg.textContent = '';
        }
    });

    idPriceForm.addEventListener('input', function(){
        const check = /^[0-9０-９]+$/;
        if (!(idPriceForm.value).match(check)) {
            idPriceMsg.textContent = '　0以上の整数を入力してください';
        } else {
            idPriceMsg.textContent = '';
        }
    });

    idStockForm.addEventListener('input', function(){
        const check = /^[0-9０-９]+$/;
        if (!(idStockForm.value).match(check)) {
            idStockMsg.textContent = '　0以上の整数を入力してください';
        } else {
            idStockMsg.textContent = '';
        }
    });

    for (let i = 0; i < idInputValue.length; i++) {
        idInputValue[i].addEventListener('input', function() {
            const check = /^[0-9]+$/;
            if (!(idInputValue[i].value).match(check)) {
                idInputMsg[i].textContent = '0以上の整数を入力してください';
            } else {
                idInputMsg[i].textContent = '';
            }
        });
    }

</script>