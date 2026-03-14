<!DOCTYPE html>
<html>
<head><title>Redirecting...</title></head>
<body>
    <p>Redirecting to Scouts Digital...</p>
    <form id="sd-login" method="POST" action="{{ $url }}">
        <input type="hidden" name="username" value="{{ $username }}">
        <input type="hidden" name="password" value="{{ $password }}">
        <input type="hidden" name="agree" value="1">
    </form>
    <script>document.getElementById('sd-login').submit();</script>
</body>
</html>
