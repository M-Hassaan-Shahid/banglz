<x-layouts.user-default>
    <x-slot name="insertstyle">
        <style>

            .hero-section{
                padding-top: 150px;
            }
            h2 {
	text-align: center;
}

p {
	font-size: 14px;
	font-weight: 100;
	line-height: 20px;
	letter-spacing: 0.5px;
	margin: 20px 0 30px;
}

span {
	font-size: 12px;
}

a {
	color: #333;
	font-size: 14px;
	text-decoration: none;
	margin: 15px 0;
}

button {
	border-radius: 10px;
	border: 1px solid #8d5943;
	background-color: #8d5943;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
	padding: 12px 45px;
	letter-spacing: 1px;
	text-transform: uppercase;
	transition: transform 80ms ease-in;
}

button:active {
	transform: scale(0.95);
}

button:focus {
	outline: none;
}

button.ghost {
	background-color: transparent;
	border-color: #FFFFFF;
}

form {
	background-color: #FFFFFF;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	height: 100%;
	text-align: center;
    gap: 10px;
}

input {
	background-color: #eee;
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 100%;
  color: gray;

}
select{
    background-color: #eee;
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 100%;
      color: gray;

}

.container {
	background-color: #fff;
	border-radius: 10px;
  	box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
	position: relative;
	overflow: hidden;
	width: 1200px;
	max-width: 100%;
	/* min-height: 480px; */
	min-height: 550px;
}

.form-container {
	position: absolute;
	top: 0;
	height: 100%;
	transition: all 0.6s ease-in-out;
    margin-top: 0px
}

.sign-in-container {
	left: 0;
	width: 50%;
	z-index: 2;
}
.sign-in-container a{
    cursor: pointer;
}

.login-container.right-panel-active .sign-in-container {
	transform: translateX(100%);
}

.sign-up-container {
	left: 0;
	width: 50%;
	opacity: 0;
	z-index: 1;
}
.sign-up-container button:hover{
    background: black;
    color: white;
}
.sign-in-container button:hover{
    background: black;
    color: white;
}
.login-container.right-panel-active .sign-up-container {
	transform: translateX(100%);
	opacity: 1;
	z-index: 5;
	animation: show 0.6s;
}

@keyframes show {
	0%, 49.99% {
		opacity: 0;
		z-index: 1;
	}

	50%, 100% {
		opacity: 1;
		z-index: 5;
	}
}

.overlay-container {
	position: absolute;
	top: 0;
	left: 50%;
	width: 50%;
	height: 100%;
	overflow: hidden;
	transition: transform 0.6s ease-in-out;
	z-index: 100;
}

.login-container.right-panel-active .overlay-container{
	transform: translateX(-100%);
}

