<span style="display: none !important; font-size: 1px;">Invitation</span>
<center style="width:100%; background: white; color: #555;">
    <div class="email-wrapper" style="max-width:600px; margin:auto">
     

        <table class="email-body" cellspacing="0" cellpadding="0"
               border="0"
               align="center" width="100%"
               style="border-spacing:0;border-collapse:collapse;max-width:600px;margin:0 auto"
               bgcolor="#ffffff">
            <tbody>
            <tr>
                <td>
                    <table border="0" cellpadding="30" cellspacing="0" width="100%"
                           style="border-spacing:0;border-collapse:collapse;margin:0 auto">
                        <tbody>
                        <tr>
                            <td valign="top"
                                style="font-family:'Helvetica Neue', sans-serif;color:#444;font-size:14px;line-height:150%">
                                <p style="font-size:14px;color:#222222;">
                                    Hi there!
                                </p>
                                <p style="margin-top:15px;margin-bottom:15px;font-size:14px;color:#222222; line-height: 2;">
                                    You have been invited by <span style="font-weight: bold;"> Admin</span> to join the organization:&nbsp;
                                    <span style="font-weight: bold;">Laravel Assesment</span>.&nbsp;
                                    You can have access to this organization, once you accept the invite.
                                    <br/>
                                    <span style="color:#222222;">We hope you enjoy eTrack!</span>
                                </p>

                                <p style="text-align: center;">
                                    <a href="https://127.0.0.1:8000/invitations/{{$invitation->token}}" target="_blank"
                                       data-saferedirecturl="https://www.google.com/url?q={etrack.url.website}/invitations/{inviteCode}"
                                       style="border:1px solid #18a749; text-decoration:none; color: #fff;font-size:14px; padding: 10px 20px; background: #18a749; border-radius: 3px; display: block; margin: 30px auto; width: 120px; text-align: center; cursor: pointer; font-weight: bold;">
                                        Accept Invitation
                                    </a>
                                </p>

                                <p style="text-align: center; margin-bottom: 30px;">
                                    <span style="margin-bottom: 10px;">OR</span>
                                    <br/>
                                    <span>Follow the link: <a href="https://127.0.0.1:8000/invitations/{{$invitation->token}}"
                                                              style="text-decoration: underline; cursor: pointer; color: #18a749;">https://127.0.0.1:8000/invitations/{{$invitation->token}}</a></span>
                                </p>
                                <p style="margin-top:15px;margin-bottom:15px;font-size:14px;color:#222222">
                                    If you need additional assistance, please visit our&nbsp;
                                    <a href="help_center" style="text-decoration: underline; cursor: pointer; color: #18a749; font-weight: bold;">Help Center</a>
                                    <br/>
                                    Cheers,
                                    <br/>
                                    The  Team
                                </p>


                                <hr style="border: none; border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</center>
