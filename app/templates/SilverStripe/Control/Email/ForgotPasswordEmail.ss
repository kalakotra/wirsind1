<p><%t SilverStripe\\Control\\Email\\ForgotPasswordEmail_ss.HELLO 'Hi' %> $FirstName,</p>

<p><%t SilverStripe\\Control\\Email\\ForgotPasswordEmail_ss.TEXT1 'hier ist dein Link zum Zurücksetzen des Passworts für www.wirsind1.at:' %>
<br /><a href="$PasswordResetLink">{$AbsoluteBaseURL}$PasswordResetLink</a>
</p>

<p>
    <%t SilverStripe\\Control\\Email\\ForgotPasswordEmail_ss.TEXT2 'Liebe Grüße vom' %>
    <br />
    <%t SilverStripe\\Control\\Email\\ForgotPasswordEmail_ss.TEXT3 'Team Wir sind 1' %>
</p>

