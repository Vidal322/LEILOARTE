<h3>Hi {{ $mailData['name'] }},</h3>

<p>We received a request to reset your password. If you didn't make the request, just ignore this email. Otherwise, you can reset your password using this link:</p>

<p><a href="{{ url('resetPassword', $mailData['token']) }}">Click here to reset your password</a></p>

<p>If you're unable to click the link, copy and paste the URL below into your web browser:</p>

<p>{{ url('resetPassword', $mailData['token']) }}</p>

<p>Thanks,</p>
<p>The LeiloArte Team</p>