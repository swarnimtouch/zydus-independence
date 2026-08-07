<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>

    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('{{ asset('fonts/Poppins-Bold.ttf') }}') format('truetype');
            font-weight: bold;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f5f5f5;
            font-family:'Poppins',sans-serif;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            padding:20px;
        }

        .certificate{
            position:relative;
            width:1123px;
            height:794px;
            box-shadow:0 5px 20px rgba(0,0,0,.15);
        }

        .certificate img{
            width:100%;
            height:100%;
            display:block;
        }

        .user-name{
            position:absolute;
            left:500px;      /* X Position */
            top:500px;       /* Y Position */
            transform:translate(-50%,-50%);
            font-family:'Poppins',sans-serif;
            font-size:40px;
            font-weight:bold;
            color:#000;
            white-space:nowrap;
        }

        .buttons{
            margin-top:25px;
            display:flex;
            gap:20px;
        }

        .btn{
            padding:12px 30px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            text-decoration:none;
            font-size:16px;
            font-weight:bold;
            color:#fff;
            transition:.3s;
        }

        .home{
            background:#198754;
        }

        .home:hover{
            background:#146c43;
        }

        .download{
            background:#0d6efd;
        }

        .download:hover{
            background:#0b5ed7;
        }
    </style>
</head>
<body>

<div id="certificate" class="certificate">
    <img src="{{ asset('images/certificate.jpg') }}" alt="Certificate">


</div>

<div class="buttons">
    <a href="{{ route('form.create') }}" class="btn home">
        Go To Home
    </a>

    <button class="btn download" onclick="downloadCertificate()">
        Download Certificate
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<script>
    function downloadCertificate() {

        html2canvas(document.getElementById('certificate'),{
            scale:2,
            useCORS:true
        }).then(function(canvas){

            const link=document.createElement('a');
            link.download='certificate.png';
            link.href=canvas.toDataURL('image/png');
            link.click();

        });

    }
</script>

</body>
</html>
