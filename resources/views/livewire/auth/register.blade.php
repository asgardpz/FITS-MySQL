<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>FITS - Register</title>

<style>
    * { margin:0; padding:0; box-sizing:border-box; }

    body {
        font-family:"Microsoft JhengHei";
        background: url('{{ asset("assets/images/Back.png") }}') no-repeat center center fixed;
        background-size: cover;
        display:flex; justify-content:center; align-items:center;
        height:100vh;
    }

    .register-panel {
        width: clamp(280px, 80vw, 420px);
        border: 3px solid #42d9ff;
        border-radius: 8px;
        background: linear-gradient(180deg, rgba(20,55,120,.95), rgba(30,55,110,.95));
        box-shadow: 0 0 20px rgba(0,255,255,.4);
        padding: clamp(15px, 5vw, 30px);
        text-align: center;
    }

    .register-title-cn {
        font-size: clamp(20px, 5vw, 34px);
        font-weight: bold;
        color: #ffffff;
        margin-bottom: 10px;
    }

    .register-title-en {
        font-size: clamp(16px, 4vw, 24px);
        font-weight: bold;
        color: #9ee7ff;
        margin-bottom: 25px;
    }

    .logo img {
        height: clamp(40px, 10vw, 60px);
        margin-bottom: 20px;
    }

    .field {
        margin-bottom: 20px;
        text-align: left;
    }
    .field label {
        display:block;
        font-size: clamp(14px, 3.5vw, 18px);
        color:#ffffff;
        margin-bottom:8px;
    }
    .field input {
        width:100%;
        padding: clamp(8px, 2vw, 12px);
        font-size: clamp(14px, 3.5vw, 16px);
        border:2px solid #42d9ff;
        border-radius:6px;
        background-color:#0f2c66;
        color:#ffffff;
    }
    .field input:focus {
        outline:none;
        border-color:#7cff00;
        box-shadow:0 0 10px rgba(124,255,0,.6);
    }

    .error {
        color:#ff6666;
        font-size: clamp(12px, 3vw, 14px);
        margin-top:5px;
    }

    .register-btn {
        width:100%;
        padding: clamp(10px, 3vw, 14px);
        font-size: clamp(16px, 4vw, 20px);
        font-weight:bold;
        color:#0f2c66;
        background: linear-gradient(90deg,#42d9ff,#9ee7ff,#42d9ff);
        border:none;
        border-radius:6px;
        cursor:pointer;
        transition: all .3s;
    }
    .register-btn:hover {
        background: linear-gradient(90deg,#7cff00,#baff66,#7cff00);
        color:#ffffff;
    }

    .login-link {
        margin-top:20px;
        color:#ffffff;
        font-size: clamp(12px, 3vw, 16px);
    }
    .login-link a {
        color:#42d9ff;
        text-decoration:none;
        font-weight:bold;
    }
    .login-link a:hover { color:#7cff00; }
</style>
</head>

<body>
    <div class="register-panel">
        <div class="logo" style="display:flex; justify-content:center; align-items:center; gap:20px;">
            <a href="https://www.ibase.com.tw/"><img src="{{ asset('assets/images/ibase-logo.svg') }}" style="transform:scale(0.8); display:block; margin:auto;"></a>
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/FITS.png') }}" alt="FITS Logo" style="width:100%; height:auto;">
            </a>
        </div>

        <div class="register-title-cn">智能工廠管理系統</div>
        <div class="register-title-en">Sign Up</div>

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <!-- Name -->
            <div class="field">
                <label for="name">Name<span class="asterisk">*</span></label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Terry Lin" required autofocus autocomplete="name" />
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div class="field">
                <label for="email">Email address<span class="asterisk">*</span></label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="email@example.com" required autocomplete="email" />
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div class="field">
                <label for="password">Password<span class="asterisk">*</span></label>
                <input id="password" name="password" type="password" placeholder="Please input your password" required autocomplete="new-password" />
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="field">
                <label for="password_confirmation">Confirm Password<span class="asterisk">*</span></label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Please input your password again" required autocomplete="new-password" />
                @error('password_confirmation') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="register-btn">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account?
            <a href="{{ route('login') }}">Log In</a>
        </div>
    </div>
</body>
</html>
