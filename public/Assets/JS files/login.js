const form = document.getElementById("form");
const button = document.getElementById("login");
const gmail = document.getElementById("user");
const pass = document.getElementById("pass");

const isValidEmail = email => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-z]{2,}))$/.test(String(email).toLowerCase());

const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector(".error");
    errorDisplay.innerText = message;
    inputControl.classList.add("error");
    inputControl.classList.remove("success");
}

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector(".error");
    errorDisplay.innerText = "";
    inputControl.classList.add("success");
    inputControl.classList.remove("error");
}

const validateInputs = () => {
    const gmailValue = gmail.value.trim();
    const passwordValue = pass.value.trim();

    if (gmailValue.length === 0) {
        setError(gmail, 'البريد الالكتروني مطلوب');
    } else if (!isValidEmail(gmailValue)) {
        setError(gmail, 'البريد الالكتروني غير صحيح');
    } else {
        setSuccess(gmail);
    }

    if (passwordValue.length === 0) {
        setError(pass, 'الباسورد مطلوب');
    } else if (passwordValue.length < 8) {
        setError(pass, "الحد الأدنى 8 أحرف أو أرقام");
    } else {
        setSuccess(pass);
    }

    button.disabled = !(
        gmail.parentElement.classList.contains("success") &&
        pass.parentElement.classList.contains("success")
    );
}

const submitForm = () => form.submit();

gmail.addEventListener("input", validateInputs);
pass.addEventListener("input", validateInputs);

button.addEventListener("click", event => {
    if (!button.disabled) {
        event.preventDefault();
        submitForm();
    }
});
