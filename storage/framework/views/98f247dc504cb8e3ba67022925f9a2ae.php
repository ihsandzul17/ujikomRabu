<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="icon" type="image/png" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('/images/bc-landing.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            margin: 0;
            color: white;
        }

        .overlay-container {
            background: rgba(0, 0, 0, 0.6);
            min-height: 100vh;
            padding-top: 80px;
            padding-bottom: 40px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-custom {
            font-size: 1.2rem;
            padding: 10px 30px;
            border-radius: 5px;
        }

        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        canvas {
            border: 1px solid #ddd;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px 0;
            text-align: center;
            color: #ccc;
        }

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="Logo" width="30" height="30"
                    class="d-inline-block align-text-top">
                Pengaduan Masyarakat
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-danger ms-2" style="margin-right: -70px">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Landing Content -->
    <div class="overlay-container">
        <div class="container">
            <h1>Selamat Datang di Website Pengaduan Masyarakat</h1>
            <p class="lead">Laporkan keluhan Anda dengan mudah dan cepat.</p>
        </div>
    </div>

    <section class="py-5 bg-dark bg-opacity-75 text-white">
        <div class="container text-center">
            <h2 class="mb-4">Statistik Pengaduan</h2>
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <canvas id="barChart" height="200"></canvas>
                </div>
                <div class="col-md-6 mb-4">
                    <canvas id="pieChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pengaduanDitanggapi = <?php echo e($pengaduanDitanggapi); ?>;
        const belumDitanggapi = <?php echo e($belumDitanggapi); ?>;
        const pengaduanDitolak = <?php echo e($pengaduanDitolak); ?>;

        // Bar Chart
        const ctxBar = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Pengaduan Ditanggapi', 'Belum Ditanggapi', 'Pengaduan Ditolak'],
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: [pengaduanDitanggapi, belumDitanggapi, pengaduanDitolak],
                    backgroundColor: ['#4caf50', '#ff9800', '#f44336'],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($provinceNames, 15, 512) ?>,
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: <?php echo json_encode($provinceCounts, 15, 512) ?>,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#E7E9ED'
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: '7 Provinsi dengan Pengaduan Terbanyak'
                    }
                }
            }
        });
    </script>


    <!-- Footer -->
    <footer>
        &copy; <?php echo e(date('Y')); ?> Website Pengaduan Masyarakat. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH C:\ukk-pengaduan\resources\views/home.blade.php ENDPATH**/ ?>