.overlay {
	background: #8d5943;
	background: -webkit-linear-gradient(to right, #b8775b, #bb7557);
	background: linear-gradient(to right, #b8775b, #bb7557);
	background-repeat: no-repeat;
	background-size: cover;
	background-position: 0 0;
	color: #FFFFFF;
	position: relative;
	left: -100%;
	height: 100%;
	width: 200%;
  	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.login-container.right-panel-active .overlay {
  	transform: translateX(50%);
}

.overlay-panel {
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 40px;
	text-align: center;
	top: 0;
	height: 100%;
	width: 50%;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.overlay-left {
	transform: translateX(-20%);
}

.login-container.right-panel-active .overlay-left {
	transform: translateX(0);
}

.overlay-right {
	right: 0;
	transform: translateX(0);
}

.login-container.right-panel-active .overlay-right {
	transform: translateX(20%);
}

.social-container {
	margin: 20px 0;
}

.social-container a {
	border: 1px solid #DDDDDD;
	border-radius: 50%;
	display: inline-flex;
	justify-content: center;
	align-items: center;
	margin: 0 5px;
	height: 40px;
	width: 40px;
}

.password-modal-head{
    border: none !important;
    display: flex;
    flex-direction: column;
}
.password-modal-head p{
    margin: 0px;
}
.password-modal-body .form-group{
    width: 90%;
}
.password-modal-footer{
    border: none !important;
}
.password-modal-footer .cancel-btn{
    background: white;
    border: 1px solid #8d5943;
    color: #8d5943
}
.password-modal-footer .cancel-btn:hover{
    background: #8d5943;
    color: white;
    border: none;

}
        </style>
    </x-slot>
    <x-slot name="content">
        <div class="hero-section">
            <div class="container login-container" id="container">
                <div class="form-container sign-up-container">
                  <form method="POST" id="signupForm">
    @csrf
    <h1>Create Account</h1>

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="first_name" placeholder="First Name" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" />
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" />
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <input type="text" name="address" placeholder="Address" />
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <select id="country_select" name="country">
                    <option selected disabled>Select Country</option>
                    <option value="AF">Afghanistan</option>
                    <option value="AX">Åland Islands</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" />
            </div>
        </div>
    </div>

    <button type="submit">Sign Up</button>
</form>

                </div>
                <div class="form-container sign-in-container">
                 <form method="POST" id="signinForm">
    @csrf
    <h1>Sign in</h1>

    <!-- Error message container -->
    <div id="signinError" style="display: none;" class="alert alert-danger"></div>

    <input type="email" name="email" placeholder="Email" />
    <span class="text-danger" id="emailError"></span>

    <input type="password" name="password" placeholder="Password" />
    <span class="text-danger" id="passwordError"></span>


    <a data-bs-toggle="modal" data-bs-target="#forgetPasswordModal">Forgot your password?</a>
    <button type="submit" class="sign-in-btn">Sign In</button>
</form>

                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Welcome Back!</h1>
                            <p>To keep connected with us please login with your personal info</p>
                            <button class="ghost" id="signIn">Sign In</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Hello, Friend!</h1>
                            <p>Enter your personal details and start journey with us</p>
                            <button class="ghost" id="signUp">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>

<!-- Modal -->
<div class="modal fade" id="forgetPasswordModal" tabindex="-1" aria-labelledby="forgetPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header password-modal-head">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Forget Password</h1>
        <p>Please enter your email to recieve the password</p>
      </div>
      <div class="modal-body password-modal-body">
        <form action="">
            <div class="form-group">
                <input type="email" name="mail" placeholder="Email">
            </div>
        </form>
      </div>
      <div class="modal-footer password-modal-footer">
        <button type="button" class="btn cancel-btn " data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn ">Send</button>
      </div>
    </div>
  </div>
</div>


        </div>
    </x-slot>
    <x-slot name="insertjavascript">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signupForm");

    form.addEventListener("submit", async function(e) {
        e.preventDefault();

        // remove old errors
        form.querySelectorAll(".error-message").forEach(el => el.remove());

        let formData = new FormData(form);

        try {
            let response = await fetch("{{ route('signup.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            if (response.status === 422) {
                let data = await response.json();
                let errors = data.errors;

                for (let key in errors) {
                    let input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        let errorEl = document.createElement("div");
                        errorEl.classList.add("error-message", "text-danger");
                        errorEl.textContent = errors[key][0];
                        input.parentNode.appendChild(errorEl); // place error under input
                    }
                }
            } else {
                let data = await response.json();
             if (data.success) {
    Swal.fire({
        title: 'Success!',
        text: data.message,
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload();
        }
    });

    form.reset();
}
            }
        } catch (err) {
            console.error("Error:", err);
        }
    });
});


$(document).ready(function () {
    $("#signinForm").on("submit", function (e) {
        e.preventDefault();

        // clear old errors
        $("#signinError").hide().empty();
        $("#emailError").text('');
        $("#passwordError").text('');

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: "{{ route('signin') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                     Swal.fire({
        title: 'Success!',
        text: response.message,
        icon: 'success',
        showConfirmButton: false,
            timer: 1500
            });
             setTimeout(function () {
                window.location.href = "{{ route('home') }}";
            }, 1500);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;

                    if (errors.email) {
                        $("#emailError").text(errors.email[0]);
                    }
                    if (errors.password) {
                        $("#passwordError").text(errors.password[0]);
                    }
                } else if (xhr.status === 401) {
                    console.log(xhr.responseJSON.message);
                    $("#signinError").text(xhr.responseJSON.message).show();
                }
            }
        });
    });
});



</script>

    </x-slot>
</x-layouts.user-default>

</html>
