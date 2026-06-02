
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outcome Based Education</title>
</head>
<div>
    <div style="text-align:center;width:800px !important;margin: auto auto 30px auto;">
        <img style="text-align:center;width:80px !important;height: 100px;" src="http://obe.riphah.edu.pk/public/assets/img/riphah-logo.png" >
    </div>
    <div style="background-color:#f4f4f4;width:800px !important;margin: auto auto auto auto; height: 300px;">
        
        <div style="padding: 15px 30px 30px 30px;">
            <h1 style="color:#363636">Welcome to Outcome Based Education, Click continue to validate your account.</h1>
            <p style="margin-bottom: 10px;color:#363636">We received a request to register with this email address.  simply click the link below. It will take you to a web page where you can validate your account.</p>
            <p style="color:#363636"><strong>Email : </strong>{{ $mailData['email'] }}</p>
            <p style="margin-bottom: 20px;color:#363636"><strong>Password : </strong>{{ $mailData['password'] }}</p>
            <a href="https://obe.riphah.edu.pk/" style="padding: 10px 20px 10px 20px; background-color:#294e73;color: white;text-decoration: auto;">Continue</a>
        </div>
    </div>
</body>
</html>
