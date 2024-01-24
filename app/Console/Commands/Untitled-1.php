<!DOCTYPE html>
<html>

<head>

</head>

<body>

    <p>Hello,</p>
    <p>{{ $body }}</p>
    @php
    function convertToBytes($size, $unit)
    {
        switch ($unit) {
            case 'KB':
                return $size * 1024;
            case 'MB':
                return $size * 1024 * 1024;
            // Add more cases for other units if needed
            default:
                return $size;
        }
    }
    
    $totalSizeInBytes = 0;
    $nooffiles=0;
    $totalSizeInBytes=0;
    @endphp

 

        @foreach($names as $Organisation)    
        @foreach($Organisation as $key => $filesvalues)
        @php
        $nooffiles++;
         list($size, $unit) = explode(' ', $filesvalue->size);
        $totalSizeInBytes += convertToBytes($size, $unit);
        @endphp
        
        @endforeach
        
        <span> | Organization Name </span><span> |{{ $nooffiles }} Files </span><span> |{{$totalSizeInBytes}}  </span>
        <table border="1" style="border-collapse: collapse; width: 80%;">
            <tr>
            <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">SR NO</th>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">File Name</th>
               
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Uploaded By</th>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Uploaded On</th>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Size</th>
            </tr>


            @foreach($filesdata as $key => $filesvalue)
            <!-- <span>{{ $filesvalue }}  </span> -->
          
            <tr>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $key + 1 }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $filesvalue->name }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $filesvalue->added_by }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $filesvalue->created_at }}</td>
            <td style="border: 1px solid #dddddd; text-align: center; padding: 8px;">{{ $filesvalue->size }}</td>
  
        </tr>

            @endforeach
            </table>
            <br>
            <br>
        @endforeach
    

    <p>Thank you.</p>
    <span>Regards,</span><br>
    <span>This is system generated email.<br>
<b>Secure File Management System</b></span><br>

</body>

</html>
