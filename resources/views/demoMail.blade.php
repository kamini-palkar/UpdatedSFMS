<!DOCTYPE html>
<html>

<head>

</head>

<body>

    <p>Hello,</p>
    <p>{{ $body }}</p>

    <table border="1" style="border-collapse: collapse; width: 80%;">
        <tr>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Sr No</th>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Unique Id</th>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Project</th>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">File Name</th>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Purpose</th>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Uploaded By</th>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Size</th>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Uploaded On</th>
        </tr>
        @foreach($names as $key => $file)
        <tr>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $key + 1 }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $file->unique_id }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $file->project }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $file->name }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $file->purpose }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $file->added_by }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $file->size }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">
    {{ \Carbon\Carbon::parse($file->created_at)->format('Y-m-d h:i A') }}
</td>
        </tr>
        @endforeach
    </table>
    <p>Thank you.</p>
    <span>Regards,</span><br>
    <span>{{ $regardsName }}</span><br>

</body>

</html>
