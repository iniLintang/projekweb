<?php
// Assuming you have a database connection in db.php
require_once 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $cv_url = $_POST['cv-url'];
    $motivasi = $_POST['motivasi'];
    $pendidikan = $_POST['pendidikan'];
    $pengalaman = $_POST['pengalaman'];
    $keterampilan = $_POST['keterampilan'];

    // Assuming session or user data gives you the job seeker ID and job ID
    $id_pekerjaan = $_SESSION['id_pekerjaan']; // Set this appropriately
    $id_pencari_kerja = $_SESSION['id_pencari_kerja']; // Set this appropriately

    // Set the default status to 'dikirim'
    $status = 'dikirim';
    
    // Create a description of the application based on the form data
    $deskripsi = "CV URL: $cv_url\nMotivasi: $motivasi\nPendidikan: $pendidikan\nPengalaman Kerja: $pengalaman\nKeterampilan: $keterampilan";

    // Prepare the SQL query
    $query = "INSERT INTO lamaran (id_pekerjaan, id_pencari_kerja, status, deskripsi) 
              VALUES (?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameters
        $stmt->bind_param("iiss", $id_pekerjaan, $id_pencari_kerja, $status, $deskripsi);

        // Execute the query
        if ($stmt->execute()) {
            echo "Lamaran berhasil dikirim!";
        } else {
            echo "Terjadi kesalahan saat mengirim lamaran: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Terjadi kesalahan dalam mempersiapkan pernyataan: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PencariKerja_LookWork</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index_2.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0" style="color: #16423C;">LookWork</h1>
            </a>

            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Navigasi di kiri -->
                <div class="navbar-nav me-auto p-4 p-lg-0">
                    <a href="index_2.html" class="nav-item nav-link active">Beranda</a>
                    <a href="index_2.html#tentang" class="nav-item nav-link">Tentang</a>
                    <a href="index_2.html#testi" class="nav-item nav-link">Testi</a>
                    <a href="index_2.html#kontak" class="nav-item nav-link">Kontak</a>
                    <a href="daftar_pekerjaan.html" class="nav-item nav-link">Pekerjaan</a>
                    <a href="daftar_perusahaan.html" class="nav-item nav-link">Perusahaan</a>
                    <a href="notifikasi.html" class="nav-item nav-link">Notifikasi</a>
                </div>
                
                <!-- Tombol di kanan -->
                <?php if(isset($_SESSION['username'])): ?>
                    <div class="dropdown">
                        <a href="#" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block dropdown-toggle" style="background-color: #6A9C89; border-color: #6A9C89;" data-bs-toggle="dropdown">
                            <?= $_SESSION['username']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profil.html">Profil</a></li>
                            <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </nav>

        <style>
            h3 {
                text-align: center;
                color: #16423C;
                margin-top: 50px;
            }

            .form-container {
                background-color: #f8f9fa;
                border-radius: 10px;
                padding: 30px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-top: 30px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            label {
                font-weight: bold;
                color: #333;
            }

            input, textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
            }

            textarea {
                resize: vertical;
            }

            button {
                padding: 10px 20px;
                background-color: #6A9C89;
                border: none;
                border-radius: 5px;
                color: white;
                font-size: 16px;
                cursor: pointer;
            }

            button:hover {
                background-color: #5a8a76;
            }

            .btn-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px; 
                margin-top: 20px;
            }

            #surat-preview, #cv-url-preview {
                margin-top: 20px;
                border: 1px solid #ddd;
                padding: 20px;
                display: none;
                background-color: #f8f9fa;
                border-radius: 8px;
            }
        </style>

        <div class="container">
            <h3>Form Surat Lamaran Pekerjaan</h3>

            <div class="form-container">
                <form id="form-lamaran">
                    <div class="form-group">
                        <label for="cv-url">URL CV:</label>
                        <input type="url" id="cv-url" name="cv-url" placeholder="Masukkan URL CV Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="motivasi">Motivasi:</label>
                        <textarea id="motivasi" name="motivasi" rows="4" placeholder="Tulis motivasi Anda di sini..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="pendidikan">Pendidikan:</label>
                        <input type="text" id="pendidikan" name="pendidikan" placeholder="Masukkan pendidikan Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="pengalaman">Pengalaman Kerja:</label>
                        <input type="text" id="pengalaman" name="pengalaman" placeholder="Masukkan pengalaman kerja Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="keterampilan">Keterampilan:</label>
                        <input type="text" id="keterampilan" name="keterampilan" placeholder="Masukkan keterampilan Anda" required>
                    </div>

                    <div class="btn-container">
                        <button type="submit">Kirim Lamaran</button>
                        <button type="button" id="btn-preview">Lihat Preview Surat Lamaran</button>
                    </div>
                </form>
            </div>

            <div id="surat-preview">
                <h4>Preview Surat Lamaran</h4>
                <div id="preview-content"></div> 
            </div>

            <div id="cv-url-preview" class="section"></div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Lamaran Terkirim</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Lamaran Anda telah berhasil dikirim! Anda dapat mendownload surat lamaran dalam bentuk PDF.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="btn-download-pdf">Download Surat Lamaran PDF</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/bootstrap.bundle.min.js"></script>
        <script>
            document.getElementById("form-lamaran").addEventListener("submit", function(e) {
                e.preventDefault();
                document.getElementById("successModal").classList.add("show");
                document.getElementById("successModal").style.display = "block";
            });
        </script>
        
        <!-- Footer -->
        <div id="kontak" class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-6 text-center">
                        <h5 class="text-white mb-4">Kontak</h5>
                        <p class="mb-2">
                            <a href="https://www.instagram.com/lookwork__/" target="_blank" class="text-white-50">
                                <i class="fab fa-instagram me-3"></i>Instagram : @lookwork__
                            </a>
                        </p>
                        <p class="mb-2">
                            <a href="https://wa.me/<?php echo $no_wa; ?>?text=Halo%20saya%20ingin%20bertanya" target="_blank" class="text-white-50">
                                <i class="fa fa-phone-alt me-3"></i>WhatsApp: +6282266479716
                            </a>
                        </p>
                        <p class="mb-2">
                            <a href="mailto:custsercices@lookwork.com?subject=Subject%20Anda&body=Halo,%20saya%20ingin%20bertanya." target="_blank" class="text-white-50">
                                <i class="fa fa-envelope me-3"></i>Email: info@lookwork.com
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script>
        // Fungsi untuk memperbarui preview surat lamaran setiap kali data di form diubah
        function updatePreview() {
            // Ambil data dari form
            const cvUrl = document.getElementById("cv-url").value;
            const motivasi = document.getElementById("motivasi").value;
            const pendidikan = document.getElementById("pendidikan").value;
            const pengalaman = document.getElementById("pengalaman").value;
            const keterampilan = document.getElementById("keterampilan").value;
    
            // Buat surat lamaran HTML
            const suratLamaran = `
                <p style="text-align:center;"><strong>Surat Lamaran Pekerjaan</strong></p>
                <p>Kepada Yth.</p>
                <p>HRD <strong id="nama-perusahaan">[Nama Perusahaan]</strong></p>
                <p>di Tempat</p>
                <p>Dengan hormat,</p>
                <p>Saya yang bertanda tangan di bawah ini:</p>
                <ul>
                    <li><strong>Nama:</strong> [Nama Pencari Kerja]</li>
                    <li><strong>Email:</strong> [Email Pencari Kerja]</li>
                    <li><strong>Telepon:</strong> [Nomor Telepon Pencari Kerja]</li>
                </ul>
    
                <p>Saya mengajukan lamaran pekerjaan untuk posisi <strong>[Nama Posisi]</strong> yang saya rasa sesuai dengan latar belakang dan kualifikasi saya. Berikut adalah informasi terkait kualifikasi saya:</p>
    
                <ul>
                    <li><strong>Pendidikan:</strong> ${pendidikan}</li>
                    <li><strong>Pengalaman Kerja:</strong> ${pengalaman}</li>
                    <li><strong>Keterampilan:</strong> ${keterampilan}</li>
                </ul>
    
                <p><strong>Motivasi:</strong></p>
                <p>${motivasi}</p>
    
                <p>Saya berharap dapat bergabung dengan perusahaan <strong>[Nama Perusahaan]</strong> dan berkontribusi untuk kesuksesan perusahaan. Saya sangat berharap dapat mengikuti tahap seleksi berikutnya.</p>
    
                <p>Demikian surat lamaran ini saya buat dengan sebenar-benarnya. Atas perhatian dan kesempatan yang diberikan, saya ucapkan terima kasih.</p>
    
                <p>Hormat saya,</p>
                <p>[Nama Pencari Kerja]</p>
            `;
    
            // Menampilkan surat lamaran dalam preview
            document.getElementById("surat-preview").innerHTML = suratLamaran;
    
            // Menampilkan URL CV terpisah
            const cvUrlPreview = `
                <p><strong>URL CV:</strong> <a href="${cvUrl}" target="_blank">${cvUrl}</a></p>
            `;
            document.getElementById("cv-url-preview").innerHTML = cvUrlPreview;
    
            // Menampilkan preview surat lamaran dan URL CV
            document.getElementById("surat-preview").style.display = "block";
            document.getElementById("cv-url-preview").style.display = "block";
        }
    
        // Update preview ketika data dalam form berubah
        document.getElementById("form-lamaran").addEventListener("input", updatePreview);
    
        // Menampilkan atau menyembunyikan preview surat lamaran ketika tombol "Lihat Preview" ditekan
        document.getElementById("btn-preview").addEventListener("click", function() {
            const suratPreview = document.getElementById("surat-preview");
            const cvPreview = document.getElementById("cv-url-preview");
    
            // Tampilkan atau sembunyikan preview
            if (suratPreview.style.display === "none" || suratPreview.style.display === "") {
                suratPreview.style.display = "block";
                cvPreview.style.display = "block";
            } else {
                suratPreview.style.display = "none";
                cvPreview.style.display = "none";
            }
        });
    
        // Fungsi untuk menampilkan modal setelah form dikirim
        document.getElementById("form-lamaran").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah form agar tidak refresh halaman
    
            // Simpan status pengiriman form ke local storage
            localStorage.setItem("formSubmitted", "true");
    
            // Tampilkan modal
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    
        // Fungsi untuk mengecek apakah form sudah pernah dikirim sebelumnya
        window.onload = function() {
            if (localStorage.getItem("formSubmitted") === "true") {
                // Jika form sudah pernah dikirim, modal tidak akan ditampilkan saat halaman di-refresh
                localStorage.removeItem("formSubmitted"); // Reset status setelah modal ditampilkan
            }
        };
    
        // Fungsi untuk mendownload surat lamaran sebagai PDF
        document.getElementById("btn-download-pdf").addEventListener("click", function() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
    
            const cvUrl = document.getElementById("cv-url").value;
        const motivasi = document.getElementById("motivasi").value;
        const pendidikan = document.getElementById("pendidikan").value;
        const pengalaman = document.getElementById("pengalaman").value;
        const keterampilan = document.getElementById("keterampilan").value;

        // Set margin dan font untuk surat lamaran
        const marginLeft = 20;
        const marginTop = 20;
        const lineHeight = 8;
        const fontSize = 12;
        
        doc.setFontSize(fontSize);
        
        doc.text("Kepada Yth.", marginLeft, marginTop + 20);
        doc.text("HRD [Nama Perusahaan]", marginLeft, marginTop + 30);
        doc.text("di Tempat", marginLeft, marginTop + 40);
        
        doc.text("Dengan hormat,", marginLeft, marginTop + 60);
        
        // Section untuk data pribadi
        doc.text("Saya yang bertanda tangan di bawah ini:", marginLeft, marginTop + 80);
        doc.text(`- Nama: [Nama Pencari Kerja]`, marginLeft, marginTop + 90);
        doc.text(`- Email: [Email Pencari Kerja]`, marginLeft, marginTop + 100);

        
        // Section untuk kualifikasi
        doc.text("Berikut adalah informasi terkait kualifikasi saya:", marginLeft, marginTop + 130);
        doc.text(`- Pendidikan: ${pendidikan}`, marginLeft, marginTop + 140);
        doc.text(`- Pengalaman Kerja: ${pengalaman}`, marginLeft, marginTop + 150);
        doc.text(`- Keterampilan: ${keterampilan}`, marginLeft, marginTop + 160);
        
        // Section untuk motivasi
        doc.text("Motivasi:", marginLeft, marginTop + 180);
        doc.text(motivasi, marginLeft, marginTop + 190, { maxWidth: 170, lineHeight: lineHeight });
        
        // Penutup
        doc.text("Demikian surat lamaran ini saya buat dengan sebenar-benarnya.", marginLeft, marginTop + 220);
        doc.text("Hormat saya,", marginLeft, marginTop + 230);
        doc.text("[Nama Pencari Kerja]", marginLeft, marginTop + 240);
    
            // Simpan PDF dengan nama "Surat_Lamaran.pdf"
            doc.save("Surat_Lamaran.pdf");
    
            // Tutup modal setelah download selesai
            var successModal = bootstrap.Modal.getInstance(document.getElementById('successModal'));
            successModal.hide();
        });
    </script>
    