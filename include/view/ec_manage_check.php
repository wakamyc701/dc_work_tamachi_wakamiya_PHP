<script type="text/javascript">

    function checkNameForm() {
        const check = /\S/;

        if (!(idNameForm.value.match(check))) {
            idNameMsg.textContent = '商品名を入力してください';
        } else {
            idNameMsg.textContent = '';
        }
    }

    function checkPriceForm() {
        const check = /^[0-9０-９]+$/;

        if (!(idPriceForm.value).match(check)) {
            idPriceMsg.textContent = '0以上の整数を入力してください';
        } else {
            idPriceMsg.textContent = '';
        }
    }

    function checkStockForm() {
        const check = /^[0-9０-９]+$/;
        
        if (!(idStockForm.value).match(check)) {
            idStockMsg.textContent = '0以上の整数を入力してください';
        } else {
            idStockMsg.textContent = '';
        }
    }

    
    function checkInputValue(i) {
        const check = /^[0-9０-９]+$/;
        console.log(idInputValue[i].value);

        if (!(idInputValue[i].value).match(check)) {
            idInputMsg[i].textContent = '0以上の整数を入力してください';
        } else {
            idInputMsg[i].textContent = 'OK';
        }
    }
    
    let idNameForm = document.getElementById('name_form');
    let idPriceForm = document.getElementById('price_form');
    let idStockForm = document.getElementById('stock_form');
    let idNameMsg = document.getElementById('name_check_msg');
    let idPriceMsg = document.getElementById('price_check_msg');
    let idStockMsg = document.getElementById('stock_check_msg');
    let idInputValue = document.getElementsByClassName('input_value');
    let idInputMsg = document.getElementsByClassName('input_check_msg');

    idNameForm.addEventListener('input', checkNameForm);
    idPriceForm.addEventListener('input', checkPriceForm);
    idStockForm.addEventListener('input', checkStockForm);

    for (let i = 0; i < idInputValue.length; i++) {
        idInputValue[i].addEventListener('input', function() {
            const check = /^[0-9０-９]+$/;
            console.log(idInputValue[i].value);

            if (!(idInputValue[i].value).match(check)) {
                idInputMsg[i].textContent = '0以上の整数を入力してください';
            } else {
                idInputMsg[i].textContent = '';
            }
        });
        //idInputValue[i].addEventListener('input', checkInputValue(i));
    }

</script>