<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      margin: auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-top: 20px;
    }
    h4 {
      color: #007bff;
    }
    p {
      font-size: 16px;
    }
    .otp-code {
      font-size: 24px;
      font-weight: bold;
      color: #28a745;
      margin-top: 10px;
      margin-bottom: 20px;
    }
    .contact-info {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h4>Your One-Time Password (OTP) for Secure Access</h4>
    <p>We hope this message finds you well. As part of our commitment to ensuring the security of your account, we are implementing an additional layer of protection through the use of a One-Time Password (OTP).</p>
    <p class="otp-code">Your OTP for secure access is: {{$otp}}</p>
    <p>Please enter this code within the next [specified time limit] to complete the authentication process. If you did not request this OTP or are experiencing any issues, please contact our support team immediately at [your support email or phone number].</p>
    <div class="contact-info">
      <p>Thank you for your cooperation in maintaining the security of your account.</p>
      <p>Best regards,</p>
      <p>[Your Company Name]</p>
      <p>[Your Contact Information]</p>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
