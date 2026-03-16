function registerUser(){

let username=document.getElementById("username").value;
let email=document.getElementById("email").value;
let password=document.getElementById("password").value;

if(username==="" || email==="" || password===""){
alert("Please fill all fields");
return;
}

let user={
username:username,
email:email,
password:password
};

localStorage.setItem(email,JSON.stringify(user));

alert("Registration successful!");

window.location.href="login.html";
}

function loginUser(){

let email=document.getElementById("loginEmail").value;
let password=document.getElementById("loginPassword").value;

let user=JSON.parse(localStorage.getItem(email));

if(user && user.password===password){

alert("Welcome "+user.username);

window.location.href="homepage.html";

}else{

alert("Invalid email or password");

}
}