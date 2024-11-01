$(document).ready(function() {
    // start: Sidebar
    $('.sidebar-dropdown-menu').slideUp('fast');

    $('.sidebar-menu-item.has-dropdown > a, .sidebar-dropdown-menu-item.has-dropdown > a').click(function(e) {
        e.preventDefault();

        if (!($(this).parent().hasClass('focused'))) {
            $(this).parent().parent().find('.sidebar-dropdown-menu').slideUp('fast');
            $(this).parent().parent().find('.has-dropdown').removeClass('focused');
        }

        $(this).next().slideToggle('fast');
        $(this).parent().toggleClass('focused');
    });

    $('.sidebar-toggle').click(function() {
        $('.sidebar').toggleClass('collapsed');

        $('.sidebar.collapsed').mouseleave(function() {
            $('.sidebar-dropdown-menu').slideUp('fast');
            $('.sidebar-menu-item.has-dropdown, .sidebar-dropdown-menu-item.has-dropdown').removeClass('focused');
        });
    });

    $('.sidebar-overlay').click(function() {
        $('.sidebar').addClass('collapsed');

        $('.sidebar-dropdown-menu').slideUp('fast');
        $('.sidebar-menu-item.has-dropdown, .sidebar-dropdown-menu-item.has-dropdown').removeClass('focused');
    });

    if (window.innerWidth < 768) {
        $('.sidebar').addClass('collapsed');
    }
    // end: Sidebar

    // start: Charts
    // Ambil konteks dari canvas
    var ctx = document.getElementById('sales-chart').getContext('2d');

    // Data untuk grafik
    var salesChart = new Chart(ctx, {
        type: 'line', // Tipe grafik garis
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'], // Label sumbu X
            datasets: [
                {
                    label: 'Aktivitas Web', // Label untuk dataset web
                    data: [12, 19, 3, 5, 2, 3, 7], // Data untuk aktivitas web
                    borderColor: 'blue', // Warna garis
                    backgroundColor: 'rgba(0, 123, 255, 0.1)', // Warna latar belakang
                    fill: true, // Mengisi area di bawah garis
                    tension: 0.1 // Tingkat kelengkungan garis
                },
                {
                    label: 'Aktivitas Mobile', // Label untuk dataset mobile
                    data: [5, 15, 10, 8, 7, 15, 12], // Data untuk aktivitas mobile
                    borderColor: 'green', // Warna garis
                    backgroundColor: 'rgba(40, 167, 69, 0.1)', // Warna latar belakang
                    fill: true, // Mengisi area di bawah garis
                    tension: 0.1 // Tingkat kelengkungan garis
                }
            ]
        },
        options: {
            responsive: true, // Responsif
            plugins: {
                legend: {
                    display: true, // Menampilkan legenda
                    position: 'top' // Posisi legenda
                }
            },
            scales: {
                y: {
                    beginAtZero: true // Memulai sumbu Y dari 0
                }
            }
        }
    });
});
