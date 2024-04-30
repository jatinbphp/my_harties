<!DOCTYPE html>
<html lang="{{$data['language']}}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>New Inquiry</title>
</head>
<body>
<div style="line-height:inherit;margin:0;background-color:#f5f5f5">
    <table cellpadding="0" cellspacing="0" role="presentation" width="100%" bgcolor="#f5f5f5" valign="top" style="line-height:inherit;table-layout:fixed;vertical-align:top;border-spacing:0;border-collapse:collapse;background-color:#f5f5f5;width:100%;text-align: center;">
        <tbody style="line-height:inherit">
        <tr valign="top">
            <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;text-align: center;padding: 60px 60px 0;">
                My Harties
            </td>
        </tr>
        <tr valign="top">
            <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;text-align: center;padding:30px 0 60px;">
                <table cellpadding="0" cellspacing="0" role="presentation" width="100%" bgcolor="#FFFFFF" valign="top" style="line-height:inherit;table-layout:fixed;vertical-align:top;min-width:320px;max-width: 612px;border-spacing:0;border-collapse:collapse;background-color:#ffffff;width:100%;margin: 0 auto;">
                    <tbody style="line-height:inherit">
                    <tr valign="top" style="line-height:inherit;border-collapse:collapse;vertical-align:top">
                        <td valign="top" style="line-height:inherit;border-collapse:collapse;word-break:break-word;vertical-align:top;font-family: 'Poppins',Arial,sans-serif;font-style: normal;font-weight: 400;font-size: 16px;line-height: 26px;color: #495057;padding: 50px 60px;text-align: left;">
                            <h4 style="margin:0 0 15px;">Hello, </h4>
                            <p style="margin:0 0 15px;">New Inquiry </p>
                            <p style="margin:0 0 15px;"><strong>Name:</strong> {{$data['name']}}</p>
                            <p style="margin:0 0 15px;"><strong>Contact Number:</strong> {{$data['contact_number']}}</p>
                            <p style="margin:0 0 15px;"><strong>Email Address:</strong> {{$data['email']}}</p>
                            <p style="margin:0 0 15px;"><strong>Message:</strong> {{$data['message']}}</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
