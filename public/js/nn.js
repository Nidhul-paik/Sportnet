
document.addEventListener("DOMContentLoaded", function() {


    console.log('hi');
    // Password and Confirm Password Check
    const password = document.getElementById("password");
    const cpassword = document.getElementById("cpassword");
    const message = document.getElementById("password_match");

    if (password && cpassword && message) {
        function checkPasswordMatch() {
            const pass = password.value;
            const cpass = cpassword.value;
            if (pass === cpass && pass !== "" && cpass !== "") {
                message.textContent = '';
            } else {
                message.textContent = 'password and confirm password do not match';
            }
        }

        password.addEventListener("input", checkPasswordMatch);
        cpassword.addEventListener("input", checkPasswordMatch);
    }

    // OTP Inputs Handling
    const otpInputs = document.querySelectorAll('input[name^="otp"]');
    if (otpInputs.length > 0) {
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (event) => {
                if (event.key === "Backspace" && input.value.length === 0 && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

    }



 // --------------eye button--------------------//
    
 
    // Eye button for password field
    let eye = document.getElementById('eye-icon');
    let eye2 = document.getElementById('eye-icon2');
    let passField = document.getElementById('password');
    let passField2 = document.getElementById('password2');

    eye.addEventListener('click', () => {
        let passFieldType = passField.getAttribute('type');
        if (passFieldType === 'password') {
            passField.setAttribute('type', 'text');
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            passField.setAttribute('type', 'password');
            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');
        }
    });

    eye2.addEventListener('click', () => {
        let passFieldType = passField2.getAttribute('type');
        if (passFieldType === 'password') {
            passField2.setAttribute('type', 'text');
            eye2.classList.remove('fa-eye');
            eye2.classList.add('fa-eye-slash');
        } else {
            passField2.setAttribute('type', 'password');
            eye2.classList.remove('fa-eye-slash');
            eye2.classList.add('fa-eye');
        }
    });


    // account
    
//     let con = document.getElementById('profile');
//   let ac = document.getElementById('account');
//   let tg = document.getElementById('toggler');
//   let main = document.getElementById('main');

//   con.addEventListener('click',()=>{
//     console.log('hiii');
   
//     ac.style.right='0px';
    
//   });

//   tg.addEventListener('click',()=>{
//     console.log('hiii');
   
//     ac.style.right='-600px';
    
//   });

//   main.addEventListener('click',()=>{
//     console.log('hiii');
   
//     ac.style.right='-600px';
    
//   });

});

