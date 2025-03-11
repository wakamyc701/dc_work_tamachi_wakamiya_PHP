<script type="text/javascript">

    function funcBtn() {
        if (btnFlg0 == 1 && btnFlg1 == 1 && btnFlg2 == 1 && btnFlg3 == 1) {
            idFormBtn.disabled = false;
        } else {
            idFormBtn.disabled = true;
        }
    }

    let btnFlg0 = 0;
    let btnFlg1 = 0;
    let btnFlg2 = 0;
    let btnFlg3 = 0;

    const idNameForm = document.getElementById('name_form');
    const idNameMsg = document.getElementById('name_check_msg');
    const idPriceForm = document.getElementById('price_form');
    const idPriceMsg = document.getElementById('price_check_msg');
    const idStockForm = document.getElementById('stock_form');
    const idStockMsg = document.getElementById('stock_check_msg');
    const idFileBtn = document.getElementById('file_btn');
    const idFileMsg = document.getElementById('file_check_msg');
    const idFormBtn = document.getElementById('form_btn');
    const idChangeStockForm = document.getElementsByClassName('change_stock_form');
    const idChangeStockBtn = document.getElementsByClassName('change_stock_btn');
    const idChangeStockMsg = document.getElementsByClassName('change_stock_check_msg');

    idNameForm.addEventListener('input', function() {
        const check = /\S+/;
        if (!(idNameForm.value.match(check))) {
            idNameMsg.textContent = '　商品名を入力してください';
            btnFlg0 = 0;
            idFormBtn.disabled = true;
        } else {
            idNameMsg.textContent = '';
            btnFlg0 = 1;
            funcBtn();
        }
    });

    idPriceForm.addEventListener('input', function(){
        const check = /^[0-9０-９]+$/;
        if (!(idPriceForm.value).match(check)) {
            idPriceMsg.textContent = '　0以上の整数を入力してください';
            btnFlg1 = 0;
            idFormBtn.disabled = true;
        } else {
            idPriceMsg.textContent = '';
            btnFlg1 = 1;
            funcBtn();
        }
    });

    idStockForm.addEventListener('input', function(){
        const check = /^[0-9０-９]+$/;
        if (!(idStockForm.value).match(check)) {
            idStockMsg.textContent = '　0以上の整数を入力してください';
            btnFlg2 = 0;
            idFormBtn.disabled = true;
        } else {
            idStockMsg.textContent = '';
            btnFlg2 = 1;
            funcBtn();
        }
    });

    idFileBtn.addEventListener('change', function(){
        const files = idFileBtn.files;
        //console.log(files);
        if ((files[0].type == "image/jpeg" || files[0].type == "image/png") && (files[0].size > 0)) {
            idFileMsg.textContent = '';
            btnFlg3 = 1;
            funcBtn();
        } else {
            idFileMsg.textContent = 'JPEGまたはPNG形式のファイルを選択してください';
            btnFlg3 = 0;
            idFormBtn.disabled = true;
        }
    })

    for (let i = 0; i < idChangeStockForm.length; i++) {
        idChangeStockForm[i].addEventListener('input', function() {
            const check = /^[0-9]+$/;
            if (!(idChangeStockForm[i].value).match(check)) {
                idChangeStockMsg[i].textContent = '0以上の整数を入力してください';
                idChangeStockBtn[i].disabled = true;
            } else {
                idChangeStockMsg[i].textContent = '';
                idChangeStockBtn[i].disabled = false;
            }
        });
    }

</script>