<!DOCTYPE html>
<html>
<head>
    <title>Bukti Evaluasi Konseling</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; color: #000; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 16pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 11pt; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 20px; font-size: 14pt; }
        .content { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table td { padding: 4px; vertical-align: top; }
        .label { width: 180px; font-weight: bold; }
        .colon { width: 10px; }
        .answer-box { border: 1px solid #000; padding: 10px; margin-bottom: 15px; min-height: 50px; background-color: #fafafa; }
        .question { font-weight: bold; margin-bottom: 5px; display: block; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="header">
        <h1>UNIVERSITAS BINA BANGSA GETSEMPENA</h1>
        <p>UNIT PELAKSANA TEKNIS BIMBINGAN KONSELING</p>
        <p>Jalan Tanggul Krueng Lamnyong No. 34 Rukoh Darussalam, Banda Aceh</p>
    </div>

    <div class="title">FORM EVALUASI LAYANAN BIMBINGAN KONSELING</div>

    <div class="content">
        <table class="table">
            <tr>
                <td class="label">Nama Mahasiswa</td>
                <td class="colon">:</td>
                <td>{{ $mahasiswa->user->name }}</td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td class="colon">:</td>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td class="colon">:</td>
                <td>{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Konseling</td>
                <td class="colon">:</td>
                <td>{{ \Carbon\Carbon::parse($konseling->tgl_pengajuan)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">No. Dokumen</td>
                <td class="colon">:</td>
                <td>BK-{{ $konseling->id_konseling }}/{{ date('Y') }}</td>
            </tr>
        </table>

        <hr style="border: 0.5px solid #ccc; margin: 20px 0;">

        <div class="question">1. Pengetahuan / pemahaman baru apa yang anda peroleh setelah mengikuti layanan bimbingan konseling?</div>
        <div class="answer-box">
            {{ $survei->pemahaman_baru }}
        </div>

        <div class="question">2. Bagaimana perasaan anda setelah mengikuti layanan bimbingan konseling?</div>
        <div class="answer-box">
            {{ $survei->perasaan }}
        </div>

        <div class="question">3. Jelaskan tindakan yang akan anda lakukan setelah mengikuti layanan bimbingan konseling?</div>
        <div class="answer-box">
            {{ $survei->tindakan }}
        </div>

        <div class="question">4. Jelaskan tanggung jawab anda setelah mengikuti layanan bimbingan konseling?</div>
        <div class="answer-box">
            {{ $survei->tanggung_jawab }}
        </div>
    </div>

    <div class="footer">
        <p>Banda Aceh, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Mahasiswa,</p>
        <br><br>
        <p class="signature">{{ $mahasiswa->user->name }}</p>
        <p>NIM. {{ $mahasiswa->nim }}</p>
    </div>

</body>
</html>