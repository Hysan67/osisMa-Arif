<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\User;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();

        $articles = [
            [
                'judul' => 'Pelantikan Pengurus OSIS 2025/2026',
                'deskripsi' => 'Pelantikan resmi pengurus OSIS periode 2025/2026 telah dilaksanakan dengan sukses di Aula Utama sekolah. Acara ini dihadiri oleh seluruh siswa, guru, dan staf sekolah sebagai bentuk dukungan terhadap kepemimpinan baru. Prosesi pelantikan dimulai dengan pembacaan sumpah jabatan oleh seluruh pengurus OSIS terpilih.

Ketua OSIS terpilih, Ahmad Rizki, dalam pidato pertamanya menyampaikan visi dan misi untuk memajukan sekolah melalui berbagai program inovatif. Ia menekankan pentingnya kolaborasi antara pengurus OSIS, siswa, dan seluruh warga sekolah. Komitmen untuk meningkatkan prestasi akademik dan non-akademik menjadi fokus utama kepemimpinan periode ini.

Acara ditutup dengan penandatanganan berita acara pelantikan oleh kepala sekolah dan ketua OSIS. Momen ini menandai dimulainya perjalanan baru pengurus OSIS dalam mengemban amanah selama satu tahun ke depan. Seluruh hadirin memberikan tepuk tangan meriah sebagai bentuk dukungan terhadap tim baru ini.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Tips Belajar Efektif untuk Ujian',
                'deskripsi' => 'Belajar efektif untuk menghadapi ujian membutuhkan perencanaan yang matang dan disiplin yang tinggi. Langkah pertama adalah membuat jadwal belajar yang realistis dengan memperhatikan prioritas materi yang akan diujikan. Pembagian waktu yang seimbang antara mata pelajaran sangat penting untuk menghindari kejenuhan dan memaksimalkan penyerapan informasi.

Selain jadwal yang teratur, pemilihan metode belajar juga menentukan keberhasilan. Metode pomodoro yang membagi waktu belajar menjadi interval 25 menit dengan istirahat 5 menit terbukti efektif meningkatkan konsentrasi. Penggunaan catatan warna-warni, mind mapping, dan flashcards dapat membantu dalam mengingat konsep-konsep penting dengan lebih mudah.

Hal terpenting yang sering dilupakan adalah menjaga kesehatan fisik dan mental selama masa ujian. Istirahat yang cukup, olahraga ringan, dan nutrisi yang baik sangat berpengaruh pada performa belajar. Belajar kelompok dengan teman sekelas juga dapat memberikan perspektif berbeda dan saling menguatkan pemahaman materi yang sulit.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Kegiatan Bakti Sosial ke Panti Asuhan',
                'deskripsi' => 'OSIS mengadakan kegiatan bakti sosial ke Panti Asuhan Cahaya Kasih sebagai bentuk kepedulian sosial terhadap sesama. Kegiatan yang dilaksanakan pada tanggal 20 November 2025 ini diikuti oleh 50 siswa pengurus OSIS dan perwakilan kelas. Persiapan dilakukan selama dua minggu dengan mengumpulkan donasi berupa sembako, pakaian layak pakai, dan alat tulis.

Sesampainya di panti asuhan, siswa-siswa OSIS langsung berinteraksi dengan anak-anak panti melalui berbagai kegiatan menyenangkan. Ada sesi bermain bersama, mendongeng, mengajar keterampilan sederhana, dan berbagi pengalaman. Suasana penuh keceriaan terlihat jelas dari wajah anak-anak panti yang sangat antusias menyambut kedatangan teman-teman OSIS.

Kegiatan diakhiri dengan penyerahan bantuan secara simbolis oleh ketua OSIS kepada pengelola panti asuhan. Bukan hanya materi yang diberikan, namun nilai-nilai empati, kepedulian, dan rasa syukur menjadi pembelajaran berharga bagi seluruh peserta. Kegiatan ini diharapkan dapat berkelanjutan dan menjadi program rutin OSIS setiap tahunnya.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Pentingnya Pendidikan Karakter di Sekolah',
                'deskripsi' => 'Pendidikan karakter memiliki peran yang sama pentingnya dengan pendidikan akademik dalam membentuk generasi muda yang berkualitas. Karakter yang kuat seperti kejujuran, disiplin, tanggung jawab, dan empati menjadi fondasi utama dalam menghadapi berbagai tantangan kehidupan. Sekolah sebagai institusi pendidikan memiliki tanggung jawab besar dalam menanamkan nilai-nilai luhur ini sejak dini.

Berbagai program seperti mentoring, kegiatan ekstrakurikuler, dan pengembangan soft skills menjadi media efektif dalam pembentukan karakter. Melalui kegiatan-kegiatan ini, siswa belajar bekerja sama, memecahkan masalah, berkomunikasi dengan baik, dan mengelola emosi. Pengalaman dalam menghadapi konflik dan mencari solusi juga mengasah kemampuan berpikir kritis dan kreatif siswa.

Hasil dari pendidikan karakter yang baik tidak hanya terlihat dalam prestasi akademik, tetapi juga dalam kehidupan sosial sehari-hari. Siswa yang memiliki karakter kuat cenderung lebih percaya diri, mampu beradaptasi dengan perubahan, dan menjadi agen perubahan positif di lingkungannya. Investasi dalam pendidikan karakter adalah investasi untuk masa depan bangsa yang lebih baik.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Lomba Cerdas Cermat Antar Kelas',
                'deskripsi' => 'OSIS berhasil menyelenggarakan lomba cerdas cermat antar kelas yang dilaksanakan pada 5-7 Desember 2025. Lomba ini bertujuan untuk meningkatkan pengetahuan umum siswa sekaligus mengasah kemampuan berpikir cepat dan kerja sama tim. Setiap kelas mengirimkan tim terbaiknya yang terdiri dari tiga siswa untuk bersaing memperebutkan gelar juara.

Babak penyisihan diikuti oleh 24 tim dari seluruh kelas dengan sistem gugur. Pertanyaan mencakup berbagai bidang pengetahuan seperti sains, sejarah, bahasa, dan pengetahuan umum. Suasana kompetisi yang sehat tercipta dengan antusiasme tinggi dari peserta dan penonton yang memenuhi aula sekolah untuk memberikan dukungan.

Final yang seru terjadi antara kelas XII IPA 1 dan XI IPS 2, dengan selisih nilai yang sangat tipis. Akhirnya, kelas XII IPA 1 berhasil meraih kemenangan setelah menjawab pertanyaan penentu dengan tepat. Lomba ini bukan hanya tentang kemenangan, tetapi juga tentang semangat belajar, sportivitas, dan kebersamaan antar siswa dari berbagai angkatan.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Mengatasi Stres saat Menghadapi Ujian',
                'deskripsi' => 'Stres akademik merupakan hal wajar yang dialami banyak siswa saat menghadapi ujian, namun dapat dikelola dengan teknik-teknik yang tepat. Gejala stres seperti sulit konsentrasi, gelisah, dan gangguan tidur sering muncul ketika tekanan akademik meningkat. Mengenali tanda-tanda ini sejak dini membantu dalam mengambil tindakan pencegahan yang efektif.

Teknik pernapasan dalam dan meditasi sederhana dapat membantu menenangkan pikiran dan mengurangi kecemasan. Latihan pernapasan 4-7-8 (tarik napas 4 detik, tahan 7 detik, hembuskan 8 detik) terbukti efektif dalam mengurangi tingkat stres. Selain itu, olahraga ringan seperti jalan kaki atau peregangan membantu melepaskan endorfin yang meningkatkan mood dan energi.

Penting untuk menghindari belajar dengan sistem kebut semalam karena justru menurunkan daya ingat dan konsentrasi. Sebaliknya, buat rencana belajar bertahap dengan istirahat yang cukup. Berbicara dengan teman, guru, atau konselor sekolah tentang kekhawatiran yang dirasakan juga dapat meringankan beban psikologis selama masa ujian.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Workshop Kepemimpinan untuk Pengurus OSIS',
                'deskripsi' => 'Pada 10 Januari 2026, OSIS mengadakan workshop kepemimpinan dengan menghadirkan narasumber dari organisasi pemuda nasional. Workshop ini bertujuan untuk meningkatkan kapasitas dan keterampilan kepemimpinan pengurus OSIS dalam mengelola organisasi. Materi yang disampaikan mencakup komunikasi efektif, manajemen waktu, dan pengambilan keputusan strategis.

Peserta workshop diajak untuk berpartisipasi aktif dalam berbagai simulasi dan studi kasus nyata. Aktivitas role-playing membantu pengurus OSIS memahami tantangan kepemimpinan dari berbagai perspektif. Diskusi kelompok juga memfasilitasi pertukaran ide dan pengalaman antar peserta dalam menyelesaikan masalah organisasi.

Workshop ditutup dengan sesi penyusunan rencana aksi untuk menerapkan ilmu yang didapat dalam program kerja OSIS. Setiap divisi membuat target konkret yang akan dievaluasi secara berkala. Kegiatan ini tidak hanya meningkatkan kemampuan individu, tetapi juga memperkuat kohesivitas tim kepengurusan OSIS secara keseluruhan.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Manfaat Mengikuti Ekstrakurikuler',
                'deskripsi' => 'Kegiatan ekstrakurikuler memiliki peran penting dalam mengembangkan potensi siswa di luar bidang akademik. Melalui ekstrakurikuler, siswa dapat mengeksplorasi minat dan bakat yang mungkin tidak terasah dalam kelas reguler. Berbagai pilihan kegiatan seperti olahraga, seni, sains, dan keterampilan praktis memberikan ruang bagi siswa untuk menemukan passion mereka.

Selain pengembangan bakat, ekstrakurikuler juga melatih soft skills yang sangat dibutuhkan dalam kehidupan nyata. Kerja sama tim, komunikasi, manajemen waktu, dan kemampuan memecahkan masalah adalah beberapa keterampilan yang dikembangkan melalui kegiatan organisasi. Pengalaman memimpin proyek atau event dalam ekstrakurikuler menjadi bekal berharga untuk masa depan.

Tidak kalah penting, ekstrakurikuler membangun jaringan pertemanan yang sehat dan positif. Interaksi dengan siswa dari berbagai kelas dan minat memperluas wawasan sosial dan budaya. Prestasi dalam ekstrakurikuler juga menjadi nilai tambah dalam portofolio siswa untuk melanjutkan pendidikan ke jenjang yang lebih tinggi atau memasuki dunia profesional.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Gerakan Literasi Sekolah',
                'deskripsi' => 'OSIS bekerja sama dengan perpustakaan sekolah meluncurkan gerakan literasi nasional dengan program membaca 15 menit setiap hari sebelum pelajaran dimulai. Gerakan ini bertujuan untuk menumbuhkan budaya membaca di kalangan siswa yang semakin tergantung pada media digital. Program ini dijalankan dengan pengawasan dari guru dan pengurus OSIS yang bertugas.

Setiap kelas menyediakan pojok baca dengan koleksi buku yang beragam sesuai minat siswa. Rotasi buku dilakukan secara berkala untuk menjaga minat baca tetap tinggi. Selain membaca mandiri, juga diadakan sesi diskusi buku bulanan dimana siswa dapat berbagi pemahaman dan pandangan tentang buku yang telah dibaca.

Hasil yang terlihat setelah tiga bulan program berjalan adalah peningkatan signifikan dalam minat baca dan kemampuan verbal siswa. Diskusi kelas menjadi lebih hidup dengan referensi yang lebih kaya. Gerakan ini juga mendorong siswa untuk mulai menulis karya sendiri, baik dalam bentuk cerpen, puisi, atau artikel sederhana tentang pengalaman mereka.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Teknologi dalam Pendidikan Modern',
                'deskripsi' => 'Perkembangan teknologi telah membawa transformasi signifikan dalam dunia pendidikan modern. Teknologi seperti platform e-learning, aplikasi edukasi interaktif, dan alat kolaborasi online telah mengubah cara belajar mengajar yang konvensional. Akses terhadap sumber belajar menjadi tidak terbatas oleh ruang dan waktu, memungkinkan siswa belajar sesuai dengan kecepatan dan gaya belajar masing-masing.

Integrasi teknologi dalam pembelajaran membuat materi lebih menarik dan mudah dipahami. Video animasi, simulasi virtual, dan gamifikasi pembelajaran meningkatkan engagement siswa terhadap materi pelajaran. Guru juga dapat memanfaatkan data analytics untuk memantau perkembangan siswa secara real-time dan memberikan intervensi yang tepat sesuai kebutuhan individu.

Namun, tantangan utama adalah menjaga keseimbangan antara penggunaan teknologi dan interaksi manusiawi. Penting untuk mengajarkan literasi digital yang bertanggung jawab kepada siswa. Teknologi harus menjadi alat bantu, bukan pengganti peran guru dan interaksi sosial yang esensial dalam proses pendidikan. Dengan pendekatan yang tepat, teknologi dapat memaksimalkan potensi belajar setiap siswa.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Peringatan Hari Sumpah Pemuda',
                'deskripsi' => 'Sekolah mengadakan upacara peringatan Hari Sumpah Pemuda pada 28 Oktober 2025 dengan OSIS sebagai panitia pelaksana. Upacara diikuti oleh seluruh siswa, guru, dan staf sekolah dengan khidmat. Petugas upacara terdiri dari pengurus OSIS yang telah berlatih selama dua minggu untuk memastikan kelancaran acara.

Selain upacara bendera, rangkaian acara juga meliputi pembacaan puisi bertema nasionalisme, penampilan tari tradisional dari berbagai daerah, dan pidato dari perwakilan siswa tentang relevansi Sumpah Pemuda di era modern. Pameran foto sejarah perjuangan pemuda Indonesia juga diselenggarakan untuk memberikan edukasi visual kepada peserta.

Acara puncak adalah diskusi panel dengan tema "Peran Pemuda Masa Kini dalam Membangun Bangsa" yang menghadirkan pembicara dari berbagai latar belakang. Diskusi ini menginspirasi siswa untuk mengambil peran aktif dalam pembangunan bangsa sesuai dengan bidang minat masing-masing. Peringatan ini tidak hanya seremonial, tetapi menjadi momentum refleksi dan aksi nyata.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Mengelola Waktu antara Sekolah dan Organisasi',
                'deskripsi' => 'Banyak siswa yang aktif di organisasi sekolah sering mengalami kesulitan dalam menyeimbangkan antara kewajiban akademik dan tanggung jawab organisasi. Kunci utama dari manajemen waktu yang efektif adalah kemampuan untuk menentukan prioritas dengan jelas. Membuat skala prioritas berdasarkan deadline, tingkat kesulitan, dan dampak dari setiap tugas membantu dalam mengambil keputusan yang tepat.

Penggunaan alat bantu seperti planner digital atau bullet journal sangat membantu dalam mengorganisir waktu. Alokasikan waktu khusus untuk belajar, mengerjakan tugas organisasi, dan istirahat secara seimbang. Teknik time blocking, dimana waktu dibagi menjadi blok-blok spesifik untuk aktivitas tertentu, terbukti efektif meningkatkan produktivitas tanpa menyebabkan burnout.

Jangan ragu untuk mendelegasikan tugas ketika merasa kewalahan dan belajar untuk mengatakan "tidak" pada tanggung jawab tambahan yang tidak dapat ditangani. Komunikasi yang terbuka dengan guru, pembina OSIS, dan orang tua tentang beban yang dirasakan juga penting. Keseimbangan yang sehat antara akademik dan organisasi akan menghasilkan pengalaman belajar yang optimal dan pengembangan diri yang maksimal.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Festival Seni dan Budaya',
                'deskripsi' => 'Festival Seni dan Budaya tahunan sekolah diselenggarakan pada 15 Maret 2026 dengan OSIS sebagai panitia utama. Acara ini menjadi ajang apresiasi terhadap bakat seni siswa dalam berbagai bidang seperti tari, musik, teater, dan seni rupa. Persiapan dilakukan selama tiga bulan dengan melibatkan siswa dari semua ekstrakurikuler seni.

Panggung utama menampilkan berbagai pertunjukan spektakuler mulai dari tari tradisional kontemporer, penampilan band sekolah, drama musikal, hingga fashion show busana daerah. Area pameran menampilkan karya seni rupa siswa termasuk lukisan, patung, kerajinan tangan, dan fotografi yang mencerminkan kreativitas dan keunikan masing-masing seniman.

Festival ini tidak hanya dihadiri oleh warga sekolah tetapi juga terbuka untuk orang tua siswa dan masyarakat sekitar. Selain sebagai sarana ekspresi seni, festival ini juga menjadi penggalangan dana untuk program beasiswa siswa berprestasi. Suksesnya acara ini membuktikan bahwa pendidikan seni dan budaya memiliki tempat penting dalam pendidikan holistik.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Peran OSIS dalam Mencegah Bullying',
                'deskripsi' => 'OSIS memiliki peran strategis dalam menciptakan lingkungan sekolah yang aman dan bebas dari bullying. Melalui program mentoring sebaya, OSIS membentuk tim kader anti-bullying yang terlatih untuk mendeteksi dan menangani kasus bullying secara dini. Tim ini berfungsi sebagai teman curhat dan mediator bagi siswa yang mengalami masalah perundungan.

Kampanye anti-bullying secara berkala dilaksanakan melalui berbagai media seperti poster, video edukasi, dan talkshow dengan tema "Stop Bullying, Start Caring". Materi kampanye menekankan pada dampak psikologis jangka panjang dari bullying dan pentingnya membangun budaya saling menghargai perbedaan. Testimoni dari korban bullying yang telah pulih juga menjadi bagian dari kampanye untuk memberikan inspirasi.

OSIS juga membuka layanan konseling sebaya dimana siswa dapat melaporkan kasus bullying secara anonym. Laporan kemudian ditindaklanjuti dengan pendekatan restoratif justice yang melibatkan pelaku, korban, dan pihak sekolah untuk mencari solusi yang memulihkan hubungan. Dengan pendekatan komprehensif ini, kasus bullying dapat diminimalisir dan lingkungan sekolah menjadi lebih inklusif.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Kemah Bersama Pengurus OSIS',
                'deskripsi' => 'Kegiatan kemah bersama pengurus OSIS dilaksanakan pada 5-6 April 2026 di Bumi Perkemahan Gunung Bunder sebagai agenda tahunan pembentukan tim. Kegiatan ini bertujuan untuk memperkuat hubungan antar anggota kepengurusan melalui pengalaman di alam terbuka. Selama dua hari, peserta mengikuti berbagai aktivitas team building dan survival skill training.

Hari pertama diisi dengan pendakian menuju lokasi perkemahan, penyiapan tenda, dan cooking competition menggunakan peralatan seadanya. Malam harinya, api unggun menjadi momen refleksi bersama tentang perjalanan kepengurusan selama setahun. Sharing session membahas tantangan yang dihadapi dan solusi kreatif yang telah diimplementasikan.

Hari kedua difokuskan pada perencanaan program kerja untuk semester berikutnya melalui workshop outdoor. Brainstorming dilakukan dengan metode yang lebih santai namun produktif di tengah alam. Kemah ini tidak hanya memperkuat fisik dan mental, tetapi juga menumbuhkan rasa kebersamaan dan komitmen yang lebih dalam terhadap visi misi OSIS untuk memajukan sekolah.',
                'jenis_artikel' => 'event',
                'admin_id' => $admin->id,
                'img' => null
            ],
            [
                'judul' => 'Menyiapkan Mental untuk Masuk Perguruan Tinggi',
                'deskripsi' => 'Persiapan memasuki perguruan tinggi membutuhkan lebih dari sekadar persiapan akademik semata. Aspek mental dan psikologis memiliki peran yang sangat penting dalam menentukan keberhasilan adaptasi di lingkungan baru. Kemampuan untuk mengelola stres, mengatasi kegagalan, dan menjaga motivasi adalah keterampilan hidup yang perlu dikembangkan sejak dini.

Siswa perlu dilatih untuk memiliki growth mindset, yaitu keyakinan bahwa kemampuan dapat dikembangkan melalui usaha dan pembelajaran. Mentalitas ini membantu dalam menghadapi tantangan akademik yang lebih berat di perguruan tinggi. Selain itu, kemampuan untuk belajar mandiri, mengatur waktu tanpa pengawasan ketat, dan mengambil inisiatif menjadi bekal berharga.

Pengalaman organisasi di sekolah, termasuk di OSIS, menjadi modal berharga untuk mengembangkan soft skills yang dibutuhkan di dunia perkuliahan. Keterampilan presentasi, negosiasi, kepemimpinan tim, dan networking yang telah diasah selama aktif berorganisasi akan sangat bermanfaat. Persiapan mental yang matang membuat transisi dari sekolah menengah ke perguruan tinggi menjadi lebih mulus dan sukses.',
                'jenis_artikel' => 'artikel',
                'admin_id' => $admin->id,
                'img' => null
            ]
        ];

        foreach ($articles as $article) {
            Artikel::create($article);
        }
    }
}