// عناصر ال html 
const emailI = document.querySelector("#email");
const password = document.querySelector("#password");
const loginForm = document.getElementById("loginForm");

//دالة تعرض رسالة الايرورر 
function ErrorMassge(input, message) {
    const errorMsg = input.parentNode.querySelector(".error");
    errorMsg.textContent = message;
    errorMsg.style.color = "#d32f2f";
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
     // لو ترك خانة الباسورد فاضية 
 if (passwordValue === "") {
         ErrorMassge(password, "Password is required");
        return false;
    }
     // لو كان الباسوورد قصير اقل من 8 حروف 
    else if (passwordValue.length < 8) {
        ErrorMassge(password, "Password must be at least 8 characters");
        return false;
    }

    else {
     password.parentNode.querySelector(".error").textContent = "";
    return true;
    }

}

// التحقق من مدخلات المستخدم وهو يكتب 
emailI.addEventListener("input", validateEmail);
password.addEventListener("input", validatePassword);


// يمنع ارسال النموذج لو فيه اغلاط 
loginForm.addEventListener("submit", function (event) {
    event.preventDefault();

    let isValid = true;   

    
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
        alert("Login successful!");
        loginForm.reset();
    }
});