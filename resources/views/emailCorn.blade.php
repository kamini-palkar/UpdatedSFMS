<!DOCTYPE html>
<html>

<head>

</head>

<body>

    <p>Hello,</p>
    <p>Following list of documents were transferred {{$time}} <b> {{ $body }}</b></p>
    @php
    function convertToBytes($size, $unit)
    {
        switch ($unit) {
            case 'KB':
                return $size * 1024;
            case 'MB':
                return $size * 1024 * 1024;
            case 'GB':
                return $size * 1024 * 1024 * 1024;
            // Add more cases for other units if needed
            default:
                return $size;
        }
    }

    function convertToBytesWithSingleUnit($sizeInBytes)
    {
        $resultUnit = 'B';

        if ($sizeInBytes >= 1024) {
            $sizeInBytes /= 1024;
            $resultUnit = 'KB';
        }
        if ($sizeInBytes >= 1024) {
            $sizeInBytes /= 1024;
            $resultUnit = 'MB';
        }
        if ($sizeInBytes >= 1024) {
            $sizeInBytes /= 1024;
            $resultUnit = 'GB';
        }

        return number_format($sizeInBytes, 2) . ' ' . $resultUnit;
    }
@endphp

@foreach($names as $orgDetails)
    @php    
        $orgName = $orgDetails['name'];
        $filesdata = $orgDetails['files'];
        $nooffiles = 0;
        $totalSizeInBytes = 0;
        
    @endphp
    @foreach($filesdata as $key => $filesvalue)
        @php
            $nooffiles++;
             
            $totalSizeInBytes += $filesvalue->size_in_bytes;

        @endphp
    @endforeach

    @php 
        $totalSizeWithUnit = convertToBytesWithSingleUnit($totalSizeInBytes);
    @endphp
  
        <span style="font-weight: bold;"> | {{ $orgName }} | {{ $nooffiles }} Files | {{ $totalSizeWithUnit }} </span><br>
        @if($nooffiles== 0)
            <span> <b >No files Uploaded </b></span><br><br>
        
        @else
    
            <table border="1" style="border-collapse: collapse; width: 80%;">
            <tr>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">SR NO</th>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">File Name</th>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Uploaded By</th>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Uploaded On</th>
                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px; width: auto;">Size</th>
            </tr>

            @foreach($filesdata as $key => $filesvalue)          
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
        @endif
            
    @endforeach
    <span>Thank you.</span><br>
    <span>This is system generated email.<br>
    <b>Secure File Management System</b></span>

</body>

</html>
