let generatedOTP;

function sendOTP(){

let phone=document.getElementById("phone").value;

if(phone.length!==10){
alert("Enter valid mobile number");
return;
}

generatedOTP=Math.floor(1000+Math.random()*9000);

alert("OTP sent: "+generatedOTP); // simulation

document.getElementById("otpSection").style.display="block";

}

function verifyOTP(){

let userOTP=document.getElementById("otp").value;

if(userOTP==generatedOTP){

alert("Login Successful");

window.location.href="homepage.html";

}else{

alert("Invalid OTP");

}

}

function registerUser(){

let name=document.getElementById("name").value;
let email=document.getElementById("email").value;
let phone=document.getElementById("phone").value;
let password=document.getElementById("password").value;

let user={
name:name,
email:email,
phone:phone,
password:password
};

localStorage.setItem(email,JSON.stringify(user));

alert("Account created successfully");

window.location.href="login.html";

}