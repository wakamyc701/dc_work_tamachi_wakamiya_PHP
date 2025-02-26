const idNameForm = document.getElementById('name_form');
const idPwdForm = document.getElementById('pwd_form');
const idNameMsg = document.getElementById('name_check_msg');
const idPwdMsg = document.getElementById('pwd_check_msg');

idNameForm.addEventListener('input', checkNameForm);
idPwdForm.addEventListener('input', checkPwdForm);

function checkNameForm() {
    console.log('hoge');

    const check = /^\w{5,}$/;

    if (!(idNameForm.textContent).match(check)) {
        idNameMsg.textContent = '';
    } else {
        idNameMsg.textContent = 'hoge';
    }
}
