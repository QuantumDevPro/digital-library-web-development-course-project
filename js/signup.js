// عناصر ال html 
const nameinput = document.querySelector("#name");
const emailI = document.querySelector("#email");
const password = document.querySelector("#password");
const passwordStrength = document.querySelector("#password-strength");
const signupForm= document.getElementById("signupForm");

//دالة تعرض رسالة الايرورر 
function ErrorMassge(input, message) {
    const errorMsg = input.parentNode.querySelector(".error");
    errorMsg.textContent = message;
    errorMsg.style.color = "#d32f2f";
}

// التحقق من اسم المستخدم 
function validateName() {
    const nameValue = nameinput.value.trim();
    // هنا لازم بداية الاسم تكون حرف مو ارقام ولا شرطات 
    const nameRegex = /^[A-Za-z][A-Za-z0-9-]*$/; 
    // لو ترك خانة الاسم فاضيه 
    if (nameValue === "") {
       ErrorMassge(nameinput, "Name is required");
        return false;
    }

    // الاسم لازم يبدأ بحرف 
   else if (!nameRegex.test(nameValue)) {
        ErrorMassge(nameinput, "Name must start with a letter ");
        return false;
    }
    // الاسم لازم ما يكون اقل من 6 حروف 
     else if (nameValue.length < 6) {
        ErrorMassge(nameinput, "Name must be at least 6 characters");
        return false;
    }
    else {

          nameinput.parentNode.querySelector(".error").textContent = "";
    return true;
    }
}

    // التحقق من الايميل 

   
    // Using regular expressions in form validation
 function validateEmail(){

    const emailValue = document.getElementById("email").value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
 
     // لو ترك خانة الايميل فاضيه 
       if (emailValue===""){
        ErrorMassge(emailI,"Email is required");
            return false;
      }
     // لو طريقة كتابة الايميل غلط 
   else if (!emailRegex.test(emailValue)) {
           ErrorMassge(emailI,"Please enter a valid email address");
            return false;
            }
      // غير كذا ما حيكون فيه رسالة خطأ
      else {
        emailI.parentNode.querySelector(".error").textContent = "";
    return true;
      }
    }

          // التحقق من الباسوورد
function validatePassword() {
 const passwordValue = password.value.trim();

// هنا لو ترك خانة الباسوورد فاضيه 
 if (passwordValue === "") {
         ErrorMassge(password, "Password is required");
        return false;
    }
  // لو كان الباسورد قصير اقل من 8 
    else if (passwordValue.length < 8) {
        ErrorMassge(password, "Password must be at least 8 characters");
        return false;
    }

    else {
     password.parentNode.querySelector(".error").textContent = "";
    return true;
    }

}


// د التحقق من قوة الباسوورد
function checkPasswordStrength(password) {
    let strength = 0;

    const patterns = [
        /[a-z]/,          // حروف صغيرة
        /[A-Z]/,          // حروف كبيرة
        /[0-9]/,          // أرقام
        /[^A-Za-z0-9]/    // رموز
    ];

    // نختبر الباسورد باستخدام الفور لوب
    for (let i = 0; i < patterns.length; i++) {
        if (patterns[i].test(password)) {
            strength++;
        }
    }

    //تزيد القوه برضو لو كان اطول من 10 ل
    if (password.length >= 10) {
        strength++;
    }
    // هنا لو كان فاضي ما دخل شيء فما لازم تظهر عندي انه ضعيف 
    if (password.length === 0) {
        passwordStrength.textContent = "";
        return;
    }

    if (strength <= 2) {
        passwordStrength.textContent = "Weak Password";
        passwordStrength.style.color = "red";
    } 
    else if (strength === 3 || strength === 4 ) {
        passwordStrength.textContent = "Medium Password";
        passwordStrength.style.color = "orange";
    } 
    else {
        passwordStrength.textContent = "Strong Password";
        passwordStrength.style.color = "green";
    }
}

// التحقق من مدخلات المستخدم وهو يكتب 
nameinput.addEventListener("input", validateName);
emailI.addEventListener("input", validateEmail);
password.addEventListener("input", function () {
    checkPasswordStrength(password.value.trim());
});


// يمنع ارسال النموذج لو فيه اغلاط 
signupForm.addEventListener("submit", function (event) {
    event.preventDefault();

     let isValid = true; 

     if (!validateName()) {
        nameinput.focus();
       isValid = false;
    }

    if (!validateEmail()) {
         emailI.focus(); // يعرض لي مربع الايميل لو كان غلط, كشكل بس يعني 
        isValid = false;
    }

    if (!validatePassword()) {
        password.focus(); // نفس فكرة مربع الايميل 
        isValid = false;
    }

    //  اذا ما فيه ولا غلط يتسلم الفورم و تطلع الرساله 
    if (isValid) {
        alert("Account created successfully");
        signupForm.reset();
         passwordStrength.textContent = ""; 
    }
});
