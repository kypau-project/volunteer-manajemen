<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Penghargaan</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .certificate {
            width: 297mm; /* A4 Landscape width */
            height: 210mm; /* A4 Landscape height */
            margin: 0;
            padding: 50px;
            box-sizing: border-box;
            background: url('https://placehold.co/1122x793.png?text=Template+Sertifikat+Digital') no-repeat center center;
            background-size: cover;
            text-align: center;
            position: relative;
        }
        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
        }
        h1 {
            font-size: 48pt;
            margin-bottom: 20px;
            color: #333;
        }
        h2 {
            font-size: 24pt;
            margin-bottom: 10px;
            color: #555;
        }
        p {
            font-size: 14pt;
            margin-bottom: 5px;
            color: #666;
        }
        .name {
            font-size: 36pt;
            font-weight: bold;
            color: #000;
            margin: 30px 0;
            border-bottom: 3px solid #000;
            display: inline-block;
        }
        .event-title {
            font-size: 20pt;
            font-style: italic;
            margin-top: 20px;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
        }
        .signature div {
            width: 40%;
            text-align: center;
        }
        .number {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 10pt;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="content">
            <h2>SERTIFIKAT PENGHARGAAN</h2>
            <p>Diberikan kepada:</p>
            <div class="name">{{ $name }}</div>
            <p>Atas partisipasi aktif sebagai relawan dalam acara:</p>
            <div class="event-title">{{ $eventTitle }}</div>
            <p>Dengan total kontribusi waktu selama **{{ $hours }} jam**.</p>
            
            <div class="signature">
                <div>
                    <p>Dikeluarkan pada: {{ $issueDate }}</p>
                    <br><br>
                    <p>_________________________</p>
                    <p>Koordinator Program</p>
                </div>
            </div>
        </div>
        <div class="number">
            No. Sertifikat: {{ $certificateNumber }}
        </div>
    </div>
</body>
</html>

