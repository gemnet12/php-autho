const $signUpForm = document.querySelector('#sign-up');
const $signInForm = document.querySelector('#sign-in');

$signUpForm.onsubmit = handleForm('sign_up.php');

$signInForm.onsubmit = handleForm('sign_in.php');

function handleForm(url) {
    return async (e) => {
        e.preventDefault();
        document.querySelectorAll('.err-span').forEach((elem) => {
            elem.remove();
        })
        let data = await sendFormData(e.target, url);
        validate(data, e.target);
    }
}

function validate(data, form) {
    if (data.validation) {
        window.location = './home.php';
    } else {
        Object.keys(data).forEach((key)=> {
            if(key != 'validation') {
                const $div = document.querySelector(`#${form.id} input[name="${key}"]`).parentElement;
                const $errorSpan = document.createElement('span');
                $errorSpan.className = 'err-span';
                $errorSpan.textContent = data[`${key}`];
                $div.append($errorSpan);
            }
        })
    }
}

async function sendFormData(form, url) {
    let data = new FormData(form);
    let response = fetch(url, {
        method: 'POST',
        body: data,
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    });

    let result = await response;
    let json = await result.json();
    return json;
}

function deleteErrors() {
    
}


