const judul = document.querySelector('.judul')

const huruf = [...judul.textContent]
.map(h => `<span>${h}</span>`).join('');
judul.innerHTML = huruf

const span = document.querySelectorAll('nav div .judul span')
.forEach((s, i) => {
    s.style.setProperty('--i', i)
})

const path = document.querySelectorAll('section:nth-child(3) .card div')
.forEach((p, i) => p.style.backgroundImage = `url(./asset/fasilitas/fs-${i+1}.png)`);

const komen = [
    {
        name: 'Nadia (Siswa SMP kelas 8)',
        img: 'Nadia-smp',
        desc: "Belajar di IQ Bimbel seru banget! Gurunya asik dan gampang ngerti materinya. Nilai ulangan langsung naik!"
    },
    {
        name: 'Meira (Alumni, Mahasiswa FEB)',
        img: 'Meira-alumni',
        desc: "Dulu saya ikut IQ Bimbel pas kelas 12. Berkat bimbel ini, saya bisa masuk kampus impian saya. Terima kasih IQ Bimbel!"
    },
    {
        name: 'Rafi (Siswa SMA kelas 12)',
        img: 'Rafi-sma',
        desc: "Persiapan UTBK di IQ Bimbel benar-benar membantu! Soalnya lengkap, dan pembahasannya jelas. Rekomendasi banget!"
    },
    {
        name: 'Heri dan Diah (Orang Tua Siswa SD)',
        img: 'HeriDiah-ortu',
        desc: "IQ Bimbel beda dari yang lain. Jadwalnya fleksibel, fasilitasnya modern, dan anak kami jadi lebih percaya diri di sekolah."
    },
    {
        name: 'Andi dan Ira (Siswa SMA kelas 11)',
        img: 'AndiIra-sma',
        desc: "Suasananya nyaman dan fokus. Ada Smart TV di kelas, jadi materi bisa langsung dijelasin pakai visual."
    },
    {
        name: 'Dimas (Siswa SD kelas 6)',
        img: 'Dimas-sd',
        desc: "Belajarnya pakai gambar dan video, jadi aku nggak cepat bosan. Gurunya juga baik banget!"
    },
    {
        name: 'Bella (Siswa SMP kelas 9)',
        img: 'Bella-smp',
        desc: "Aku sebelumnya kesulitan di Matematika. Setelah ikut IQ Bimbel, nilainya naik drastis!"
    },
    {
        name: 'Serly dan Reno (Alumni, Mahasiswa Teknik)',
        img: 'SerlyReno-alumni',
        desc: "IQ Bimbel bantu banget waktu persiapan UTBK. Belajarnya terarah, dan tutornya suportif. Nggak nyesel ikut di sini!"
    }
]

komen.map(k => {
    document.getElementById('komen').innerHTML += `
        <div class="card">
            <img src="./asset/komen/${k.img}.png">
            <div>
                <div class="nama">${k.name}</div>
                <p>${k.desc}</p>
            </div>
        </div>
    `;
})
