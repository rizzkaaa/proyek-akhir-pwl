<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="./asset/thumbnail.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insight & Quality Bimbel</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Tuffy:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <header>
            <nav> 
                <div class="logo">
                    <a href="#"><img src="./asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                    <div class="judul">Insight & Quality</div>
                </div>
                <ul>
                    <li><a href="./#tentang-kami">Tentang Kami <i class="fa-solid fa-users"></i></a></li>
                    <li><a href="./#paket-belajar">Paket Belajar <i class="fa-solid fa-book"></i></a></li>
                    <li><a href="./#testimonie">Apa Kata Mereka? <i class="fa-solid fa-person"></i></a></li>
                    <li><a href="./#faq">FAQ <i class="fa-solid fa-question"></i></a></li>
                </ul>
            </nav>

            <div class="banner">
                <h1>Insght & Quality BIMBEL</h1>
                <h4>Dare Your IQ!</h4>
                <div>
                    <button><a href="./daftar/">DAFTAR</a></button>
                    <button><a href="./masuk/">MASUK</a></button>
                </div>
            </div>
        </header>

        <section id="tentang-kami">
            <h1>Tentang Kami</h1>
            <div class="side">
                <div >
                    <p>IQ Bimbel hadir sebagai solusi bimbingan belajar terpercaya bagi siswa yang ingin meraih prestasi akademik terbaik. Berdiri dengan semangat memberikan <b>insight</b> (pemahaman mendalam) dan <b>quality</b> (kualitas pembelajaran tinggi), kami berkomitmen untuk mendampingi setiap siswa mencapai potensi terbaiknya.</p>    
                    <p>Kami percaya bahwa setiap anak memiliki cara belajar yang unik. Karena itu, program kami dirancang secara personal, interaktif, dan menyenangkan, dengan didukung oleh tutor berpengalaman dan metode belajar yang efektif.</p>
                    <p>Dengan menggabungkan teknologi, materi yang terus diperbarui, dan pendekatan pengajaran yang adaptif, IQ Bimbel siap menjadi partner belajar yang bukan hanya membantu siswa memahami pelajaran, tapi juga menumbuhkan rasa percaya diri dan semangat belajar.</p>
                    <p><b> — Insightful Learning, Quality Result.</b></p>
                </div>
                <div>
                    <img src="./asset/elemen-about2.gif">
                    <h2>Insight & Quality</h2>
                </div>
            </div>
            <div class="side"><i class="fa-brands fa-facebook-f"></i><i class="fa-brands fa-instagram"></i><i class="fa-brands fa-whatsapp"></i><i class="fa-brands fa-x-twitter"></i><i class="fa-brands fa-youtube"></i></div>
        </section>

        <section>
            <h1>Fasilitas untuk Mendukung Belajarmu</h1>
            <div class="cards">
                <div class="card">
                    <div><h3>WiFi Cepat dan Stabil</h3></div>
                    <p>Akses internet full-speed untuk mendukung kegiatan belajar digital dan eksplorasi materi online.</p>
                </div>
                <div class="card">
                    <div><h3>Pengajar Berpengalaman</h3></div>
                    <p>Tim tutor profesional, sabar, dan ahli di bidangnya, siap membimbing siswa dengan metode yang efektif.</p>
                </div>
                <div class="card">
                    <div><h3>Ruang Kelas Ber-AC</h3></div>
                    <p>Belajar lebih fokus dan nyaman di ruang kelas ber-AC, bersih, dan tertata rapi.</p>
                </div>
                <div class="card">
                    <div><h3>Gaya Belajar Modern</h3></div>
                    <p>Menggunakan Smart TV, laptop, dan media interaktif untuk membuat proses belajar lebih seru dan mudah dipahami.</p>
                </div>
                <div class="card">
                    <div><h3>Sistem Belajar Personal</h3></div>
                    <p>Setiap siswa mendapat perhatian khusus, dengan program yang dirancang sesuai kebutuhan masing-masing.</p>
                </div>
                <div class="card">
                    <div><h3>Simulasi Ujian Berkala</h3></div>
                    <p>Ada try out rutin untuk mengukur kemajuan dan kesiapan siswa menghadapi ujian sungguhan.</p>
                </div>
            </div>
        </section>

       <section id="paket-belajar">
            <h1>Paket Belajar IQ Bimbel</h1>
            <div class="cards">
                <div class="card" id="paket-a">
                    <img src="./asset/paket/anak-sd.jpg">
                    <div class="wrap">
                        <div class="judul">Paket A</div>
                        <div>
                            <span>1-2 SD</span>
                            <span>3-4 SD</span>
                            <span>5-6 SD</span>
                        </div>
                        <p class="deskripsi">Bantu anak Anda tumbuh percaya diri dan berprestasi sejak dini! Paket A di IQ BIMBEL kami rancang untuk membuat belajar jadi menyenangkan dan efektif. Daftar sekarang dan jadikan masa depan si kecil lebih gemilang!</p>
                        <button><a href="./daftar/?id_paket=<?php echo urlencode('A'); ?>">Daftar</a></button>
                    </div>
                </div>
                <div class="card" id="paket-b">
                    <img src="./asset/paket/anak-smp.png">
                    <div class="wrap">
                        <div class="judul">Paket B</div>
                        <div>
                            <span>7 SMP</span>
                            <span>8 SMP</span>
                            <span>9 SMP</span>
                        </div>
                        <p class="deskripsi">Saatnya tingkatkan prestasi di masa penting SMP! Di sini, anak Anda dibimbing intensif agar lebih mudah memahami pelajaran dan siap menghadapi ujian. Gabung hari ini, wujudkan prestasi gemilang!"</p>
                        <button><a href="./daftar/?id_paket=<?php echo urlencode('B'); ?>"">Daftar</a></button>
                    </div>
                </div>
                <div class="card" id="paket-c">
                    <img src="./asset/paket/anak-sma.jpg">
                    <div class="wrap">
                        <div class="judul">Paket C</div>
                        <div>
                            <span>10 SMA/SMK</span>
                            <span>11 SMA/SMK</span>
                            <span>12 SMA/SMK</span>
                        </div>
                        <p class="deskripsi">Siap sukses ujian dan masuk kampus impian? IQ BIMBEL hadir dengan program khusus untuk siswa SMA/SMK, lengkap dengan strategi belajar efektif dan mentor berpengalaman. Jangan tunda lagi, raih masa depanmu bersama kami!"</p>
                        <button><a href="./daftar/?id_paket=<?php echo urlencode('C'); ?>"">Daftar</a></button>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonie">
            <h1>Apa Kata Mereka?</h1>
            <div class="cards" id="komen"></div>

            <div class="faq" id="faq">
                <img src="./asset/elemen-about.png" alt="">
                <div>
                    <div class="wrap">
                        <input type="radio" id="faq1" name="theFAQ">
                        <label for="faq1">Apa itu IQ Bimbel?<span class="sign"></span></label>
                        <div class="answer">
                            <div class="garis"></div>
                            <p><b>IQ Bimbel</b> adalah lembaga bimbingan belajar untuk jenjang SD, SMP, dan SMA yang menghadirkan pengajar berpengalaman, fasilitas modern, dan pendekatan belajar yang menyenangkan dan terarah.</p>
                        </div>
                    </div>
                    <div class="wrap">
                        <input type="radio" id="faq2" name="theFAQ">
                        <label for="faq2"> Apa saja paket belajar di IQ Bimbel?<span class="sign"></span></label>
                        <div class="answer">
                            <div class="garis"></div>
                            <p>Tersedia paket belajar A untuk SD, paket belajar B untuk SMP, dan paket belajar A untuk SMA.</p>
                        </div>
                    </div>
                    <div class="wrap">
                        <input type="radio" id="faq3" name="theFAQ">
                        <label for="faq3">Apa keunggulan IQ Bimbel dibanding bimbel lain?<span class="sign"></span></label>
                        <div class="answer">
                            <div class="garis"></div>
                            <ul>
                                <li>Pengajar profesional dan berpengalaman</li>
                                <li>Ruang belajar nyaman dan ber-AC</li>
                                <li>Fasilitas modern (Smart TV, laptop, wifi)</li>
                                <li>Metode belajar interaktif dan menyenangkan</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="wrap">
                        <input type="radio" id="faq4" name="theFAQ">
                        <label for="faq4"> Di mana lokasi IQ Bimbel?<span class="sign"></span></label>
                        <div class="answer">
                            <div class="garis"></div>
                            <p>di Jl. Jalan Raya, Kec. Sungailiat, Kabupaten Bangka, Kepulauan Bangka Belitung 11233</p>
                    </div>
                    </div>
                    <div class="wrap">
                        <input type="radio" id="faq5" name="theFAQ">
                        <label for="faq5">Bagaimana cara mendaftar?<span class="sign"></span></label>
                        <div class="answer">
                            <div class="garis"></div>
                            <p>Pendaftaram dimulai dengan mengisi formulir pada halaman <a href="./daftar/">Daftar</a>, lalu mencentak formulir tersebut dan membawanya ke IQ Bimbel langsung kemudian melakukan pembayaran.</p>
                        </div>
                    </div>
                    <div class="wrap">
                        <input type="radio" id="faq6" name="theFAQ">
                        <label for="faq6">Apakah IQ Bimbel bisa bantu persiapan UTBK/SNBT?<span class="sign"></span></label>
                        <div class="answer">
                            <div class="garis"></div>
                            <p>Tentu! Kami memiliki program khusus untuk UTBK/SNBT dan ujian masuk PTN, dengan modul latihan, try out, dan pembahasan intensif.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <footer>
            <div class="side">
                <i class="fa-brands fa-facebook-f"></i><i class="fa-brands fa-instagram"></i><i class="fa-brands fa-whatsapp"></i><i class="fa-brands fa-x-twitter"></i><i class="fa-brands fa-youtube"></i>
            </div>
            <div class="side">
                <div>
                    <div class="logo">
                        <a href="#"><img src="./asset/iq-bimbel.png" alt="IQ-Bimbel"></a>
                        <div class="judul">Insight & Quality</div>
                    </div>
                    <p>Bersama IQ Bimbel, belajar jadi lebih mudah, nyaman, dan menyenangkan!
                    Dengan pengajar berpengalaman, fasilitas modern, dan metode belajar interaktif, kami siap membantu siswa SD, SMP, dan SMA mencapai prestasi terbaiknya.</p>

                    <h4>Alamat:</h4>
                    <p>Jl. Jalan Raya, Kec. Sungailiat, Kabupaten Bangka, Kepulauan Bangka Belitung 11233</p>
                </div>
                <div>
                    <h4>Tautan Cepat</h4>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="./#tentang-kami">Tentang Kami</a></li>
                        <li><a href="./#testimonie">Apa Kata Mereka?</a></li>
                        <li><a href="./#faq">FAQ</a></li>
                        <li><a href="./daftar/">Register</a></li>
                        <li><a href="./masuk/">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Paket Belajar</h4>
                    <ul>
                        <li><a href="./#paket-a">Paket A</a></li>
                        <li><a href="./#paket-b">Paket B</a></li>
                        <li><a href="./#paket-c">Paket C</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Hubungi Kami</h4>
                    <ul>
                        <li>+628 1234-5678</li>
                        <li>insghtnqualitybimbel@gmail.com</li>
                        <li>Kru Kami</li>
                    </ul>
                </div>
            </div>
            <div class="side">
                © Copyright 2025 Rizka Layla Ramadhani. All Rights Reserved.
            </div>
        </footer>
    </div>

    <script src="./script.js"></script>
</body>
</html>